<?php
/**
* Template Name: Page - Stora V1
* @package stora
*/

get_header(); ?>

<section class="templ--page-main">
	<div class="container">
		<div class="row g-5">

            <!-- Version 03 Caculate price -->
            <div class="col-6">
                <h4>STATUS QUO</h4>
                <form id="productForm">
                    <label for="product">Right now, I store our data:</label>
                    <div class="input-group">
                        <select class="form-select" id="productSelect" name="product"><!-- reorder as per X, and only show trad/web2 -->
                            <!-- Options will be populated dynamically here -->
                        </select>
                    </div>
                    
                    <label for="storeUnits">Over the course of 12 months, I store:</label>
                    <div class="input-group">
                        <input type="number" id="storeUnits" name="storeUnits" placeholder="Amount of data stored (TB)" class="form-control" aria-label="Terrabytes" min="0" required>
                        <span class="input-group-text">TB</span>
                    </div>
                
                    <label for="downloadUnits">of which, I estimate I download:</label>
                    <div class="input-group">
                        <input type="number" id="downloadUnits" name="downloadUnits" placeholder="Amount of data downloaded (TB)" class="form-control" aria-label="Terrabytes" min="0" required>
                        <span class="input-group-text">TB</span>
                    </div>
                    <button type="submit" class="btn atm--button-primary mt-2">Calculate cost</button>
                </form>
                <div id="result"></div>
            </div>

            <div class="col-6">
                <h4>THE FUTURE</h4>
                <label for="futureProvider">Allocate some storage to a decentralized provider:</label>
                <div class="input-group">
                    <select class="form-select" id="futureProvider">
                        <!-- Future provider options will be populated dynamically -->
                    </select>
                </div>
                
                <label for="allocationPercentage">Allocate the following percentage to the new provider:</label>
                <div class="input-group">
                    <input type="number" id="allocationPercentage" placeholder="Percentage allocation" class="form-control" min="0" max="100" required>
                    <span class="input-group-text">%</span>
                </div>
                <button id="calculateFutureCost" class="btn atm--button-primary mt-2">Calculate revised cost</button>
                <div id="futureResult"></div>
            </div>

		</div>
	</div>
</section>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/stora01.js?version=1.1"></script>

<?php get_footer(); ?>