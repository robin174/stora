<?php
/**
* Template Name: Page - Drag and Drop V3
* @package stora
*/

get_header(); ?>

<section class="templ--page-drag">
	<div class="container">
        <div class="row">
            <div class="col-12">
                <div style="padding: 30px 0">
                    <h3>This version is the correct flow from Airtable -> Backend (node) to Frontend.</h3>
                    <h4>Locally, remember to spin-up app.js (backend) to pull in prices.</h4>
                </div>
            </div>

            <div class="col-2">
                <section class="mol--columns">
                    <h3>Status quo (cloud costs)</h3>
                </section>
                <div>
                    <p>Next step:</p>
                    <ul>
                        <li>Working in VSC</li>
                        <li>Re-introduce drag and drop</li>
                        <li>Modal, set number and select system</li>
                        <li>Implement simple 'total cost' with card</li>
                        <li>Design! And that will be that.</li>
                    </ul>
                </div>
            </div>

            <div class="col-8">
                <section class="mol--columns">
                    <div class="row justify-content-center col-head">
                        <div class="col"><h2>Cloud</h2></div>
                        <div class="col"><h2>Decentralized</h2></div>
                        <div class="col"><h2>On Prem</h2></div>
                    </div>
                    <div class="row justify-content-center" data-row="1">
                        <div class="col" data-column="1">
                            <?php /* get_template_part('template-parts/card-drag', null, ['card_id' => 1]); */ ?>
                            <?php get_template_part('template-parts/card-modal', null, ['card_id' => 1, 'card_title' => 'Cloud Storage', 'card_number' => '10']); ?>
                        </div>
                        <div class="col" data-column="2">
                            <?php get_template_part('template-parts/card-modal', null, ['card_id' => 2, 'card_title' => 'Decentralized Storage', 'card_number' => '20']); ?>
                        </div>
                        <div class="col" data-column="3"></div>
                    </div>
                </section>
            </div>

            <!-- 
            So we need this structure in place. Where we have columns and rows. 
            And then we want to pull in the right template 'card' - we have this version and then we have the new modal version. 
            Separation of concerns.
            -->

            <?php /*
            <div class="col-8">
                <section class="mol--columns">
                    <div class="row justify-content-center col-head">
                        <div class="col"><h2>Cloud</h2></div>
                        <div class="col"><h2>Decentralized</h2></div>
                        <div class="col"><h2>On Prem</h2></div>
                    </div>
                    <div class="row justify-content-center" data-row="1">
                        <div class="col col-4" data-column="1">
                            <div class="card" draggable="true" data-value="10" data-card="1">
                                <!-- Card is populated via the JavaScript -->
                            </div>
                        </div>
                        <div class="col" data-column="2"></div>
                        <div class="col" data-column="3"></div>
                    </div>
                    <div class="row justify-content-center" data-row="2">
                        <div class="col" data-column="1">
                            <div class="card" draggable="true" data-value="20" data-card="2">
                                <!-- Card is populated via the JavaScript -->
                            </div>
                        </div>
                        <div class="col" data-column="2"></div>
                        <div class="col" data-column="3"></div>
                    </div>
                    <div class="row justify-content-center" data-row="3">
                        <div class="col" data-column="1">
                            <div class="card" draggable="true" data-value="30" data-card="3">
                                <!-- Card is populated via the JavaScript -->
                            </div>
                        </div>
                        <div class="col" data-column="2"></div>
                        <div class="col" data-column="3"></div>
                    </div>
                    <div class="row justify-content-center" data-row="4">
                        <div class="col" data-column="1">
                            <div class="card" draggable="true" data-value="30" data-card="4">
                                <!-- Card is populated via the JavaScript -->
                            </div>
                        </div>
                        <div class="col" data-column="2"></div>
                        <div class="col" data-column="3"></div>
                    </div>
                    <div class="row justify-content-center" data-row="5">
                        <div class="col" data-column="1">
                            <div class="card" draggable="true" data-value="45" data-card="5">
                                <!-- Card is populated via the JavaScript -->
                            </div>
                        </div>
                        <div class="col" data-column="2"></div>
                        <div class="col" data-column="3"></div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col">
                            <div id="total-column-1"></div>
                        </div>
                        <div class="col">
                            <div id="total-column-2"></div>
                        </div>
                        <div class="col">
                            <div id="total-column-3"></div>
                        </div>
                    </div>
                </section>
            </div>

            */ ?>

            <section class="mol--columns">
                <h3>Row calculations</h3>
            </section>
            </div>
        </div>  
	</div>
</section>

<!-- Modal HTML -->
<div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cardModalLabel">Edit Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cardForm">
                    <div class="mb-3">
                        <label for="cardTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="cardTitle">
                    </div>
                    <div class="mb-3">
                        <label for="cardNumber" class="form-label">Number of TBs</label>
                        <input type="number" class="form-control" id="cardNumber" min="0">
                    </div>
                    <div class="mb-3">
                        <label for="cardProvider" class="form-label">Provider</label>
                        <select class="form-select" id="cardProvider">
                            <option value="0">Please select</option>
                            <!-- Options will be populated dynamically -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveCardButton">Save and close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var cardModalEl = document.getElementById("cardModal");
        var cardModal = new bootstrap.Modal(cardModalEl, { backdrop: 'static' });
        var currentCard = null;

        // Attach event listener only to "Edit" button, NOT the whole card
        document.querySelectorAll(".btn-edit-card").forEach(function (button) {
            button.addEventListener("click", function (event) {
                event.stopPropagation(); // Prevent clicking the card from triggering modal

                currentCard = this.closest(".card"); // Get the card the button is inside

                var cardTitle = currentCard.querySelector(".card-title").textContent;
                var cardNumber = currentCard.querySelector(".card-text").textContent.replace("Number: ", "");

                document.getElementById("cardTitle").value = cardTitle;
                document.getElementById("cardNumber").value = cardNumber;

                cardModal.show(); // ✅ Correct Bootstrap way to open modal
            });
        });

        // Save and close button functionality
        document.getElementById("saveCardButton").addEventListener("click", function () {
            if (!currentCard) {
                console.warn("No card selected before saving.");
                return;
            }

            var cardTitle = document.getElementById("cardTitle").value;
            var cardNumber = document.getElementById("cardNumber").value;

            if (currentCard.querySelector(".card-title")) {
                currentCard.querySelector(".card-title").textContent = cardTitle;
            }
            if (currentCard.querySelector(".card-text")) {
                currentCard.querySelector(".card-text").textContent = `Number: ${cardNumber}`;
            }

            cardModal.hide();
        });
    });
</script>

<?php get_footer(); ?>