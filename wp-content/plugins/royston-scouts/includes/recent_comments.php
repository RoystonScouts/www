<?php
if(!class_exists('Royston_Scouts_Recent_Comments'))
{
	class Royston_Scouts_Recent_Comments
	{
		public function __construct()
		{
			add_shortcode( 'recent_comments', array($this, 'recent_comments_shortcode') );
		}
		
		public function recent_comments_shortcode( $attrs ) {
			global $comments, $comment;

			$cache = wp_cache_get('shortcode_recent_comments', 'royston_scouts_shortcodes');

			if ( $cache != "" ) {
				return $cache;
			}

	 		$output = '';

			$comments = get_comments( apply_filters( 'widget_comments_args', array( 'number' => 5, 'status' => 'approve', 'post_status' => 'publish' ) ) );

			$output .= '<ul id="recentcomments">';
			if ( $comments ) {
				// Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
				$post_ids = array_unique( wp_list_pluck( $comments, 'comment_post_ID' ) );
				_prime_post_caches( $post_ids, strpos( get_option( 'permalink_structure' ), '%category%' ), false );

				foreach ( (array) $comments as $comment) {
					$output .=  '<li class="recentcomments">' . sprintf(_x('%1$s said "%2$s" about %3$s', 'widgets'), get_comment_author_link(), get_comment_excerpt($comment->comment_ID), '<a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '">' . get_the_title($comment->comment_post_ID) . '</a>') . '</li>';
				}
	 		}
			$output .= '</ul>';

			$cache = $output;
			wp_cache_set('shortcode_recent_comments', $cache, 'royston_scouts_shortcodes');

			return $output;
		}
	}
}
