<?php
/**
* Template Name: Page - Drag and Drop V2
* @package stora
*/

get_header(); ?>

<section class="templ--page-drag">
	<div class="container">
        <div class="row">
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
            <div class="col-2">
                <section class="mol--columns">
                <h3>Row calculations</h3>
                <section>
            </div>
        </div>  
	</div>
</section>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/drag02.js?version=1.2"></script>

<?php get_footer(); ?>