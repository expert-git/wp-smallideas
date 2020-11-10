<?php

if( !empty($_GET['so_css_preview']) ) {
	// Setup everything for the preview mode
	add_filter('show_admin_bar', '__return_false');
}

/**
 * Add the custom CSS editor to the admin menu.
 */
function siteorigin_custom_css_admin_menu() {
	add_theme_page( __( 'Custom CSS', 'vantage' ), __( 'Custom CSS', 'vantage' ), 'edit_theme_options', 'siteorigin_custom_css', 'siteorigin_custom_css_page' );

	if ( current_user_can('edit_theme_options') && isset( $_POST['siteorigin_custom_css_save'] ) ) {
		check_admin_referer( 'custom_css', '_sononce' );
		$theme = basename( get_template_directory() );

		// Sanitize CSS input. Should keep most tags, apart from script and style tags.
		$custom_css = siteorigin_custom_css_clean( filter_input(INPUT_POST, 'custom_css' ) );

		$current = get_option('siteorigin_custom_css[' . $theme . ']');
		if( $current === false ) {
			add_option( 'siteorigin_custom_css[' . $theme . ']', $custom_css , '', 'no' );
		}
		else {
			update_option( 'siteorigin_custom_css[' . $theme . ']', $custom_css );
		}

		// If this has changed, then add a revision.
		if ( $current != $custom_css ) {
			$revisions = get_option( 'siteorigin_custom_css_revisions[' . $theme . ']' );
			if ( empty( $revisions ) ) {
				add_option( 'siteorigin_custom_css_revisions[' . $theme . ']', array(), '', 'no' );
				$revisions = array();
			}
			$revisions[ time() ] = $custom_css;

			// Sort the revisions and cut off any old ones.
			krsort($revisions);
			$revisions = array_slice($revisions, 0, 15, true);

			update_option( 'siteorigin_custom_css_revisions[' . $theme . ']', $revisions );
		}
	}

}
add_action( 'admin_menu', 'siteorigin_custom_css_admin_menu' );

/**
 * Add the help tab for custom CSS page.
 */
function siteorigin_custom_css_help() {
	$screen = get_current_screen();
	$theme = basename( get_template_directory() );
	$screen->add_help_tab( array(
		'id' => 'custom-css',
		'title' => __( 'Custom CSS', 'vantage' ),
		'content' => '<p>'
			. sprintf( __( "%s adds any custom CSS you enter here into your site's header. ", 'vantage' ), ucfirst( $theme ) )
			. __( "These changes will persist across updates so it's best to make all your changes here. ", 'vantage' )
			. sprintf( __( "Post on <a href='%s' target='_blank'>our support forum</a> for help with making edits. ", 'vantage' ), 'http://siteorigin.com/thread/' )
			. '</p>'
	) );
}
add_action( 'load-appearance_page_siteorigin_custom_css', 'siteorigin_custom_css_help' );


/**
 *
 * @param $page
 * @return mixed
 */
function siteorigin_custom_css_enqueue( $page ) {
	if ( $page != 'appearance_page_siteorigin_custom_css' ) return;

	wp_enqueue_script( 'codemirror', get_template_directory_uri() . '/premium/css/codemirror/lib/codemirror' . SITEORIGIN_THEME_JS_PREFIX . '.js', array(), '4.2.0' );
	wp_enqueue_script( 'codemirror-mode-css', get_template_directory_uri() . '/premium/css/codemirror/mode/css/css' . SITEORIGIN_THEME_JS_PREFIX . '.js', array(), '4.2.0' );
	wp_enqueue_script( 'codemirror-lint', get_template_directory_uri() . '/premium/css/codemirror/lib/util/lint' . SITEORIGIN_THEME_JS_PREFIX . '.js', array(), '4.2.0' );
	wp_enqueue_script( 'codemirror-lint-css', get_template_directory_uri() . '/premium/css/codemirror/lib/util/css-lint' . SITEORIGIN_THEME_JS_PREFIX . '.js', array(), '4.2.0' );
	wp_enqueue_script( 'codemirror-lint-css-lib', get_template_directory_uri() . '/premium/css/codemirror/lib/util/csslint' . SITEORIGIN_THEME_JS_PREFIX . '.js', array(), '4.2.0' );

	wp_enqueue_style( 'codemirror', get_template_directory_uri() . '/premium/css/codemirror/lib/codemirror.css', array(), '4.2.0' );
	wp_enqueue_style( 'codemirror-theme-neat', get_template_directory_uri() . '/premium/css/codemirror/theme/neat.css', array(), '4.2.0' );
	wp_enqueue_style( 'codemirror-lint-css', get_template_directory_uri() . '/premium/css/codemirror/lib/util/lint.css', array(), '4.2.0' );

	wp_enqueue_script( 'siteorigin-custom-css', get_template_directory_uri() . '/premium/css/js/admin' . SITEORIGIN_THEME_JS_PREFIX . '.js', array( 'jquery' ), SITEORIGIN_THEME_VERSION );
	wp_enqueue_style( 'siteorigin-custom-css', get_template_directory_uri() . '/premium/css/css/admin.css', array( ), SITEORIGIN_THEME_VERSION );
}
add_action( 'admin_enqueue_scripts', 'siteorigin_custom_css_enqueue' );


