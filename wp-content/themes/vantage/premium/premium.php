<?php

include get_template_directory() . '/premium/update/update.php';
include get_template_directory() . '/premium/share/share.php';
if( ! class_exists('SiteOrigin_CSS') ) include get_template_directory() . '/premium/css/css.php';

define( 'SITEORIGIN_IS_PREMIUM', true );

class SiteOrigin_Theme_Premium {

	function __construct(){
		if( !class_exists( 'SiteOrigin_Premium_Manager' ) ) {
			add_filter( 'siteorigin_settings_display_teaser', '__return_false' );
			add_action( 'siteorigin_settings_add_teaser_field', array($this, 'handle_teaser_field'), 10, 6 );

			add_action( 'after_setup_theme', array( $this, 'load_theme_addons' ), 100 );
		}

		// Include the addon file
		$theme = get_template();
		$filename = dirname(__FILE__) . '/themes/' . $theme . '.php';
		if( file_exists( $filename ) ) {
			include $filename;
		}

		add_filter( 'siteorigin_about_page', array( $this, 'theme_about_page' ) );
	}

	static function single(){
		static $single;
		if( empty( $single ) ) {
			$single = new self();
		}
		return $single;
	}

	/**
	 * Load supported and activated addons for themes
	 */
	function load_theme_addons(){
		global $_wp_theme_features;
		if( empty( $_wp_theme_features ) || !is_array( $_wp_theme_features ) ) return;

		foreach( array_keys( $_wp_theme_features ) as $feature ) {

			if( !preg_match( '/siteorigin-premium-(.+)/', $feature, $matches ) ) continue;
			if( ! isset( $_wp_theme_features[$feature][0] ) ) continue;

			$feature_args = $_wp_theme_features[$feature][0];
			if( empty( $feature_args['enabled'] ) ) continue;

			$feature_name = $matches[1];

			$filename = dirname(__FILE__) . '/addons/' . $feature_name . '/' . $feature_name . '.php';
			if( file_exists( $filename ) ) {
				include $filename;
			}
		}
	}

	/**
	 * Change the teaser field to display the full field
	 *
	 * @param $settings
	 * @param $section
	 * @param $id
	 * @param $type
	 * @param $label
	 * @param $args
	 */
	function handle_teaser_field( $settings, $section, $id, $type, $label, $args ){
		if( method_exists( $settings, 'add_field' ) ) {
			$settings->add_field( $section, $id, $type, $label, $args );
		}
	}

	function theme_about_page( $settings ){
		$settings['version'] .= ' - ' . __( 'premium', 'vantage' );
		$settings['premium_url'] = false;

		return $settings;
	}

}

SiteOrigin_Theme_Premium::single();