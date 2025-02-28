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
                    <h3>This version is the correct flow from Airtable -> Backend (Node) to Frontend.</h3>
                    <p>Locally, remember to spin up app.js (backend) to pull in prices..</p>
                    <!-- 
                        1. Origin column?
                        2. Implement a sample design
                        3. Loading aspect to the data coming in... issue on live
                    -->
                </div>
            </div>

            <div class="col-3">
                <section class="mol--columns">
                    <h3>Current Cloud Costs</h3>
                </section>
            </div>

            <div class="col-9">
                <section class="mol--columns">
                    <div class="row justify-content-center col-head">
                        <div class="col" data-column="1"><h2>Cloud</h2></div>
                        <div class="col" data-column="2"><h2>Decentralized</h2></div>
                        <div class="col" data-column="3"><h2>On-Prem</h2></div>
                    </div>

                    <!-- Row 1 -->
                    <div class="row justify-content-center" data-row="1">
                        <div class="col" data-column="1">
                            <?php 
                                get_template_part('template-parts/card-modal', null, [
                                    'card_id' => 1, 
                                    'card_title' => 'Cloud Storage', 
                                    'card_number' => '10', 
                                    'card_type' => 'Cloud'
                                ]); 
                            ?>
                        </div>
                        <div class="col" data-column="2"></div>
                        <div class="col" data-column="3"></div>
                    </div>

                    <!-- Row 2 -->
                    <div class="row justify-content-center" data-row="2">
                        <div class="col" data-column="1">
                            <?php 
                                get_template_part('template-parts/card-modal', null, [
                                    'card_id' => 2, 
                                    'card_title' => 'Decentralized Storage', 
                                    'card_number' => '10', 
                                    'card_type' => 'Cloud'
                                ]); 
                            ?>
                        </div>
                        <div class="col" data-column="2"></div>
                        <div class="col" data-column="3"></div>
                    </div>

                    <!-- Row 3 -->
                    <div class="row justify-content-center" data-row="3">
                        <div class="col" data-column="1">
                            <?php 
                                get_template_part('template-parts/card-modal', null, [
                                    'card_id' => 3, 
                                    'card_title' => 'On-Prem Storage', 
                                    'card_number' => '10', 
                                    'card_type' => 'Cloud'
                                ]); 
                            ?>
                        </div>
                        <div class="col" data-column="2"></div>
                        <div class="col" data-column="3"></div>
                    </div>

                    <!-- Total Calculation Row -->
                    <div class="row justify-content-center total-cost-row">
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
                    <div class="mb-3">
                        <label for="cardTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="cardTitle">
                    </div>
                    <div class="mb-3">
                        <label for="cardProvider" class="form-label">Provider</label>
                        <select class="form-select" id="cardProvider">
                            <option value="0">- Please select</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cardNumber" class="form-label">Number of TBs</label>
                        <input type="number" class="form-control" id="cardNumber" min="0">
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