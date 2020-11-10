<?php
/**
 * Addon Name: Ajax Comments
 * Description: Keep your conversations flowing with AJAX loading comments.
 * Documentation: https://siteorigin.com/premium-documentation/theme-addons/ajax-comments/
 */

class SiteOrigin_Premium_Ajax_Comments {

	public $original_comments_template;

	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'comment_post_redirect', array( $this, 'comment_rerender' ), 10, 2 );

		add_filter( 'wp_die_handler', array( $this, 'comment_ajax_handler' ) );
		add_filter( 'comments_template', array( $this, 'comments_template' ) );
	}

	static function single(){
		static $single;
		if( empty($single) ) {
			$single = new self();
		}
		return $single;
	}

	function enqueue_scripts(){
		if ( is_singular() && post_type_supports( get_post_type(), 'comments' ) ) {
			wp_enqueue_script( 'siteorigin-ajax-comments', get_template_directory_uri() . '/premium/addons/ajax-comments/js/ajax-comments' . SITEORIGIN_THEME_JS_PREFIX . '.js', array( 'jquery' ), SITEORIGIN_THEME_VERSION );
		}
	}

	function comment_rerender( $location, $comment ){
		if ( empty( $_POST['is_ajax'] ) ) return $location;

		$post_id = isset( $_POST['comment_post_ID'] ) ? intval( $_POST['comment_post_ID'] ) : '';

		// We're going to pretend this is a single
		$query = array( 'post_id' => $post_id );

		if ( get_option( 'page_comments' ) ) {
			$args['per_page'] = get_option( 'comments_per_page' );
			$cpage = get_page_of_comment( $comment->comment_ID, $args );
			$query['cpage'] = $cpage;
		}

		remove_filter('the_posts', 'siteorigin_panels_prepare_post_content');
		query_posts( $query );

		global $wp_query, $post;
		$wp_query->is_single = true;
		$wp_query->is_singular = true;
		$post = get_post( $post_id );

		ob_start();
		comments_template();
		$comment_html = ob_get_clean();

		echo json_encode( array(
			'status' => 'success',
			'html' => $comment_html,
		) );

		exit();
	}

	function comment_ajax_handler(){
		global $pagenow;
		if ( $pagenow == 'wp-comments-post.php' && ! empty( $_POST['is_ajax'] ) ) {
			$handler = array( $this, 'error_handler' );
		}
		return $handler;
	}

	function error_handler( $error ){
		header( 'content-type: application/json', true );
		echo json_encode( array(
			'status' => 'error',
			'error' => $error,
		) );
		exit();
	}

	function comments_template( $file ){
		$this->original_comments_template = $file;
		return dirname(__FILE__) . '/inc/comments.php';
	}

}

SiteOrigin_Premium_Ajax_Comments::single();