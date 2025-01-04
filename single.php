<?php
get_header(); ?>

	<section>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12">

					<div id="json-data-container">
						<table class="table table-striped mol--table" id="json-data-table" border="1">
							<thead>
								<tr>
									<th>Position</th><th>Name</th><th>Mar</th><th>Apr</th><th>May</th><th>Jun</th><th>Aug</th><th>Sep</th><th>Oct</th><th>Rounds</th><th>Average</th><th>Goat Points</th>
								</tr>
							</thead>
							<tbody>
			    			</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<?php /* organise the data into easy to understand JSON, and then pull in to the website like Runaway */ ?> 
		
		<script>
		    document.addEventListener('DOMContentLoaded', function() {
		        fetch('http://localhost:3000/organizedjsonlive')
		            .then(response => response.json())
		            .then(dataArray => {
		            	const tableBody = document.getElementById('json-data-table').querySelector('tbody');

		                dataArray.forEach((data, index) => {
		                	const row = document.createElement('tr');

		                	const rowNumberCell = document.createElement('td');
		                    rowNumberCell.textContent = index + 1;
		                    row.appendChild(rowNumberCell);

		                	const titleName = document.createElement('td');
		                    titleName.textContent = data.name;
		                    row.appendChild(titleName);

		                    const scoreMar = document.createElement('td');
                    		scoreMar.textContent = data.scoremar;
                    		row.appendChild(scoreMar);

                    		const scoreApr = document.createElement('td');
                    		scoreApr.textContent = data.scoreapr;
                    		row.appendChild(scoreApr);

                    		const scoreMay = document.createElement('td');
                    		scoreMay.textContent = data.scoremay;
                    		row.appendChild(scoreMay);

                    		const scoreJun = document.createElement('td');
                    		scoreJun.textContent = data.scorejun;
                    		row.appendChild(scoreJun);

                    		const scoreAug = document.createElement('td');
                    		scoreJun.textContent = data.scoreaug;
                    		row.appendChild(scoreAug);

                    		const scoreSep = document.createElement('td');
                    		scoreSep.textContent = data.scoresep;
                    		row.appendChild(scoreSep);

                    		const scoreOct = document.createElement('td');
                    		scoreOct.textContent = data.scoreoct;
                    		row.appendChild(scoreOct);

                    		const roundsTotal = document.createElement('td');
                    		roundsTotal.textContent = data.roundstotal;
                    		row.appendChild(roundsTotal);

                    		const roundsAverage = document.createElement('td');
                    		roundsAverage.textContent = data.roundsaverage;
                    		row.appendChild(roundsAverage);

                    		const goatPoints = document.createElement('td');
                    		goatPoints.textContent = data.goatpoints;
                    		row.appendChild(goatPoints);

                    		tableBody.appendChild(row);
		                });
		            })
		            .catch(error => console.error('Error fetching data:', error));
		    });
		</script>
		
		
		<?php /*
		<script>
		    document.addEventListener('DOMContentLoaded', function() {
		        fetch('http://localhost:3000/organizedjson')
		            .then(response => response.json())
		            .then(data => {
		                const container = document.getElementById('json-data-container');
		                container.innerHTML = `<p>${data.name}</p>`;
		            })
		            .catch(error => console.error('Error fetching data:', error));
		    });
		</script>
		*/ ?>
		
	</section>

<?php get_footer(); ?>