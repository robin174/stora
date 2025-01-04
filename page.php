<?php
/**
* The template for displaying all pages.
* @package stora
*/

get_header(); ?>

<section class="mol--page-main" style="padding: 100px 0;">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-9">
				
				<h1><?php the_title();?></h1>
				<p>How do we update the navigation - we need 2x separate version.</p>
				<!-- A transparent white block / full width at 50-70% would work well on the background -->
				<a class="button atm--button-main" href="/labs">
					<span>Discover more</span><i class="fas fa-arrow-right"></i>
				</a>

			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>