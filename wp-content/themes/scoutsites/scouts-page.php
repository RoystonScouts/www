<?php
/**
 * Template Name: Scouts Template
 * Description: This adds a sidebar to your page that you can drag scouts related widgets onto
 *
 * @package WordPress
 * @subpackage ScoutSites
 * @since 1.0
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

					<?php comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php
$options = twentyeleven_get_theme_options();
$current_layout = $options['theme_layout'];

if ( 'content' != $current_layout ) {
?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-scouts' ); ?>
		</div><!-- #secondary .widget-area -->
<?php } ?>
<?php get_footer(); ?>