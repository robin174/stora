<?php
get_header(); ?>
	<section>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12">
					<h1><?php the_title(); ?></h1>
					<div id="json-data-container">
						<table class="table mol--table" id="json-data-table" border="1">
							<thead>
								<tr>
									<th>Pos</th>
									<th>Name</th>
									<th>Mar</th>
									<th>Apr</th>
									<th>May</th>
									<th>Jun-X</th>
									<th>Jun</th>
									<th>Aug</th>
									<th>Sep</th>
									<th>Rnds</th>
									<th>Average</th>
									<th>Goat Pts</th>
									<th>Col. Diff</th>
									<th>Starting Pts</th>
									<th>Oct</th>
									<th>Oct+</th>
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

		<?php /* the various stages 
			1. Played rounds, qulaified AND played final round
			2. Played rounds, qualified, did not play final round
			3. Played rounds, did not qualify, did or did not play final
			4. Part of team, did not play
		*/ ?>

		
		<script>
		    document.addEventListener('DOMContentLoaded', function() {
		        fetch('http://localhost:3000/organizedjsonlive')
		            .then(response => response.json())
		            .then(dataArray => {
		                const tableBody = document.getElementById('json-data-table').querySelector('tbody');

		                // Function to determine starting points based on goatPoints difference
		                function calculateStartingPoints(difference) {
		                	if (difference >= 650 && difference <= 699) return 6.5;
		                    if (difference >= 600 && difference <= 649) return 6;
		                    if (difference >= 550 && difference <= 599) return 5.5;
		                    if (difference >= 500 && difference <= 549) return 5;
		                    if (difference >= 450 && difference <= 499) return 4.5;
		                    if (difference >= 400 && difference <= 449) return 4;
		                    if (difference >= 350 && difference <= 399) return 3.5;
		                    if (difference >= 300 && difference <= 349) return 3;
		                    if (difference >= 250 && difference <= 299) return 2.5;
		                    if (difference >= 200 && difference <= 249) return 2;
		                    if (difference >= 150 && difference <= 199) return 1.5;
		                    if (difference >= 100 && difference <= 149) return 1;
		                    if (difference >= 50 && difference <= 99) return 0.5;
		                    if (difference >=0 && difference <= 49) return 0;
		                    return 0; // If difference is outside these ranges
		                }

		                // Filter and sort the array where data.roundstotal >= 3
		                const qualifiedData = dataArray.filter(data => data.roundstotal >= 3);

		                // Find the goatPoints of the last qualified person
		                const lastPlaceGoatPoints = qualifiedData[qualifiedData.length - 1] ? qualifiedData[qualifiedData.length - 1].goatpoints : 0;

		                // Calculate final scores (Oct score + starting points) and store the result
		                qualifiedData.forEach(data => {
		                    // Calculate goatPoints difference from the last qualified person
		                    const goatPointsDifference = data.goatpoints - lastPlaceGoatPoints;

		                    // Calculate starting points based on the difference
		                    const startingPoints = calculateStartingPoints(goatPointsDifference);

		                    // Calculate the final score (scoreOct + startingPoints)
		                    const finalScore = parseFloat(data.scoreoct || 0) + startingPoints;

		                    data.finalScore = finalScore; // Store the final score in the data object for sorting
		                });

		                // Sort based on the finalScore in descending order (higher scores get higher positions)
		                qualifiedData.sort((a, b) => {
		                    // Rows without an October score go to the bottom
		                    if (!a.scoreoct) return 1;
		                    if (!b.scoreoct) return -1;
		                    // Sort by finalScore if both have October scores
		                    return b.finalScore - a.finalScore;
		                });

		                // Separate the rows with and without October scores for sorting
		                const withOctScore = qualifiedData.filter(data => data.scoreoct);
		                const withoutOctScore = qualifiedData.filter(data => !data.scoreoct);

		                // Append rows with October scores and assign positions
		                let currentPosition = 1;
		                withOctScore.forEach(data => {
		                	const goatPointsDifference = data.goatpoints - lastPlaceGoatPoints; // Move the calculation here
		                    const startingPoints = calculateStartingPoints(goatPointsDifference);
		                    const finalScore = parseFloat(data.scoreoct || 0) + startingPoints;

		                    const row = document.createElement('tr');
		                    row.className = 'atm--qualified';

				            // Create and append the Pos (position) cell
		                    const rankCell = document.createElement('td');
		                    rankCell.classList.add('rank-cell-class');

		                    // Replace position 1 with goat emoji 🐐
		                    if (currentPosition === 1) {
		                        rankCell.textContent = '🐐'; // Goat emoji for first place
		                    } else {
		                        rankCell.textContent = currentPosition;
		                    }

		                    row.appendChild(rankCell);
                    		currentPosition++;

		                    // Add other data to the row
		                    const titleName = document.createElement('td');
		                    titleName.textContent = data.name;
		                    titleName.className = 'atm--name';
		                    row.appendChild(titleName);

		                    const scoreMar = document.createElement('td');
		                    scoreMar.textContent = data.scoremar ? data.scoremar : '-';
		                    row.appendChild(scoreMar);

		                    const scoreApr = document.createElement('td');
		                    scoreApr.textContent = data.scoreapr ? data.scoreapr : '-';
		                    row.appendChild(scoreApr);

		                    const scoreMay = document.createElement('td');
		                    scoreMay.textContent = data.scoremay ? data.scoremay : '-';
		                    row.appendChild(scoreMay);

		                    const scoreJunExtra = document.createElement('td');
		                    scoreJunExtra.textContent = data.scorejunextra ? data.scorejunextra : '-';
		                    row.appendChild(scoreJunExtra);

		                    const scoreJun = document.createElement('td');
		                    scoreJun.textContent = data.scorejun ? data.scorejun : '-';
		                    row.appendChild(scoreJun);

		                    const scoreAug = document.createElement('td');
		                    scoreAug.textContent = data.scoreaug ? data.scoreaug : '-';
		                    row.appendChild(scoreAug);

		                    const scoreSep = document.createElement('td');
		                    scoreSep.textContent = data.scoresep ? data.scoresep : '-';
		                    row.appendChild(scoreSep);

		                    const roundsTotal = document.createElement('td');
		                    roundsTotal.textContent = data.roundstotal;
		                    row.appendChild(roundsTotal);

		                    const roundsAverage = document.createElement('td');
		                    roundsAverage.textContent = data.roundsaverage;
		                    roundsAverage.className = 'atm--points';
		                    row.appendChild(roundsAverage);

		                    const goatPoints = document.createElement('td');
		                    goatPoints.textContent = data.goatpoints;
		                    goatPoints.className = 'atm--points';
		                    row.appendChild(goatPoints);

		                    const colAverage = document.createElement('td');
		                    colAverage.textContent = goatPointsDifference;
		                    goatPoints.className = 'atm--final';
		                    row.appendChild(colAverage);

		                    // Add the starting points cell
		                    const startingPointsCell = document.createElement('td');
		                    startingPointsCell.textContent = startingPoints;
		                    row.appendChild(startingPointsCell);

		                    const scoreOct = document.createElement('td');
		                    scoreOct.textContent = data.scoreoct ? data.scoreoct : '-';
		                    row.appendChild(scoreOct);

		                    const finalScoreOct = document.createElement('td');
		                    finalScoreOct.textContent = finalScore ? finalScore : '-';
		                    finalScoreOct.className = 'atm--points';
		                    row.appendChild(finalScoreOct);

		                    tableBody.appendChild(row);
		                });

				        // Append rows without October scores (no position assigned)
		                withoutOctScore.forEach(data => {
		                	const goatPointsDifference = data.goatpoints - lastPlaceGoatPoints; // Move the calculation here too
                    		const startingPoints = calculateStartingPoints(goatPointsDifference);

		                    const row = document.createElement('tr');
		                    row.className = 'atm--qualified';

		                    // No position for these rows
		                    const rankCell = document.createElement('td');
		                    rankCell.textContent = '-';
		                    row.appendChild(rankCell);

		                    // Add other data to the row
		                    const titleName = document.createElement('td');
		                    titleName.textContent = data.name;
		                    titleName.className = 'atm--name';
		                    row.appendChild(titleName);

		                    const scoreMar = document.createElement('td');
		                    scoreMar.textContent = data.scoremar ? data.scoremar : '-';
		                    row.appendChild(scoreMar);

		                    const scoreApr = document.createElement('td');
		                    scoreApr.textContent = data.scoreapr ? data.scoreapr : '-';
		                    row.appendChild(scoreApr);

		                    const scoreMay = document.createElement('td');
		                    scoreMay.textContent = data.scoremay ? data.scoremay : '-';
		                    row.appendChild(scoreMay);

		                    const scoreJunExtra = document.createElement('td');
		                    scoreJunExtra.textContent = data.scorejunextra ? data.scorejunextra : '-';
		                    row.appendChild(scoreJunExtra);

		                    const scoreJun = document.createElement('td');
		                    scoreJun.textContent = data.scorejun ? data.scorejun : '-';
		                    row.appendChild(scoreJun);

		                    const scoreAug = document.createElement('td');
		                    scoreAug.textContent = data.scoreaug ? data.scoreaug : '-';
		                    row.appendChild(scoreAug);

		                    const scoreSep = document.createElement('td');
		                    scoreSep.textContent = data.scoresep ? data.scoresep : '-';
		                    row.appendChild(scoreSep);

		                    const roundsTotal = document.createElement('td');
		                    roundsTotal.textContent = data.roundstotal;
		                    row.appendChild(roundsTotal);

		                    const roundsAverage = document.createElement('td');
		                    roundsAverage.textContent = data.roundsaverage;
		                    roundsAverage.className = 'atm--points';
		                    row.appendChild(roundsAverage);

		                    const goatPoints = document.createElement('td');
		                    goatPoints.textContent = data.goatpoints;
		                    goatPoints.className = 'atm--points';
		                    row.appendChild(goatPoints);

		                    const colAverage = document.createElement('td');
		                    colAverage.textContent = goatPointsDifference;
		                    goatPoints.className = 'atm--final';
		                    row.appendChild(colAverage);

		                    // Add the starting points cell
		                    const startingPointsCell = document.createElement('td');
		                    startingPointsCell.textContent = startingPoints;
		                    row.appendChild(startingPointsCell);

		                    const scoreOct = document.createElement('td');
		                    scoreOct.textContent = '-';  // No October score
		                    row.appendChild(score);
						});

		                // Second loop: Add rows where data.roundstotal >= 3
		                dataArray.forEach((data, index) => {
		                    if (data.roundstotal < 3 && data.roundstotal > 0) {
		                        const row = document.createElement('tr');

		                        const rankCell = document.createElement('td');
		                        rankCell.textContent = '-';
		                        row.appendChild(rankCell);

		                        const titleName = document.createElement('td');
		                        titleName.textContent = data.name;
		                        row.appendChild(titleName);

		                        const scoreMar = document.createElement('td');
		                        scoreMar.textContent = data.scoremar ? data.scoremar : '-';
		                        row.appendChild(scoreMar);

		                        const scoreApr = document.createElement('td');
		                        scoreApr.textContent = data.scoreapr ? data.scoreapr : '-';
		                        row.appendChild(scoreApr);

		                        const scoreMay = document.createElement('td');
		                        scoreMay.textContent = data.scoremay ? data.scoremay : '-';
		                        row.appendChild(scoreMay);

		                        const scoreJunExtra = document.createElement('td');
		                        scoreJunExtra.textContent = data.scorejunextra ? data.scorejunextra : '-';
		                        row.appendChild(scoreJunExtra);

		                        const scoreJun = document.createElement('td');
		                        scoreJun.textContent = data.scorejun ? data.scorejun : '-';
		                        row.appendChild(scoreJun);

		                        const scoreAug = document.createElement('td');
		                        scoreAug.textContent = data.scoreaug ? data.scoreaug : '-';
		                        row.appendChild(scoreAug);

		                        const scoreSep = document.createElement('td');
		                        scoreSep.textContent = data.scoresep ? data.scoresep : '-';
		                        row.appendChild(scoreSep);

		                        const roundsTotal = document.createElement('td');
		                        roundsTotal.textContent = data.roundstotal;
		                        row.appendChild(roundsTotal);

		                        const roundsAverage = document.createElement('td');
		                        roundsAverage.textContent = data.roundsaverage;
		                        row.appendChild(roundsAverage);

		                        const goatPoints = document.createElement('td');
		                        goatPoints.textContent = data.goatpoints;
		                        row.appendChild(goatPoints);

		                        const colAverage = document.createElement('td');
		                        colAverage.textContent = 'n/a';
		                        goatPoints.className = 'atm--final';
		                        row.appendChild(colAverage);

			                    const startingPoints = document.createElement('td');
			                    startingPoints.textContent = 'n/a';
			                    row.appendChild(startingPoints);

			                    const scoreOct = document.createElement('td');
		                        scoreOct.textContent = data.scoreoct ? data.scoreoct : '-';
		                        row.appendChild(scoreOct);

		                        const finalOctNull = document.createElement('td');
			                    finalOctNull.textContent = '-';
			                    row.appendChild(finalOctNull);

		                        tableBody.appendChild(row);
		                    }
		                });

		                // Third loop: No league games
		                dataArray.forEach((data, index) => {
		                    if (data.roundstotal === 0) {
		                        const row = document.createElement('tr');

		                        //const rowNumberCell = document.createElement('td');
		                        //rowNumberCell.textContent = index + 1;
		                        //row.appendChild(rowNumberCell);

		                        const rankCell = document.createElement('td');
		                        rankCell.textContent = '-';
		                        row.appendChild(rankCell);

		                        const titleName = document.createElement('td');
		                        titleName.textContent = data.name;
		                        row.appendChild(titleName);

		                        const scoreMar = document.createElement('td');
		                        scoreMar.textContent = data.scoremar ? data.scoremar : '-';
		                        row.appendChild(scoreMar);

		                        const scoreApr = document.createElement('td');
		                        scoreApr.textContent = data.scoreapr ? data.scoreapr : '-';
		                        row.appendChild(scoreApr);

		                        const scoreMay = document.createElement('td');
		                        scoreMay.textContent = data.scoremay ? data.scoremay : '-';
		                        row.appendChild(scoreMay);

		                        const scoreJunExtra = document.createElement('td');
		                        scoreJunExtra.textContent = data.scorejunextra ? data.scorejunextra : '-';
		                        row.appendChild(scoreJunExtra);

		                        const scoreJun = document.createElement('td');
		                        scoreJun.textContent = data.scorejun ? data.scorejun : '-';
		                        row.appendChild(scoreJun);

		                        const scoreAug = document.createElement('td');
		                        scoreAug.textContent = data.scoreaug ? data.scoreaug : '-';
		                        row.appendChild(scoreAug);

		                        const scoreSep = document.createElement('td');
		                        scoreSep.textContent = data.scoresep ? data.scoresep : '-';
		                        row.appendChild(scoreSep);

		                        const roundsTotal = document.createElement('td');
		                        roundsTotal.textContent = data.roundstotal;
		                        row.appendChild(roundsTotal);

		                        const roundsAverage = document.createElement('td');
		                        roundsAverage.textContent = 'n/a';
		                        row.appendChild(roundsAverage);

		                        const goatPoints = document.createElement('td');
		                        goatPoints.textContent = 'n/a';
		                        row.appendChild(goatPoints);

		                        const colAverage = document.createElement('td');
		                        colAverage.textContent = 'n/a';
		                        goatPoints.className = 'atm--final';
		                        row.appendChild(colAverage);

			                    const startingPoints = document.createElement('td');
			                    startingPoints.textContent = 'n/a';
			                    row.appendChild(startingPoints);

		                        const scoreOct = document.createElement('td');
		                        scoreOct.textContent = data.scoreoct ? data.scoreoct : '-';
		                        row.appendChild(scoreOct);

		                        tableBody.appendChild(row);
		                    }
		                });
		            })
		            .catch(error => console.error('Error fetching data:', error));
		    });
		</script>
	</section>

<?php get_footer(); ?>