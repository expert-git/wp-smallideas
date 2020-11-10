<?php

/**
 * Setup all the extra settings
 */
function vantage_premium_settings(){
	$settings = SiteOrigin_Settings::single();

	$settings->add_section( 'social', __('Social', 'vantage' ) );

	$settings->add_field( 'social', 'ajax_comments', 'checkbox', __('Ajax Comments', 'vantage'), array(
		'description' => __('Keep your conversations flowing with ajax comments.', 'vantage')
	) );
	$settings->add_field( 'social', 'share_post', 'checkbox', __('Post Sharing', 'vantage'), array(
		'description' => __('Show icons to share your posts on Facebook, Twitter and Google+.', 'vantage'),
	) );
	$settings->add_field( 'social', 'twitter', 'text', __('Twitter Handle', 'vantage'), array(
		'description' => __('This handle will be recommended after a user shares one of your posts.', 'vantage'),
		'validator' => 'twitter',
	) );
}
add_action( 'siteorigin_settings_init', 'vantage_premium_settings', 15 );

/**
 * Show the social share icons
 */
function vantage_premium_show_social_share(){
	if( siteorigin_setting('social_share_post') && is_single() ) {
		siteorigin_share_render( array(
			'twitter' => siteorigin_setting('social_twitter'),
		) );
	}
}
add_action('vantage_entry_main_bottom', 'vantage_premium_show_social_share');

function vantage_premium_siteorigin_about_page( $about ){
	$about[ 'sections' ] = array(
		'support',
		'mature',
		'page-builder',
		'github',
	);

	return $about;
}
add_filter( 'siteorigin_about_page', 'vantage_premium_siteorigin_about_page', 15 );