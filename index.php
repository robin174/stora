<?php
/**
* The main template file.
*
* This is the most generic template file in a WordPress theme
* and one of the two required files for a theme (the other being style.css).
* It is used to display a page when nothing more specific matches a query.
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
* @package stora
*/

get_header(); ?>

<div class="container">
	<div class="row">
		<div class="col-12 col-md-12" style="background-color: rgba(0,0,0,0.2);">
			<h1><?php the_title();?></h1>
		</div>
	</div>
</div>

<?php get_footer(); ?>