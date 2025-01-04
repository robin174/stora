<nav class="navbar navbar-expand-md">
	<?php if ( is_front_page() && is_home() ) : ?>
		<h1><?php bloginfo( 'name' ); ?></h1>
	<?php else : ?>
		<h1><a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	<?php endif; ?>

	<!-- Off Canvas Right -->
	<button class="custom-toggler navbar-toggler navbar-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
	
	<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
	 	<div class="offcanvas-header">
	    	<h1><?php bloginfo( 'name' ); ?></h1>
			<div>
				<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fal fa-2x fa-times"></i></button>
	 		</div>
	 	</div>
		<div class="offcanvas-body justify-content-end">
			<?php
	            wp_nav_menu(array(
	                'theme_location' => 'main-menu',
	                'container' => false,
	                'menu_class' => '',
	                'fallback_cb' => '__return_false',
	                'items_wrap' => '<ul id="%1$s" class="navbar-nav ml-auto mb-2 mb-md-0 %2$s">%3$s</ul>',
	                'depth' => 2,
	                'walker' => new bootstrap_5_wp_nav_menu_walker()
	            ));
            ?>
	    </div>
	</div>
</nav>