// Test
console.log("API URL being used:", wpData.api_url);

document.addEventListener("DOMContentLoaded", async function () {
    var cardModalEl = document.getElementById("cardModal");
    var cardModal = new bootstrap.Modal(cardModalEl, { backdrop: 'static' });
    var currentCard = null;
    var airtableData = [];

    console.log("Fetching from API URL:", wpData.api_url);

    // Fetch Airtable Data
    async function fetchAirtableData() {
        try {
            const response = await fetch(wpData.api_url);
            if (!response.ok) throw new Error("Failed to fetch data from API");

            airtableData = await response.json();
            console.log("Fetched Airtable Data:", airtableData);
        } catch (error) {
            console.error(error.message);
        }
    }

    // Enable Dragging on All Cards
    document.querySelectorAll(".card").forEach(card => {
        card.setAttribute("draggable", true);

        card.addEventListener("dragstart", function (event) {
            event.dataTransfer.setData("text/plain", JSON.stringify({
                cardId: card.dataset.cardId,
                row: card.dataset.row
            }));
            event.dataTransfer.effectAllowed = "move";
            console.log("Dragging card ID:", card.dataset.cardId, "Row:", card.dataset.row);
        });

        // Recalculate total costs whenever a card's total cost changes
        card.addEventListener("DOMSubtreeModified", updateTotalCosts);
    });

    // Enable Drop Areas (Columns within the same row)
    document.querySelectorAll(".row[data-row]").forEach(row => {
        row.querySelectorAll(".col[data-column]").forEach(column => {
            column.addEventListener("dragover", function (event) {
                event.preventDefault(); // Allow drop
                event.dataTransfer.dropEffect = "move";
            });

            column.addEventListener("drop", function (event) {
                event.preventDefault();
                const data = JSON.parse(event.dataTransfer.getData("text/plain"));
                const card = document.querySelector(`[data-card-id="${data.cardId}"][data-row="${data.row}"]`);

                if (!card) return;

                // Move the card within the same row only
                if (row.dataset.row === data.row) {
                    column.appendChild(card);
                    updateCardType(card, column.dataset.column);
                    updateTotalCosts();
                }
            });
        });
    });

    // Update Card Type when moved
    function updateCardType(card, columnIndex) {
        let newType;
        if (columnIndex == "1") {
            newType = "Cloud";
        } else if (columnIndex == "2") {
            newType = "Decentralized";
        } else {
            newType = "On Prem";
        }

        card.dataset.type = newType;
    }

    // **Update Total Costs**
    function updateTotalCosts() {
        let cloudTotal = 0, decentralizedTotal = 0, onPremTotal = 0;

        document.querySelectorAll(".card").forEach(card => {
            let cost = parseFloat(card.querySelector(".card-cost").textContent.replace("Total Cost: $", "")) || 0;
            let type = card.dataset.type;

            if (type === "Cloud") {
                cloudTotal += cost;
            } else if (type === "Decentralized") {
                decentralizedTotal += cost;
            } else if (type === "On Prem") {
                onPremTotal += cost;
            }
        });

        document.getElementById("total-cloud-cost").textContent = `$${cloudTotal.toFixed(2)}`;
        document.getElementById("total-decentralized-cost").textContent = `$${decentralizedTotal.toFixed(2)}`;
        document.getElementById("total-onprem-cost").textContent = `$${onPremTotal.toFixed(2)}`;
    }

    // Open Modal and Populate Fields
    document.querySelectorAll(".btn-edit-card").forEach(button => {
        button.addEventListener("click", function (event) {
            event.stopPropagation();

            currentCard = this.closest(".card");
            const cardTitle = currentCard.querySelector(".card-title").textContent;
            const cardNumber = currentCard.querySelector(".card-text").textContent.replace("Number: ", "");
            const cardProvider = currentCard.querySelector(".provider-name").textContent;
            const cardType = currentCard.dataset.type;

            document.getElementById("cardTitle").value = cardTitle;
            document.getElementById("cardNumber").value = cardNumber;
            document.getElementById("cardProvider").innerHTML = `<option value="0">Loading...</option>`;

            populateProviders(cardType, cardProvider);
            updateCalculatedCost();

            cardModal.show();
        });
    });

    // Populate Providers Dynamically
    function populateProviders(cardType, selectedProvider = null) {
        const providerSelect = document.getElementById("cardProvider");
        providerSelect.innerHTML = `<option value="0">- Please select</option>`;

        const relevantData = airtableData.filter(item => item.type === cardType);

        relevantData.forEach(provider => {
            const option = document.createElement("option");
            option.value = provider.provider;
            option.dataset.price = provider.price;
            option.textContent = `${provider.provider} - $${provider.price} / TB`;

            if (selectedProvider && provider.provider === selectedProvider) {
                option.selected = true;
            }

            providerSelect.appendChild(option);
        });

        updateCalculatedCost();
    }

    // Update Cost Calculation
    function updateCalculatedCost() {
        const providerSelect = document.getElementById("cardProvider");
        const selectedOption = providerSelect.options[providerSelect.selectedIndex];
        const pricePerTB = selectedOption.dataset.price ? parseFloat(selectedOption.dataset.price) : 0;
        const quantity = parseInt(document.getElementById("cardNumber").value, 10) || 0;
        const calculatedCost = quantity * pricePerTB;

        document.getElementById("calculatedCost").textContent = `Total Cost: $${calculatedCost.toFixed(2)}`;
    }

    document.getElementById("cardProvider").addEventListener("change", updateCalculatedCost);
    document.getElementById("cardNumber").addEventListener("input", updateCalculatedCost);

    // Save and Close Modal - Ensures Provider and Total Cost are Updated
    document.getElementById("saveCardButton").addEventListener("click", function () {
        if (!currentCard) return;

        const cardTitle = document.getElementById("cardTitle").value;
        const providerSelect = document.getElementById("cardProvider");
        const selectedProvider = providerSelect.value;
        const providerPrice = providerSelect.options[providerSelect.selectedIndex].dataset.price || "0.00";
        const cardNumber = document.getElementById("cardNumber").value;
        const totalCost = (cardNumber * providerPrice).toFixed(2);

        console.log("Saving changes: ", {
            title: cardTitle,
            provider: selectedProvider,
            providerPrice: providerPrice,
            numberTBs: cardNumber,
            totalCost: totalCost
        });

        // Update card content
        currentCard.querySelector(".card-title").textContent = cardTitle;
        currentCard.querySelector(".provider-name").textContent = selectedProvider !== "0.00" ? selectedProvider : "No provider";
        currentCard.querySelector(".card-text").textContent = `Number: ${cardNumber}`;
        currentCard.querySelector(".card-cost").textContent = `Total Cost: $${totalCost}`;

        updateTotalCosts();
        cardModal.hide();
    });

    // Initial Data Fetch
    await fetchAirtableData();
});