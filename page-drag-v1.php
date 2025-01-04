<?php
/**
* Template Name: Page - Drag and Drop V1
* @package stora
*/

get_header(); ?>

<section class="templ--page-drag">
	<div class="container">
        <div class="row">
            <div class="col-2">
                <h3>Status quo (cloud costs)</h3>
            </div>
            <div class="col-8">
                <div class="row">
                    <div class="col-head"><h2>Cloud</h2></div>
                    <div class="col-head"><h2>Decentralized</h2></div>
                    <div class="col-head"><h2>On Prem</h2></div>
                </div>
                <div class="row" data-row="1">
                    <div class="column" data-column="1">
                        <div class="card" draggable="true" data-value="10" data-card="1">
                            <h3></h3>
                            <h4></h4>
                        </div><!-- I think modal is too much... have the option to update design of card for each column.
                        So if sits in decentralized pulls in suppliers, and set how much data download (just one for simplicity). 
                        Pulls in respect cost + TB x cost for final cost-->
                    </div>
                    <div class="column" data-column="2"></div>
                    <div class="column" data-column="3"></div>
                    
                </div>
                <div class="row" data-row="2">
                    <div class="column" data-column="1">
                        <div class="card" draggable="true" data-value="20" data-card="2">
                            <h3></h3>
                            <h4></h4>
                        </div>
                    </div>
                    <div class="column" data-column="2"></div>
                    <div class="column" data-column="3"></div>
                </div>
                <div class="row" data-row="3">
                    <div class="column" data-column="1">
                        <div class="card" draggable="true" data-value="30" data-card="3">
                            <h3></h3>
                            <h4></h4>
                        </div>
                    </div>
                    <div class="column" data-column="2"></div>
                    <div class="column" data-column="3"></div>
                </div>
                <div class="row" data-row="4">
                    <div class="column" data-column="1">
                        <div class="card" draggable="true" data-value="30" data-card="4">
                            <h3></h3>
                            <h4></h4>
                        </div>
                    </div>
                    <div class="column" data-column="2"></div>
                    <div class="column" data-column="3"></div>
                </div>
                <div class="row" data-row="5">
                    <div class="column" data-column="1">
                        <div class="card" draggable="true" data-value="45" data-card="5">
                            <h3></h3>
                            <h4></h4>
                        </div>
                    </div>
                    <div class="column" data-column="2"></div>
                    <div class="column" data-column="3"></div>
                </div>
                <div class="row">
                    <div class="column">
                        <div id="total-column-1"></div>
                    </div>
                    <div class="column">
                        <div id="total-column-2"></div>
                    </div>
                    <div class="column">
                        <div id="total-column-3"></div>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <h3>Row calculations</h3>
            </div>
        </div>  
	</div>
    
</section>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const cards = document.querySelectorAll(".card");
        const columns = document.querySelectorAll(".column");

        // Define column titles
        const columnTitles = {
            "1": "Cloud",
            "2": "Decentralized",
            "3": "On-Prem"
        };

         // Define select box options for each column
        const selectOptions =  {
            "1": ["AWS", "Google", "Azure"],
            "2": ["Storj", "IPFS", "NeoFS"]
        };

        // This can become a manual demo if that helps?

        // Initialize each card's title and add select box if in Column 1 or 2
        cards.forEach(card => {
                const startingColumn = card.closest(".column").dataset.column;
                updateCardTitle(card, startingColumn);

                card.addEventListener("dragstart", dragStart);
            });

            columns.forEach(column => {
                column.addEventListener("dragover", dragOver);
                column.addEventListener("drop", drop);
            });

            function dragStart(event) {
                event.dataTransfer.setData("text/plain", event.target.dataset.card);
                const sourceRow = event.target.closest(".row").dataset.row;
                event.dataTransfer.setData("source-row", sourceRow);
            }

            function dragOver(event) {
                event.preventDefault(); // Necessary to allow dropping
            }

            function drop(event) {
                const draggedCardId = event.dataTransfer.getData("text/plain");
                const sourceRow = event.dataTransfer.getData("source-row");
                const targetRow = event.currentTarget.closest(".row").dataset.row;
                const targetColumn = event.currentTarget.dataset.column;

                // Only allow moves within the same row
                if (sourceRow === targetRow) {
                    const card = document.querySelector(`.card[data-card="${draggedCardId}"]`);
                    event.currentTarget.appendChild(card);

                    // Update card title and add/remove select box based on the target column
                    updateCardTitle(card, targetColumn);

                    // Recalculate totals for each column
                    updateColumnTotals();
                }
            }

            function updateCardTitle(card, columnNumber) {
                const title = columnTitles[columnNumber];
                if (title) {
                    const cardValue = card.dataset.value;
                    
                    // Create card content with title and value
                    let content = `<h3>Card ${card.dataset.card} - ${title}</h3><h4>${cardValue}</h4>`;
                    
                    // Add the select box if the card is in Column 1 or Column 2
                    if (selectOptions[columnNumber]) {
                        content += createSelectBox(selectOptions[columnNumber]);
                    }

                    card.innerHTML = content;
                }
            }

            function createSelectBox(options) {
                // Create HTML for select box with specified options
                let selectHTML = `<select>`;
                options.forEach(option => {
                    selectHTML += `<option value="${option}">${option}</option>`;
                });
                selectHTML += `</select>`;
                return selectHTML;
            }

            function updateColumnTotals() {
                // Loop over each column and calculate the sum of card values
                for (const [columnNumber, title] of Object.entries(columnTitles)) {
                    const columnCards = document.querySelectorAll(`.column[data-column="${columnNumber}"] .card`);
                    let total = 0;

                    columnCards.forEach(card => {
                        const cardValue = parseInt(card.dataset.value, 10);
                        total += cardValue;
                    });

                    // Update the total display for each column
                    const totalDisplay = document.getElementById(`total-column-${columnNumber}`);
                    totalDisplay.textContent = `${title} cost: ${total}`;
                }
            }

            // Initial total calculation
            updateColumnTotals();
        });
</script>

<?php get_footer(); ?>