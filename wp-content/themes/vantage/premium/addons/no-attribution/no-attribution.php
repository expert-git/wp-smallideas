<?php
/**
 * Addon Name: No Attribution
 * Description: Removes SiteOrigin attribution from your website footer.
 * Documentation: https://siteorigin.com/premium-documentation/theme-addons/no-attribution/
 */

function siteorigin_premium_no_attribution_init(){
	$support = get_theme_support('siteorigin-premium-no-attribution');
	if( !empty($support) ) {
		$support = $support[0];
		if( $support['enabled'] && !empty( $support['filter'] ) ) {
			add_filter( $support['filter'], '__return_false' );
		}
	}
}
add_action( 'init', 'siteorigin_premium_no_attribution_init' );