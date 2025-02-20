// Test
console.log("API URL being used:", wpData.api_url);

document.addEventListener("DOMContentLoaded", async () => {
    const columns = document.querySelectorAll(".col");

    // Define column titles
    const columnTitles = {
        "1": "Cloud",
        "2": "Decentralized",
        "3": "On-Prem"
    };

    let airtableData = [];

    console.log("Fetching from API URL:", wpData.api_url);

    // Fetch data from Airtable
    async function fetchAirtableData() {
        try {
            const response = await fetch(wpData.api_url);
            if (!response.ok) throw new Error("Failed to fetch data from API");

            airtableData = await response.json(); // Store the data globally
            return airtableData;
        } catch (error) {
            console.error(error.message);
            return [];
        }
    }

    // Initialize cards
    async function initializeCards() {
        airtableData = await fetchAirtableData();

        columns.forEach(column => {
            const columnNumber = column.dataset.column;
            const columnTitle = columnTitles[columnNumber];
            const relevantData = airtableData.filter(item => item.type === columnTitle);

            const cards = column.querySelectorAll(".card");
            cards.forEach(card => {
                updateCardContent(card, relevantData, columnNumber);
            });
        });

        updateColumnTotals();
    }

    function updateCardContent(card, data, columnNumber) {
        const selectHTML = createSelectBox(data.map(item => item.provider));
        card.dataset.value = "0"; // Default cost when "Please select" is chosen

        card.innerHTML = `
            <h3 class="provider">Select a provider</h3>
            <h4 class="cost">$0 / TB download</h4>
            ${selectHTML}
            <div>
                <label for="quantity-${card.dataset.card}">Quantity (TB):</label>
                <input type="number" id="quantity-${card.dataset.card}" class="quantity-input" min="0" value="1">
            </div>
            <p class="calculated-cost">Calculated Cost: $0</p>
        `;

        const selectElement = card.querySelector("select");
        const quantityInput = card.querySelector(".quantity-input");
        const calculatedCostDisplay = card.querySelector(".calculated-cost");

        // Update card when provider is changed
        selectElement.addEventListener("change", (event) => {
            const selectedProvider = event.target.value;
            if (selectedProvider === "0") {
                // Reset to default when "Please select" is chosen
                card.dataset.value = "0";
                card.querySelector("h3.provider").textContent = `Select a provider`;
                card.querySelector("h4.cost").textContent = `$0 / TB download`;
                updateCalculatedCost(quantityInput, 0, calculatedCostDisplay);
            } else {
                const providerData = data.find(item => item.provider === selectedProvider);
                if (providerData) {
                    card.dataset.value = providerData.price;
                    card.querySelector("h3.provider").textContent = `${providerData.provider} - ${columnTitles[columnNumber]}`;
                    card.querySelector("h4.cost").textContent = `$${providerData.price} / TB download`;
                    updateCalculatedCost(quantityInput, providerData.price, calculatedCostDisplay);
                }
            }
            updateColumnTotals();
        });

        // Update calculated cost when quantity is changed
        quantityInput.addEventListener("input", () => {
            const providerPrice = parseInt(card.dataset.value, 10) || 0;
            updateCalculatedCost(quantityInput, providerPrice, calculatedCostDisplay);
            updateColumnTotals();
        });
    }

    // Function to update the calculated cost
    function updateCalculatedCost(quantityInput, pricePerTB, calculatedCostDisplay) {
        const quantity = parseInt(quantityInput.value, 10) || 0;
        const calculatedCost = quantity * pricePerTB;
        calculatedCostDisplay.textContent = `Calculated Cost: $${calculatedCost}`;
    }

    // Create dropdown HTML with a "Please select" option
    function createSelectBox(options) {
        console.log("Creating select box with options:", options);
        let selectHTML = `<select>`;
        selectHTML += `<option value="0">Please select</option>`; // Add default "Please select" option
        options.forEach(option => {
            selectHTML += `<option value="${option}">${option}</option>`;
        });
        selectHTML += `</select>`;
        return selectHTML;
    }

    // Update column totals
    function updateColumnTotals() {
        for (const [columnNumber, title] of Object.entries(columnTitles)) {
            const columnCards = document.querySelectorAll(`.col[data-column="${columnNumber}"] .card`);
            let total = 0;

            columnCards.forEach(card => {
                const quantityInput = card.querySelector(".quantity-input");
                const quantity = parseInt(quantityInput?.value, 10) || 0;
                const pricePerTB = parseInt(card.dataset.value, 10) || 0;
                total += quantity * pricePerTB;
            });

            const totalDisplay = document.getElementById(`total-column-${columnNumber}`);
            totalDisplay.textContent = `${title} cost: $${total}`;
        }
    }

    // Drag-and-drop functionality
    columns.forEach(column => {
        column.addEventListener("dragover", dragOver);
        column.addEventListener("drop", drop);
    });

    function dragOver(event) {
        event.preventDefault(); // Allow drop
    }

    function drop(event) {
        event.preventDefault();

        const draggedCardId = event.dataTransfer.getData("text/plain");
        const card = document.querySelector(`.card[data-card="${draggedCardId}"]`);

        // Get the target column
        const targetColumn = event.currentTarget.dataset.column;
        const columnTitle = columnTitles[targetColumn];

        // Append the card to the new column
        event.currentTarget.appendChild(card);

        // Filter Airtable data for the new column type
        const relevantData = airtableData.filter(item => item.type === columnTitle); // column title has to match InfoType tag in Airtable e.g. 'Cloud' -> 'Cloud'

        // Update the card's content with the new column's data
        updateCardContent(card, relevantData, targetColumn);

        // Update totals
        updateColumnTotals();
    }

    // Attach dragstart event to all cards
    document.querySelectorAll(".card").forEach(card => {
        card.addEventListener("dragstart", (event) => {
            event.dataTransfer.setData("text/plain", card.dataset.card);
        });
    });

    // Initialize cards on page load
    await initializeCards();
});