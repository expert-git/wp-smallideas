<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<!-- Google Tag Manager
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TZB5BWM');</script>
 End Google Tag Manager -->
	
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-56670743-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-56670743-1');
	</script>
	

	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=10" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700" rel="stylesheet">
	<link href="<?php bloginfo("template_url"); ?>/css/custom.css?v=1.2" rel="stylesheet" type="text/css" media="all">
	
	
	<script>
		

		jQuery(document).ready(function(){
			jQuery('.showcoupon').click(function(e){
				e.preventDefault();
			//	jQuery('.checkout_coupon').css('display','block');
			});
		});

		
		jQuery(document).ready(function(){
			//smallideas checkout gift fields
			jQuery('#gift_email_field').addClass('hidden');
			if(jQuery('#is_gift').is(':checked')){
				jQuery('#gift_email_field').removeClass('hidden');
			} else {
				jQuery('#gift_email_field').addClass('hidden');
			}
			jQuery('#is_gift').change(function(){
				if(jQuery(this).is(':checked')){
					jQuery('#gift_email_field').removeClass('hidden');
				} else {
					jQuery('#gift_email_field').addClass('hidden');
				}
			});
		});		
	</script>
<meta name="google-site-verification" content="qAoij7YCvuu-vTqyTvkjFy5Y_CokKOLiMlnIq7pxI18" />
</head>

<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) 
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TZB5BWM"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
End Google Tag Manager (noscript) -->
<?php do_action('vantage_before_page_wrapper') ?>

<div id="page-wrapper">
	
	<div class="header-top">
		<!--<div class="full-container">
			<div class="visitsydney"><a class="btn" href="https://smallideasnsw.com.au/" target="blank">Visit Sydney</a></div>
			<div class="clearfix"></div>
		</div>-->
	</div>

	<?php do_action( 'vantage_before_masthead' ); ?>

	<?php //if( ! siteorigin_page_setting( 'hide_masthead', false ) ) : ?>

		<?php get_template_part( 'parts/masthead', apply_filters( 'vantage_masthead_type', siteorigin_setting( 'layout_masthead' ) ) ); ?>

		<?php //endif; ?>

	<?php do_action( 'vantage_after_masthead' ); ?>

	<?php vantage_render_slider() ?>

	<?php do_action( 'vantage_before_main_container' ); ?>

	<div id="main" class="site-main">
		<div class="full-container">
			<?php do_action( 'vantage_main_top' ); ?>