/**
 * Render the custom CSS page
 */
function siteorigin_custom_css_page() {
	$theme = basename( get_template_directory() );

	$custom_css = get_option( 'siteorigin_custom_css[' . $theme . ']', '' );
	$custom_css_revisions = get_option('siteorigin_custom_css_revisions[' . $theme . ']');

	if(!empty($_GET['theme']) && $_GET['theme'] == $theme && !empty($_GET['time']) && !empty($custom_css_revisions[$_GET['time']])) {
		$custom_css = $custom_css_revisions[$_GET['time']];
		$revision = true;
	}

	include dirname(__FILE__) . '/page.php';
}

/**
 * Display the custom CSS.
 *
 * @return mixed
 */
function siteorigin_custom_css_display() {
	$theme = basename( get_template_directory() );
	$custom_css = get_option( 'siteorigin_custom_css[' . $theme . ']', '' );
	if ( empty( $custom_css ) ) return;

	// We just need to enqueue a dummy style
	echo "<style id='" . sanitize_html_class($theme) . "-custom-css' class='siteorigin-custom-css' type='text/css'>\n";
	echo siteorigin_custom_css_clean( $custom_css , '\\') . "\n";
	echo "</style>\n";
}
add_action( 'wp_head', 'siteorigin_custom_css_display', 15 );

/**
 * Get the basic information for each snippet
 */
function siteorigin_custom_css_get_snippets(){
	$snippets = array();

	$snippet_paths = apply_filters( 'siteorigin_css_snippet_paths', array() );
	if( empty( $snippet_paths ) ) return false;

	if( !WP_Filesystem() ) return false;
	global $wp_filesystem;

	foreach( $snippet_paths as $path ) {
		foreach( glob($path . '/*.css') as $css_file ) {
			$data = get_file_data( $css_file, array(
				'Name' => 'Name',
				'Description' => 'Description',
			) );

			// Get the CSS and strip out the first header
			$css = $wp_filesystem->get_contents( $css_file );
			$css = preg_replace('!/\*.*?\*/!s', '', $css, 1);


			$snippets[] = wp_parse_args( $data, array(
				'css' => str_replace( "\t", '  ', trim($css) ),
			) );
		}
	}

	usort($snippets, 'siteorigin_custom_css_snippet_sort_function');
	return $snippets;
}

/**
 * Function to sort snippets by name
 *
 * @param $a
 * @param $b
 *
 * @return int
 */
function siteorigin_custom_css_snippet_sort_function( $a, $b ){
	return $a['Name'] > $b['Name'] ? 1 : -1;
}

/**
 * Strip anything malicious from the code
 *
 * @param $css
 *
 * @return mixed
 *
 * @todo Improve this function to allow tags in content: '' attributes
 */
function siteorigin_custom_css_clean($css){
	return trim( strip_tags( $css ) );
}

function siteorigin_custom_css_dismiss_action(){
	if( empty($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'dismiss') ) return;
	update_user_meta( get_current_user_id(), 'so_extras_css_dismissed_upgrade', true );
	exit();
}
add_action('wp_ajax_siteorigin_css_hide_extra_upgrade', 'siteorigin_custom_css_dismiss_action');