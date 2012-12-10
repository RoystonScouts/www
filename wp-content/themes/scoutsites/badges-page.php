<?php
/**
 * Template Name: Challenge Badge Template
 * Description: This adds a sidebar to your page that you can drag scouts related widgets onto
 *
 * @package WordPress
 * @subpackage ScoutSites
 * @since 1.0
 */

get_header(); ?>

		<div id="primary" class="fullwidth">
			<div id="content" class="maincontent" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

					<?php comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php
$options = twentyeleven_get_theme_options();
$current_layout = $options['theme_layout'];

get_footer(); ?>