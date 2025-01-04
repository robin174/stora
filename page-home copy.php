<?php
/**
* Template Name: Page - Home
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

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        try {
            const response = await fetch('http://localhost:3000/get-products');
            const products = await response.json();

            if (response.ok) {
                const productSelect = document.getElementById('productSelect');
                const futureProviderSelect = document.getElementById('futureProvider');

                // Create and add the default 'Select provider' option
                const defaultOptionCloud = document.createElement('option');
                defaultOptionCloud.value = '';  // Typically, an empty value for a placeholder option
                defaultOptionCloud.textContent = 'Select cloud provider';
                defaultOptionCloud.disabled = true;  // Makes sure this option can't be selected
                defaultOptionCloud.selected = true;  // Shows this option as selected by default
                productSelect.appendChild(defaultOptionCloud);

                const defaultOptionDecentral = document.createElement('option');
                defaultOptionDecentral.value = '';
                defaultOptionDecentral.textContent = 'Select decentralized provider';
                defaultOptionDecentral.disabled = true;
                defaultOptionDecentral.selected = true;
                futureProviderSelect.appendChild(defaultOptionDecentral);

                // Populate Cloud products for the 'STATUS QUO' section
                products.cloud.forEach(product => {
                    const option = document.createElement('option');
                    option.value = product.name;
                    option.textContent = product.name;
                    productSelect.appendChild(option);
                });

                // Populate Decentral products for the 'THE FUTURE' section
                products.decentral.forEach(product => {
                    const option = document.createElement('option');
                    option.value = product.name;
                    option.textContent = product.name;
                    futureProviderSelect.appendChild(option);
                });
            } else {
                console.error('Error fetching products:', products.error || 'Unknown error');
            }
        } catch (error) {
            console.error('Error fetching products:', error);
        }
    });

    let totalCost = 0;

    document.getElementById('productForm').addEventListener('submit', async (event) => {
        event.preventDefault();

        const product = document.getElementById('productSelect').value;
        const storeUnits = parseInt(document.getElementById('storeUnits').value, 10);
        const downloadUnits = parseInt(document.getElementById('downloadUnits').value, 10);

        try {
            // Fetch store and download prices for the selected product
            const response = await fetch('http://localhost:3000/get-price', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ selection: product })
            });

            const result = await response.json();

            if (response.ok) {
                const storePrice = result.priceStorage;
                const downloadPrice = result.priceDownload;

                // Calculate total cost based on user inputs and fetched prices
                const totalStorage = (storePrice * storeUnits);
                const totalDownload = (downloadPrice * downloadUnits);
                totalCost = totalStorage + totalDownload;

                // Display the result
                document.getElementById('result').innerHTML = `
                    <div class="mol--response">
                        <h4>${product}</h4>
                        <h6>Storage</h6>
                        <p>${storeUnits}TB; total storage cost: $${totalStorage.toFixed(0)}<br>
                        <span class="ut--small">at $${result.priceStorage} per TB, per year</span></p>
                        <h6>Download</h6>
                        <p>${downloadUnits}TB; total download cost: $${totalDownload.toFixed(0)}<br>
                        <span class="ut--small">at $${result.priceDownload} per TB, per year</span></p> 
                        <hr>
                        <h3>Total annual cost: $${totalCost.toFixed(0)}</h3>
                    </div>
                `;
            } else {
                document.getElementById('result').innerHTML = `<p>${result.message || 'Error retrieving price'}</p>`;
            }
        } catch (error) {
            console.error('Error fetching price:', error);
            document.getElementById('result').innerHTML = `<p>Failed to retrieve data. Check console for details.</p>`;
        }
    });

    document.getElementById('calculateFutureCost').addEventListener('click', async () => {
        const futureProvider = document.getElementById('futureProvider').value;
        const allocationPercentage = parseFloat(document.getElementById('allocationPercentage').value);
        const product = document.getElementById('productSelect').value;
        const storeUnits = parseInt(document.getElementById('storeUnits').value, 10);
        const downloadUnits = parseInt(document.getElementById('downloadUnits').value, 10);

        if (!futureProvider || isNaN(allocationPercentage)) {
            document.getElementById('futureResult').innerHTML = `<p>Please select a provider and enter a valid percentage.</p>`;
            return;
        }

        try {
            const responseCurrent = await fetch('http://localhost:3000/get-price', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ selection: product })
            });

            const responseFuture = await fetch('http://localhost:3000/get-price', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ selection: futureProvider })
            });

            const resultCurrent = await responseCurrent.json();
            const resultFuture = await responseFuture.json();

            if (responseCurrent.ok && responseFuture.ok) {
                const primaryStorage = resultCurrent.priceStorage * storeUnits * (1 - allocationPercentage / 100);
                const secondaryStorage = resultFuture.priceStorage * storeUnits * (allocationPercentage / 100);
                const primaryDownload = resultCurrent.priceDownload * downloadUnits * (1 - allocationPercentage / 100);
                const secondaryDownload = resultFuture.priceDownload * downloadUnits * (allocationPercentage / 100);

                const totalFutureCost = primaryStorage + secondaryStorage + primaryDownload + secondaryDownload;
                const savings = totalCost - totalFutureCost;

                document.getElementById('futureResult').innerHTML = `
                    <div class="mol--response">
                        <p>Revised costs with ${allocationPercentage}% allocated to ${futureProvider}:</p>
                        <h3>Total annual cost: $${totalFutureCost.toFixed(0)}</h3>
                        <hr>
                        <h2>A saving of: $${savings.toFixed(0)}</h2>
                    </div>
                    <span style="font-size: 0.7rem;opacity: 0.3;font-stlyle:italic;">(TODO. Show workings... and add "Loading" for provider')</span>
                `;
            } else {
                document.getElementById('futureResult').innerHTML = `<p>Error retrieving prices for selected providers.</p>`;
            }
        } catch (error) {
            console.error('Error fetching price:', error);
            document.getElementById('futureResult').innerHTML = `<p>Failed to retrieve data. Check console for details.</p>`;
        }
    });
</script>

<?php get_footer(); ?>