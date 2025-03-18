<?php
/**
* Template Name: Page - Compare Storage
* @package stora
*/

get_header(); ?>

<section class="templ--page-drag">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div style="padding: 30px 0">
                    <h3>Welcome to Stora Compare.</h3>
                    <p>Input your current and future costs to determine the potential stroage savings.</p>
                </div>
            </div>

            <!-- Current Cloud Costs Column -->
            <div class="col-3">
                <section class="mol--artboard">

                    <div class="row col-head">
                        <div class="col">
                            <h2>Cloud</h2>
                            <p>Input your current cloud costs.</p>
                        </div>
                    </div>

                    <div class="cloud-costs-column">
                        <div id="cloud-costs-container">

                            <!-- Cloud cost cards -->
                            <?php for ($i = 1; $i <= 3; $i++) : ?>
                                <div class="row">
                                    <div class="col">
                                        <div class="card" data-type="Cloud" data-card-id="cloud-<?php echo $i; ?>">
                                            <h3 class="card-title">Current Storage 0<?php echo $i; ?></h3>
                                            <span class="card-provider">Provider: <b>None</b></span>
                                            <span class="card-text">TB: 0</span>
                                            <span class="card-cost">Total Cost: $0.00</span>
                                            <button class="btn btn-primary btn-sm btn-edit-card" data-card-id="cloud-<?php echo $i; ?>">Edit</button>
                                        </div>
                                    </div>
                                </div>
                            <?php endfor; ?>

                        </div>
                    </div>

                    <div class="row col-foot">
                        <!-- Total Cost Calculation for Current Cloud Costs -->
                        <div class="col">
                            <div class="total-costs">
                                <span class="atmTotal">Total Current Cloud Cost</span>
                                <span class="atmTotalCost" id="total-current-cloud-cost">$0.00</span>
                            </div>
                        </div>
                    </div>
                
                </section>
            </div>

            <!-- Main Drag-and-Drop Section -->
            <div class="col-9 orgDrag">
                <section class="mol--artboard">

                    <div class="row col-head">
                        <div class="col" data-column="1">
                            <h2>Cloud</h2>
                            <p>Establish future costs.</p>
                        </div>
                        <div class="col" data-column="2">
                            <h2>Decentralized</h2>
                            <p>Establish future costs.</p>
                        </div>
                        <div class="col" data-column="3">
                            <h2>On-Prem</h2>
                            <p>Establish future costs.</p>
                        </div>
                    </div>

                    <div class="comparison-costs-column">
                        <!-- Row 1 -->
                        <div class="row" data-row="1">
                            <div class="col" data-column="1">
                                <?php 
                                    get_template_part('template-parts/card-modal', null, [
                                        'card_id' => 1, 
                                        'card_title' => 'Future Storage 01', 
                                        'card_number' => '0', 
                                        'card_type' => 'Cloud'
                                    ]); 
                                ?>
                            </div>
                            <div class="col" data-column="2"></div>
                            <div class="col" data-column="3"></div>
                        </div>

                        <!-- Row 2 -->
                        <div class="row" data-row="2">
                            <div class="col" data-column="1">
                                <?php 
                                    get_template_part('template-parts/card-modal', null, [
                                        'card_id' => 2, 
                                        'card_title' => 'Future Storage 02', 
                                        'card_number' => '0', 
                                        'card_type' => 'Cloud'
                                    ]); 
                                ?>
                            </div>
                            <div class="col" data-column="2"></div>
                            <div class="col" data-column="3"></div>
                        </div>

                        <!-- Row 3 -->
                        <div class="row" data-row="3">
                            <div class="col" data-column="1">
                                <?php 
                                    get_template_part('template-parts/card-modal', null, [
                                        'card_id' => 3, 
                                        'card_title' => 'Future Storage 03', 
                                        'card_number' => '0', 
                                        'card_type' => 'Cloud'
                                    ]); 
                                ?>
                            </div>
                            <div class="col" data-column="2"></div>
                            <div class="col" data-column="3"></div>
                        </div>
                    </div>

                    <!-- Total Calculation Row -->
                    <div class="row col-foot total-cost-row">
                        <div class="col" data-column="1">
                            <span class="atmTotal">Total Cloud Cost</span><span class="atmTotalCost" id="total-cloud-cost">$0.00</span>
                        </div>
                        <div class="col" data-column="2">
                            <span class="atmTotal">Total Decentralized Cost</span><span class="atmTotalCost" id="total-decentralized-cost">$0.00</span>
                        </div>
                        <div class="col" data-column="3">
                            <span class="atmTotal">Total On-Prem Cost</span><span class="atmTotalCost" id="total-onprem-cost">$0.00</span>
                        </div>
                    </div>
                </section>
            </div>
        </div>  
    </div>
</section>

<!-- Comparison Section -->
<section class="cost-comparison">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-3 molTotalCost01 d-flex flex-column align-items-start justify-content-center">
                <!-- 
                <h3>Total Current Cloud Cost</h3>
                <p class="cost-value" id="total-current-cloud-cost">$0.00</p>
                -->
            </div>
            <div class="col-6 molTotalCost02 d-flex flex-column align-items-start justify-content-center">
                <h3>Total Cloud + Decentralized + On-Prem Cost</h3>
                <p class="cost-value" id="total-new-cost">$0.00</p>
            </div>
            <div class="col-3 molTotalCost03 d-flex flex-column align-items-start justify-content-center">
                <h3>Cost Difference</h3>
                <p class="cost-value" id="cost-difference">$0.00</p>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div style="padding: 30px 0; font-size: 0.8rem;">
                    <h6>Version 0.3.1</h6>
                    <span class="d-block">This version is the correct flow from Airtable -> Backend (Node) to Frontend.</span>
                    <span class="d-block">Locally, remember to spin up app.js (backend) to pull in prices..</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Storage specifics</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cardForm">
                    <!-- Fields shown for Cloud & Decentralized storage -->
                    <div class="mb-3 storage-fields">
                        <label for="cardProvider" class="form-label">Provider</label>
                        <select class="form-select" id="cardProvider">
                            <option value="0">- Please select</option>
                        </select>
                    </div>

                    <div class="mb-3 storage-fields">
                        <label for="cardNumber" class="form-label">Number of TBs</label>
                        <input type="number" class="form-control" id="cardNumber" min="0">
                    </div>

                    <!-- Fields shown only for On-Prem storage -->
                    <div class="mb-3 onprem-fields" style="display: none;">
                        <label for="costPerServer" class="form-label">Cost per Server (USD)</label>
                        <input type="number" class="form-control" id="costPerServer" min="0">
                    </div>

                    <div class="mb-3 onprem-fields" style="display: none;">
                        <label for="numberOfServers" class="form-label">Number of Servers</label>
                        <input type="number" class="form-control" id="numberOfServers" min="0">
                    </div>
                    <p id="calculatedCost">Total Cost: $0.00</p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-sm" id="saveCardButton">Save and Close</button>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>