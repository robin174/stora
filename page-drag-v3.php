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
                <p>This version is the correct flow from Airtable -> Backend (node) to Frontend</p>
                <p>Locally remember to spin-up app.js)</p>
            </div>

            <div class="col-2">
                <section class="mol--columns">
                    <h3>Status quo (cloud costs)</h3>
                </section>
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
                            <?php get_template_part('template-parts/card-drag', null, ['card_id' => 1]); ?>
                            <?php /* We're now going to offer up the version fo the card that is a local data / modal */ ?>
                        </div>
                        <div class="col" data-column="2"></div>
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

            <div class="col-2">
                <section class="mol--columns">
                <h3>Row calculations</h3>
                <section>
            </div>
        </div>  
	</div>
</section>

<?php /* script is enqueued via functions.php */ ?>

<?php get_footer(); ?>