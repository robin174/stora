console.log("API URL being used:", wpData.api_url);

document.addEventListener("DOMContentLoaded", async function () {
    const cardModalEl = document.getElementById("cardModal");
    const cardModal = new bootstrap.Modal(cardModalEl, { backdrop: 'static' });
    let currentCard = null;
    let airtableData = [];

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

    // Enable Dragging on All Cards (except for Current Cloud Costs)
    document.querySelectorAll(".card").forEach(card => {
        if (!card.closest(".cloud-costs-column")) {
            card.setAttribute("draggable", true);

            card.addEventListener("dragstart", function (event) {
                event.dataTransfer.setData("text/plain", card.dataset.cardId);
                event.dataTransfer.effectAllowed = "move";
            });

            card.addEventListener("DOMSubtreeModified", updateTotalCosts);
        }
    });

    // Enable Drop Areas (Only within the same row)
    document.querySelectorAll(".row[data-row] .col[data-column]").forEach(column => {
        column.addEventListener("dragover", event => event.preventDefault());
        
        column.addEventListener("drop", function (event) {
            event.preventDefault();
            const cardId = event.dataTransfer.getData("text/plain");
            const card = document.querySelector(`[data-card-id="${cardId}"]`);
            if (!card) return;

            // Ensure the card is being dropped in the same row
            const sourceRow = card.closest(".row[data-row]");
            const targetRow = column.closest(".row[data-row]");
            
            if (sourceRow !== targetRow) {
                console.log("Cards can only be moved left/right within the same row.");
                return; // Prevent dropping in a different row
            }

            column.appendChild(card);
            updateCardType(card, column.dataset.column);
            updateTotalCosts();
        });
    });

    // Update Card Type when moved
    function updateCardType(card, columnIndex) {
        const typeMapping = { "1": "Cloud", "2": "Decentralized", "3": "On Prem" };
        const newType = typeMapping[columnIndex] || "Unknown";
        card.dataset.type = newType;

        // Show On-Prem fields only if the card is moved to On-Prem
        if (newType === "On Prem") {
            document.querySelectorAll(".onprem-fields").forEach(field => field.style.display = "block");
        } else {
            document.querySelectorAll(".onprem-fields").forEach(field => field.style.display = "none");
        }
    }

    // Update Total Costs
    function updateTotalCosts() {
        let cloudTotal = 0, decentralizedTotal = 0, onPremTotal = 0, currentCloudTotal = 0;

        document.querySelectorAll(".card").forEach(card => {
            let cost = parseFloat(card.querySelector(".card-cost").textContent.replace("Total Cost: $", "")) || 0;
            let type = card.dataset.type;

            if (card.closest(".cloud-costs-column")) {
                currentCloudTotal += cost;
            } else {
                switch (type) {
                    case "Cloud": cloudTotal += cost; break;
                    case "Decentralized": decentralizedTotal += cost; break;
                    case "On Prem": onPremTotal += cost; break;
                }
            }
        });

        const totalNewCosts = cloudTotal + decentralizedTotal + onPremTotal;
        const costDifference = currentCloudTotal - totalNewCosts;

        document.getElementById("total-cloud-cost").textContent = `$${cloudTotal.toFixed(2)}`;
        document.getElementById("total-decentralized-cost").textContent = `$${decentralizedTotal.toFixed(2)}`;
        document.getElementById("total-onprem-cost").textContent = `$${onPremTotal.toFixed(2)}`;
        document.getElementById("total-current-cloud-cost").textContent = `$${currentCloudTotal.toFixed(2)}`;
        document.getElementById("total-new-cost").textContent = `$${totalNewCosts.toFixed(2)}`;

        // Update cost difference
        const costDifferenceEl = document.getElementById("cost-difference");
        costDifferenceEl.textContent = `$${Math.abs(costDifference).toFixed(2)}`;
        costDifferenceEl.style.color = costDifference > 0 ? "green" : "red";
    }

    // Open Modal and Populate Fields
    document.querySelectorAll(".btn-edit-card").forEach(button => {
        button.addEventListener("click", function () {
            currentCard = this.closest(".card");
            const cardTitle = currentCard.querySelector(".card-title").textContent;
            const cardNumber = currentCard.querySelector(".card-text").textContent.replace("Number: ", "");
            const cardProvider = currentCard.querySelector(".card-provider").textContent.replace("Provider: ", "");
            const cardType = currentCard.dataset.type;

            document.getElementById("cardTitle").value = cardTitle;
            document.getElementById("cardNumber").value = cardNumber;
            document.getElementById("cardProvider").innerHTML = `<option value="0">Loading...</option>`;

            populateProviders(cardType, cardProvider);
            updateCalculatedCost();

            // Show On-Prem fields if applicable
            const isOnPrem = cardType === "On Prem";
            document.querySelectorAll(".onprem-fields").forEach(field => field.style.display = isOnPrem ? "block" : "none");

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
            if (selectedProvider && provider.provider === selectedProvider) option.selected = true;
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
        let calculatedCost = quantity * pricePerTB;

        // Handle On-Prem Cost Calculation
        if (currentCard && currentCard.dataset.type === "On Prem") {
            const costPerServer = parseFloat(document.getElementById("costPerServer").value) || 0;
            const numberOfServers = parseInt(document.getElementById("numberOfServers").value, 10) || 0;
            calculatedCost = costPerServer * numberOfServers;
        }

        document.getElementById("calculatedCost").textContent = `Total Cost: $${calculatedCost.toFixed(2)}`;
    }

    document.getElementById("cardProvider").addEventListener("change", updateCalculatedCost);
    document.getElementById("cardNumber").addEventListener("input", updateCalculatedCost);
    document.getElementById("costPerServer").addEventListener("input", updateCalculatedCost);
    document.getElementById("numberOfServers").addEventListener("input", updateCalculatedCost);

    // Save and Close Modal
    document.getElementById("saveCardButton").addEventListener("click", function () {
        if (!currentCard) return;

        const cardTitle = document.getElementById("cardTitle").value;
        const providerSelect = document.getElementById("cardProvider");
        const selectedProvider = providerSelect.value;
        let totalCost = parseFloat(document.getElementById("calculatedCost").textContent.replace("Total Cost: $", "")) || 0;

        currentCard.querySelector(".card-title").textContent = cardTitle;
        currentCard.querySelector(".card-provider").textContent = `Provider: ${selectedProvider}`;
        currentCard.querySelector(".card-cost").textContent = `Total Cost: $${totalCost.toFixed(2)}`;

        updateTotalCosts();
        cardModal.hide();
    });

    await fetchAirtableData();
});