<?php
/**
 * vantage functions and definitions
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */
/* ************************************************************************************************
 *  [START] ROBERTSONWEB CUSTOMIZATION
 */
add_theme_support( 'woocommerce' );

wp_enqueue_script( 'google-fonts', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700' );

// remove Types box
add_filter('types_information_table', '__return_false');

// move Yoast to bottom
function fn_move_yoast_bottom() {return 'low';}
add_filter( 'wpseo_metabox_prio', 'fn_move_yoast_bottom');

/*-----------------------------------------------------------------------------------*/
/*    Change number of products displayed per page
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'fn_change_woocomerce_products_per_page' ) ) {
    function fn_change_woocomerce_products_per_page() {
        return 12;
    }
    
    add_filter('loop_shop_per_page', 'fn_change_woocomerce_products_per_page');
}

/*-----------------------------------------------------------------------------------*/
// Change number or products per row to 3
/*-----------------------------------------------------------------------------------*/
if (!function_exists('fn_update_loop_shop_columns')) {
    function fn_update_loop_shop_columns() {
        return 3;
    }
    
    add_filter('loop_shop_columns', 'fn_update_loop_shop_columns');
}

/*-----------------------------------------------------------------------------------*/
// Change number or products thumbnail per row to 4
/*-----------------------------------------------------------------------------------*/

add_filter ( 'woocommerce_product_thumbnails_columns', 'xx_thumb_cols' );
function xx_thumb_cols() {
 	return 3; 
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_meta',40 );
remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_price',10 );
//add_action( 'woocommerce_after_add_to_cart_quantity','woocommerce_template_single_price',21 );
//add_action( 'woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',5 );
//add_action( 'woocommerce_after_add_to_cart_button','fn_add_join_vip_link',5 );
remove_action( 'woocommerce_after_single_product_summary','woocommerce_upsell_display',15 );
remove_action( 'woocommerce_after_single_product_summary','woocommerce_output_related_products',20 );
//remove_action( 'woocommerce_after_single_product_summary','woocommerce_output_product_data_tabs',10 );
 
 /* 
 * [END] small ideas app additions 
 *************************************************************************************************/



 if ( ! function_exists( 'wp_password_change_notification' ) ) :
     function wp_password_change_notification( $user ) {
         return;
     }
 endif;
 




 add_filter('woocommerce_billing_fields','wpb_custom_billing_fields');
 // remove some fields from billing form
 // ref - https://docs.woothemes.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/
 function wpb_custom_billing_fields( $fields = array() ) {

 	unset($fields['billing_company']);
 	unset($fields['billing_address_1']);
 	unset($fields['billing_address_2']);
 	//unset($fields['billing_phone']);
 //	unset($fields['billing_postcode']);
 	unset($fields['billing_country']);
  
 	return $fields;
 }
 
 
 
 // allow just 1 item in cart at a time
 
 add_filter( 'woocommerce_add_to_cart_validation', 'bbloomer_only_one_in_cart', 99, 2 );
  
 function bbloomer_only_one_in_cart( $passed, $added_product_id ) {
 	// empty cart first: new item will replace previous
 	wc_empty_cart();
 	return $passed;
 }
 
 

/* ************************************************************************************************
 *  small ideas app additions 
 */
 
 // Version CSS file in a theme
 wp_enqueue_style( 'theme-styles', get_stylesheet_directory_uri() . '/style.css?' . $filetime, array(), filemtime( get_stylesheet_directory() . '/style.css' ) );
 
 //nsw group form
 include( get_stylesheet_directory() . '/inc-smallideas/group-signup-form.php' );
 
 
 
 
 
 // Add checkbox to agree to terms during checkout
 add_action( 'woocommerce_review_order_before_submit', 'bbloomer_add_checkout_privacy_policy', 9 );
   
 function bbloomer_add_checkout_privacy_policy() {
	 woocommerce_form_field( 'privacy_policy', array(
	     'type'          => 'checkbox',
	     'class'         => array('form-row privacy'),
	     'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
	     'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
	     'required'      => true,
	     'label'         => 'I\'ve read and accept the <a href="/terms-conditions/">Terms & Conditions</a>',
	 )); 
 }
  
 // Show notice if customer does not tick
 add_action( 'woocommerce_checkout_process', 'bbloomer_not_approved_privacy' );
 
 function bbloomer_not_approved_privacy() {
     if ( ! (int) isset( $_POST['privacy_policy'] ) ) {
         wc_add_notice( __( 'Please acknowledge our app Terms & Conditions' ), 'error' );
     }
 }
 
 
 
 
 
 
 /* add custom js for gift date */
 wp_enqueue_script( 'script', get_template_directory_uri() . '/js/custom.js', array ( 'jquery' ), 1.1, true);
 
 /* redirect to checkout after adding to cart - required for gift option */
 function bbloomer_redirect_checkout_add_cart( $url ) {
     $url = get_permalink( get_option( 'woocommerce_checkout_page_id' ) ); 
     return $url;
 }
 
 add_filter( 'woocommerce_add_to_cart_redirect', 'bbloomer_redirect_checkout_add_cart' );
 
 
 /* change 'add to cart' text on button of gift product */
 add_filter( 'add_to_cart_text', 'woo_custom_single_add_to_cart_text' );                // < 2.1
 add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_single_add_to_cart_text' );  // 2.1 +
 function woo_custom_single_add_to_cart_text() {
     return __( 'Buy Now', 'woocommerce' );
 }
 
/**
 * Auto Complete all WooCommerce orders.
 */
add_action( 'woocommerce_thankyou', 'custom_woocommerce_auto_complete_order' );
function custom_woocommerce_auto_complete_order( $order_id ) { 
    if ( ! $order_id ) {
        return;
    }

    $order = wc_get_order( $order_id );
    $order->update_status( 'completed' );
}


// add action on order complete - create a new app user account + email
add_action('woocommerce_order_status_completed', 'create_app_credentials');
function create_app_credentials($order_id) {

//echo ' here- ';
	$order = new WC_Order( $order_id );
	$items = $order->get_items();
//print_r($items);
	$appPurchased = false;

	// check if 'is a gift'
	// if so, don't auto create the user account - Small Ideas will do this manually.
	$createAccount = true;
	/*foreach($order->meta_data as $metaItem){
		//echo "[{$metaItem->key}] ";
		if($metaItem->key == 'This is a gift' && $metaItem->value == 1){
			$createAccount = false;
		}
	}*/
	
	if($items){
//echo '-create-';
		foreach ( $items as $item ) {
		
			$product_name = $item['name'];
			$product_id = $item['product_id'];		

			$edition = get_post_meta( $product_id, '_app_edition', true );

			if($edition && strtoupper(trim($edition)) == 'YES'){
				$appPurchased = true;
				$isGift = false;
				
				//is a gift?
				$metadata = $item->get_meta_data();
				
				if($metadata){

					foreach($metadata as $m){
						if($m->key == 'gift_receiver_s_email_address'){
							
							$isGift = true;
							//reciever's email address
							if(strpos($m->value,'@')!==false){
								$giftReceiversEmail = $m->value;
							} 
							
						} else if($m->key == 'start_from'){						
							
							//starting date
							if($m->value){								
								list($dd,$mm,$yy) = explode('/',$m->value);								
								if($dd && $mm && $yy){
									$dtExtendedExpiry = new DateTime("$yy-$mm-$dd");
									$dtExtendedExpiry->modify('+1 year');  //expire 1 yr from starting date
									$extendedExpiry = $dtExtendedExpiry->format('Y-m-d');								
								}								 
							} 
							
						}
					}
				}
				
			}

		}
	}
	

	if($appPurchased){
		//echo $pathToEpLibrary."/initialise.php"; exit;
		include_once(EP_PATH."/initialise.php");
		include_once(EPABSPATH."/include/classes/user.class.php");
		include_once(EPABSPATH."/include/classes/DAL/userHistory.class.php");
		//include_once(EPABSPATH."/include/classes/DAL/userEdition.class.php");
		
		//which state is this product for 
		$state = get_post_meta( $product_id, '_app_state', true );
		$state = ($state) ? strtoupper(trim($state)) : 'VIC';
		
		//what is the subscription length (months)
		$months = get_post_meta( $product_id, '_app_months', true );
		$months = (trim($months)==1) ? 1 : 12;
		

		$password = Service::generatePassword();
		$emailAddress = $order->billing_email;

		//if a gift, user account should be email specified
		$accountEmail = (isset($giftReceiversEmail)) ? $giftReceiversEmail : $emailAddress;
		
		if($months==1){
			$accountExpiry = date('Y-m-d',strtotime('+1 month'));
		} else {
			$accountExpiry = (isset($extendedExpiry)) ? $extendedExpiry : date('Y-m-d',strtotime('+1 year'));
		}
		
						
		//create user
		$result = X_User::Update(array(
			'email' => $accountEmail,
			'state' => $state,
			'password' => $password,
			'lastRenewed' => date('Y-m-d'),
			'accountExpiry' => $accountExpiry,
			'isSubscription' => ($isGift) ? 0 : 1,
			'subscriptionMonths' => $months
		));
		//	print_r($result);
		error_log("AppLog-create_app_credentials-".$accountEmail.":months-".$months);

		//testing
		//Service::wpSendLogin('office@entice.com.au',$accountEmail,'CREATE USER DONE result - '.$result,0,0);   //1 success -2 already exists

 

		$isExistingCustomer = false;
		if($result > 0){
			//all good!

			//testing	
			//Service::wpSendLogin('office@entice.com.au',$accountEmail,'IN ALL GOOD SECTION '.$result,0,0);   //1 success -2 already exists
			
		} else if($result == EMAIL){
				
			//testing
			//Service::wpSendLogin('office@entice.com.au',$accountEmail,'CREATE USER DONE result - '.$result,0,0);   //1 success -2 already exists
			
			// email already in system, need to update existing account
			$userObj = DAL_User::GetByEmail($accountEmail);			
			
			
			//testing
			//Service::wpSendLogin('office@entice.com.au',$accountEmail,'USER '.$userObj->id,0,0);   //1 success -2 already exists
			
			
			//$result = X_User::AddToExistingWP($userObj,date('Y-m-d',strtotime('+1 year')));
			$dtExistingExpiry = $userObj->accountExpiry;
			
			//extend date
			if($userObj->accountExpiry){
				$dtNewExpiry = new DateTime($userObj->accountExpiry);
				
				if($months==1){
					$dtNewExpiry->modify('+1 month');  //expire 1 yr from starting date
				} else {
					$dtNewExpiry->modify('+1 year');  //expire 1 yr from starting date	
				}		
				
				if($dtNewExpiry->format('Y-m-d') > $accountExpiry)
					$accountExpiry = $dtNewExpiry->format('Y-m-d');
				
				$userObj->accountExpiry = $accountExpiry;
			} else {
				$userObj->accountExpiry = $accountExpiry;
			}					

			
			//testing
			//Service::wpSendLogin('office@entice.com.au',$accountEmail,'EXPIRY PART  '.$userObj->accountExpiry,0,0);   //1 success -2 already exists
			
			
			$userObj->subscriptionMonths = $months;
			$userObj->lastRenewed = date('Y-m-d');
			$userObj->isTrialAccount = 0;		//remove trial flag
			$userObj->state = $state;
			if(!$userObj->isSubscription && $isGift){
				$userObj->isSubscription = 0;
			}
			$id = $userObj->save();
			//print_r($userObj);
			//echo $id.'-';
			$isExistingCustomer = true;	
			
			
			//testing
			//Service::wpSendLogin('office@entice.com.au',$accountEmail,'SAVED USER  '.$id,0,0);   //1 success -2 already exists
			
			
			//clear user history object
			$userHistoryObjArr =  DAL_UserHistory::GetAbsolutelyAllForUser($userObj->id);
			
			//testing
			//Service::wpSendLogin('office@entice.com.au',$accountEmail,count($userHistoryObjArr)." em-".$userObj->email."  id-".$userObj->id,0,$isGift);				
			
			if($userHistoryObjArr){
				foreach($userHistoryObjArr as $historyObj){
					$historyObj->isDeleted = 1;
					$historyObj->save();
				}
			}

				
			
		} else {
			// unknown problem
			
			//send error notifcation email to user	+ admin
			Service::wpSendAccountError($emailAddress);						
			exit;
		}
		
		//check if just a subscription renewal - if so, don't send login
		$isRenewal = false;
		
		//checks here to work out if old account or just renewing.
		if($isExistingCustomer){			
			//one month ago
			$dtOneMonthAgo = date('Y-m-d',strtotime('-1 month'));
			//check if expired within last month
			if($dtExistingExpiry > $dtOneMonthAgo){
				$isRenewal = true;
			}						
		}
		
		if(!$isRenewal){
			/* send login details */
			Service::wpSendLogin($emailAddress,$accountEmail,$password,$isExistingCustomer,$isGift);	
		}

	}
//exit;

}



// add action on subscription renewal - extend account expiry + send email
// FOR RENEWALS, THIS IS TESTED TO RUN AFTER THE create_app_credentials FUNCTION ABOVE
add_action('woocommerce_subscription_renewal_payment_complete', 'renew_app_account');
function renew_app_account($last_order) {
	

		include_once(EP_PATH."/initialise.php");
		include_once(EPABSPATH."/include/classes/user.class.php");
//		include_once(EPABSPATH."/include/classes/DAL/userHistory.class.php");

		$emailAddress = $last_order->billing_email;

		// get account
		// NOTE if userobj not in system (ie it was deleted), then nothing happens
		$userObj = DAL_User::GetByEmail($emailAddress);			

		error_log("AppLog-renew_app_account-".$emailAddress);
		
		//NONE OF THIS IS REALLY NEEDED AS IT ALREADY RUNS UNDER APP CREATE ABOVE
		
		if($userObj){		
			//$expiryDate = date('Y-m-d',strtotime('+1 year'));
			//$userObj->accountExpiry = $expiryDate;	
			$userObj->lastRenewed = date('Y-m-d');		
			$id = $userObj->save();
			
			
			
			
			//testing
//			Service::wpSendRenewalThankyou('gav@entice.com.au',$expiryDate);					
			
			//clear user history object
			// $userHistoryObjArr =  DAL_UserHistory::GetAbsolutelyAllForUser($userObj->id);
// 			foreach($userHistoryObjArr as $historyObj){
// 				$historyObj->isDeleted = 1;
// 				$historyObj->save();
// 			}
			

			//send  notifcation 
		//	Service::wpSendRenewalThankyou($emailAddress,$expiryDate);	
		//EMAIL DISABLED 31/12/18 as requested by Belinda (although not 100% sure this was sending)

		}		

	

}



// add custom field to woocommerce products for small ideas app edition
add_action( 'woocommerce_product_options_general_product_data', 'wc_custom_add_custom_fields' );
function wc_custom_add_custom_fields() {
    // Print a custom text field
    woocommerce_wp_text_input( array(
        'id' => '_app_edition',
        'label' => 'Is SmallIdeas Digital Subscription? (type YES)',
        'description' => 'If YES entered, an app account will be created/updated.',
        'desc_tip' => 'true',
        'placeholder' => 'YES or blank'
    ) );
	
    woocommerce_wp_text_input( array(
        'id' => '_app_state',
        'label' => 'Enter State that this product allows access to',
        'description' => 'Enter VIC, NSW, QLD, SA or WA',
        'desc_tip' => 'true',
        'placeholder' => ''
    ) );
	
    woocommerce_wp_text_input( array(
        'id' => '_app_months',
        'label' => 'Enter number of months per subscription period',
        'description' => 'Enter 1 or 12',
        'desc_tip' => 'true',
        'placeholder' => '12'
    ) );
	
}

add_action( 'woocommerce_process_product_meta', 'wc_custom_save_custom_fields' );
function wc_custom_save_custom_fields( $post_id ) {
    if ( ! empty( $_POST['_app_edition'] ) ) {
        update_post_meta( $post_id, '_app_edition', esc_attr( $_POST['_app_edition'] ) );
    }
    if ( ! empty( $_POST['_app_state'] ) ) {
        update_post_meta( $post_id, '_app_state', esc_attr( $_POST['_app_state'] ) );
    }
    if ( ! empty( $_POST['_app_months'] ) ) {
        update_post_meta( $post_id, '_app_months', esc_attr( $_POST['_app_months'] ) );
    }
}




//add_filter('gettext', 'custom_strings_translation', 20, 3);

function custom_strings_translation( $translated_text, $text, $domain ) {

  switch ( $translated_text ) {
    case 'Ship to a different address?' : 
      $translated_text =  __( 'Shipping address', '__x__' ); 
      break;
  }

  return $translated_text;
}





/* 
 * END small ideas app additions 
 *************************************************************************************************/




define('SITEORIGIN_THEME_VERSION', '2.5.4');
define('SITEORIGIN_THEME_JS_PREFIX', '.min');

// Load the new settings framework
include get_template_directory() . '/inc/settings/settings.php';
include get_template_directory() . '/inc/metaslider/metaslider.php';
include get_template_directory() . '/inc/plugin-activation/plugin-activation.php';
include get_template_directory() . '/inc/class-tgm-plugin-activation.php';

// Load the theme specific files
include get_template_directory() . '/inc/panels.php';
include get_template_directory() . '/inc/settings.php';
include get_template_directory() . '/inc/extras.php';
include get_template_directory() . '/inc/template-tags.php';
include get_template_directory() . '/inc/gallery.php';
include get_template_directory() . '/inc/metaslider.php';
include get_template_directory() . '/inc/widgets.php';
include get_template_directory() . '/inc/menu.php';
include get_template_directory() . '/inc/breadcrumbs.php';
include get_template_directory() . '/inc/customizer.php';
include get_template_directory() . '/inc/legacy.php';

// include get_template_directory() . '/tour/tour.php';

include get_template_directory() . '/fontawesome/icon-migration.php';

// This is the legacy premium file
include get_template_directory() . '/premium/premium.php';

if ( ! function_exists( 'vantage_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since vantage 1.0
 */
function vantage_setup() {

	// Make the theme translatable
	load_theme_textdomain( 'vantage', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails
	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'siteorigin-panels', array(
		'home-page' => true,
		'margin-bottom' => 35,
		'home-page-default' => 'default-home',
		'home-demo-template' => 'home-panels.php',
		'responsive' => siteorigin_setting( 'layout_responsive' ),
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'vantage' ),
	) );

	// Enable support for Post Formats
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// We support WooCommerce
	add_theme_support('woocommerce');

	set_post_thumbnail_size(720, 380, true );
	add_image_size( 'vantage-thumbnail-no-sidebar', 1080, 380, true );
	add_image_size( 'vantage-slide', 960, 480, true );
	add_image_size( 'vantage-carousel', 272, 182, true );
	add_image_size( 'vantage-grid-loop', 436, 272, true );

	add_theme_support( 'custom-logo' );

	add_theme_support( 'title-tag' );

	if( !defined('SITEORIGIN_PANELS_VERSION') ){
		// Only include panels lite if the panels plugin doesn't exist
		include get_template_directory() . '/inc/panels-lite/panels-lite.php';
	}

	global $content_width, $vantage_site_width;
	if ( ! isset( $content_width ) ) $content_width = 720; /* pixels */

	if ( ! isset( $vantage_site_width ) ) {
		$vantage_site_width = siteorigin_setting('layout_bound') == 'full' ? 1080 : 1010;
	}

	$container = 'content';
	$render_function = '';
	$wrapper = true;
	// The posts_per_page setting only works when type is 'scroll'.
	// When type is set to 'click' either explicitly or automatically,
	// due to there being footer widgets, it uses the "Blog pages show at most X posts" setting
	// under Settings > Reading instead. :(
	// https://wordpress.org/support/topic/posts_per_page-not-having-any-effect
	$posts_per_page = 7;
	if ( siteorigin_setting( 'blog_archive_layout' ) == 'circleicon' ) {
		$container = 'vantage-circleicon-loop';
		$render_function = 'vantage_infinite_scroll_render';
		$wrapper = false;
		$posts_per_page = 6;
	}
	else if ( siteorigin_setting( 'blog_archive_layout' ) == 'grid' ) {
		$container = 'vantage-grid-loop';
		$render_function = 'vantage_infinite_scroll_render';
		$wrapper = false;
		$posts_per_page = 8;
	}

	add_filter( 'infinite_scroll_settings', 'vantage_infinite_scroll_settings' );

	// Allowing use of shortcodes in taxonomy descriptions
	add_filter( 'term_description', 'shortcode_unautop');
	add_filter( 'term_description', 'do_shortcode' );

	add_theme_support( 'infinite-scroll', array(
		'container' => $container,
		'footer' => 'page',
		'render' => $render_function,
		'wrapper' => $wrapper,
		'posts_per_page' => $posts_per_page,
		'type' => 'click',
		// 'footer_widgets' => 'sidebar-footer',
	) );

	$mega_menu_active = function_exists( 'ubermenu' ) || ( function_exists( 'max_mega_menu_is_enabled' ) && max_mega_menu_is_enabled( 'primary' ) );
	if( siteorigin_setting( 'navigation_responsive_menu' ) && !$mega_menu_active ) {
		include get_template_directory() . '/inc/mobilenav/mobilenav.php';
	}

	// We'll use template settings
	add_theme_support( 'siteorigin-template-settings' );
}
endif; // vantage_setup
add_action( 'after_setup_theme', 'vantage_setup' );

if ( ! function_exists( 'vantage_premium_setup' ) ) :
/**
 * Add support for premium theme components
 */
function vantage_premium_setup(){
	// This theme supports the no attribution addon
	add_theme_support( 'siteorigin-premium-no-attribution', array(
		'filter'  => 'vantage_footer_attribution',
		'enabled' => siteorigin_setting( 'general_attribution' ),
		'siteorigin_setting' => 'general_attribution'
	) );

	// This theme supports the ajax comments addon
	add_theme_support( 'siteorigin-premium-ajax-comments', array(
		'enabled' => siteorigin_setting( 'social_ajax_comments' ),
		'siteorigin_setting' => 'social_ajax_comments'
	) );
}
endif;
add_action( 'after_setup_theme', 'vantage_premium_setup' );

function vantage_siteorigin_css_snippets_paths( $paths ){
	$paths[] = get_template_directory() . '/snippets/';
	return $paths;
}
add_filter( 'siteorigin_css_snippet_paths', 'vantage_siteorigin_css_snippets_paths' );

if( !function_exists( 'vantage_infinite_scroll_settings' ) ) :
// Override Jetpack Infinite Scroll default behaviour of ignoring explicit posts_per_page setting when type is 'click'.
function vantage_infinite_scroll_settings( $settings ) {
	if ( $settings['type'] == 'click' ) {
		if( siteorigin_setting( 'blog_archive_layout' ) == 'circleicon' ) {
			$settings['posts_per_page'] = 6;
		}
		else if ( siteorigin_setting( 'blog_archive_layout' ) == 'grid' ) {
			$settings['posts_per_page'] = 8;
		}
	}
	return $settings;
}
endif;

if ( ! function_exists( 'vantage_infinite_scroll_render' ) ) :
function vantage_infinite_scroll_render() {
	ob_start();
	get_template_part( 'loops/loop', siteorigin_setting( 'blog_archive_layout' ) );
	$var = ob_get_clean();
	// Strip leading and trailing whitespace.
	$var = trim( $var );
	// Remove the opening and closing div tags for subsequent pages of posts for correct circleicon and grid layouts.
	$var = preg_replace( '/^<div.+>/', '', $var );
	$var = preg_replace( '/<\/div>$/', '', $var );
	echo $var;
}
endif;

if ( ! function_exists( 'vantage_is_woocommerce_active' ) ) :
/**
 * Check that WooCommerce is active
 *
 * @return bool
 */
function vantage_is_woocommerce_active() {
	return in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
}
endif;

if( !function_exists('vantage_register_custom_background') ) :
/**
 * Setup the WordPress core custom background feature.
 *
 * @since vantage 1.0
 */
function vantage_register_custom_background() {

	if(siteorigin_setting('layout_bound') == 'boxed') {
		$args = array(
			'default-color' => 'e8e8e8',
			'default-image' => '',
		);

		$args = apply_filters( 'vantage_custom_background_args', $args );
		add_theme_support( 'custom-background', $args );
	}

}
endif;
add_action( 'after_setup_theme', 'vantage_register_custom_background' );


if( !function_exists('vantage_widgets_init') ) :
/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since vantage 1.0
 */
function vantage_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'vantage' ),
		'id' => 'sidebar-1',
		'description' => __( 'Displays to the right or left of the content area.', 'vantage' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	if( vantage_is_woocommerce_active() ) {
		register_sidebar( array(
			'name' => __( 'Shop', 'vantage' ),
			'id' => 'shop',
			'description' => __( 'Displays on WooCommerce pages.', 'vantage' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	}

	register_sidebar( array(
		'name' => __( 'Footer', 'vantage' ),
		'id' => 'sidebar-footer',
		'description' => __( 'Displays below the content area.', 'vantage' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Header', 'vantage' ),
		'id' => 'sidebar-header',
		'description' => __( 'Displays to the right of the logo.', 'vantage' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Masthead', 'vantage' ),
		'id' => 'sidebar-masthead',
		'description' => __( 'Replaces the logo and header widget area.', 'vantage' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
endif;
add_action( 'widgets_init', 'vantage_widgets_init' );


if( !function_exists('vantage_print_styles') ) :
/**
 * Print all the necessary Vantage styles in the header.
 */
function vantage_print_styles(){
	if( !siteorigin_setting('layout_responsive') ) return;

	// Create the footer and masthead widget CSS
	$sidebars_widgets = wp_get_sidebars_widgets();
	$footer_count = isset( $sidebars_widgets['sidebar-footer'] ) ? count( $sidebars_widgets['sidebar-footer'] ) : 1;
	$footer_count = max( $footer_count, 1 );
	$masthead_count = isset( $sidebars_widgets['sidebar-masthead'] ) ? count( $sidebars_widgets['sidebar-masthead'] ) : 1;
	$masthead_count = max( $masthead_count, 1 );

	?>
	<style type="text/css" media="screen">
		#footer-widgets .widget { width: <?php echo round(100/$footer_count,3) . '%' ?>; }
		#masthead-widgets .widget { width: <?php echo round(100/$masthead_count,3) . '%' ?>; }
	</style>
	<?php
}
endif;
add_action('wp_head', 'vantage_print_styles', 11);


if( !function_exists('vantage_scripts') ) :
/**
 * Enqueue scripts and styles
 */
function vantage_scripts() {
	wp_enqueue_style( 'vantage-style', get_stylesheet_uri(), array(), SITEORIGIN_THEME_VERSION );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/fontawesome/css/font-awesome.css', array(), '4.6.2' );

	if ( is_active_widget( false, false, 'vantage-social-media' ) ) {
		wp_enqueue_style( 'social-media-widget', get_template_directory_uri().'/css/social-media-widget.css', array(), SITEORIGIN_THEME_VERSION );
	}

	if ( class_exists( 'woocommerce' ) ) {
		wp_enqueue_style( 'vantage-woocommerce', get_template_directory_uri() . '/css/woocommerce.css' );
	}

	$in_footer = siteorigin_setting( 'general_js_enqueue_footer' );
	wp_enqueue_script( 'jquery-flexslider' , get_template_directory_uri() . '/js/jquery.flexslider' . SITEORIGIN_THEME_JS_PREFIX . '.js' , array('jquery'), '2.1', $in_footer );
	wp_enqueue_script( 'jquery-touchswipe' , get_template_directory_uri() . '/js/jquery.touchSwipe' . SITEORIGIN_THEME_JS_PREFIX . '.js' , array( 'jquery' ), '1.6.6', $in_footer );
	wp_enqueue_script( 'vantage-main' , get_template_directory_uri() . '/js/jquery.theme-main' . SITEORIGIN_THEME_JS_PREFIX . '.js', array( 'jquery' ), SITEORIGIN_THEME_VERSION, $in_footer );

	if( siteorigin_setting( 'layout_fitvids' ) ) {
		wp_enqueue_script( 'jquery-fitvids' , get_template_directory_uri() . '/js/jquery.fitvids' . SITEORIGIN_THEME_JS_PREFIX . '.js' , array('jquery'), '1.0', $in_footer );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply', $in_footer );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'vantage-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation' . $js_suffix . '.js', array( 'jquery' ), '20120202', $in_footer );
	}

	wp_enqueue_script( 'vantage-html5', get_template_directory_uri() . '/js/html5' . SITEORIGIN_THEME_JS_PREFIX . '.js', array(), '3.7.3' );
	wp_script_add_data( 'vantage-html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'vantage-selectivizr', get_template_directory_uri() . '/js/selectivizr' . SITEORIGIN_THEME_JS_PREFIX . '.js', array(), '1.0.2' );
	wp_script_add_data( 'vantage-selectivizr', 'conditional', '(gte IE 6)&(lte IE 8)' );
}
endif;
add_action( 'wp_enqueue_scripts', 'vantage_scripts' );

if( !function_exists('vantage_top_text_area') ) :
/**
 * Display some text in the text area.
 */
function vantage_top_text_area(){
	echo wp_kses_post( siteorigin_setting('logo_header_text') );
}
endif;
add_action('vantage_support_text', 'vantage_top_text_area');

if( !function_exists('vantage_back_to_top') ) :
/**
 * Display the scroll to top link.
 */
function vantage_back_to_top() {
	if( !siteorigin_setting('navigation_display_scroll_to_top') && !siteorigin_setting('navigation_mobile_navigation') ) return;
	$scroll_to_top = siteorigin_setting('navigation_display_scroll_to_top') ? 'scroll-to-top' : '';
	?><a href="#" id="scroll-to-top" class="<?php echo $scroll_to_top; ?>" title="<?php esc_attr_e('Back To Top', 'vantage') ?>"><span class="vantage-icon-arrow-up"></span></a><?php
}
endif;
add_action('wp_footer', 'vantage_back_to_top');

if( !function_exists('vantage_get_query_variables') ) :
/**
 * @return mixed
 */
function vantage_get_query_variables(){
	global $wp_query;
	$vars = $wp_query->query_vars;
	foreach( $vars as $k => $v ) {
		if(empty($vars[$k])) unset ($vars[$k]);
	}
	unset( $vars['update_post_term_cache'] );
	unset( $vars['update_post_meta_cache'] );
	unset( $vars['cache_results'] );
	unset( $vars['comments_per_page'] );

	return $vars;
}
endif;

if( !function_exists('vantage_render_slider') ) :
/**
 * Render the slider.
 */
function vantage_render_slider(){

	if( is_front_page() && !in_array( siteorigin_setting( 'home_slider' ), array( '', 'none' ) ) ) {
		$settings_slider = siteorigin_setting( 'home_slider' );
		$slider_stretch = siteorigin_setting( 'home_slider_stretch' );

		if(!empty($settings_slider)) {
			$slider = $settings_slider;
		}
	}
	$page_id = get_the_ID();
	$is_wc_shop = vantage_is_woocommerce_active() && is_woocommerce() && is_shop();
	if ( $is_wc_shop ) {
		$page_id = wc_get_page_id( 'shop' );
	}
	if( ( is_page() || $is_wc_shop ) && get_post_meta($page_id, 'vantage_metaslider_slider', true) != 'none' ) {
		$page_slider = get_post_meta($page_id, 'vantage_metaslider_slider', true);
		if( !empty($page_slider) ) {
			$slider = $page_slider;
		}
		$slider_stretch = get_post_meta($page_id, 'vantage_metaslider_slider_stretch', true);
		if( $slider_stretch === '' ) {
			// We'll default to whatever the home page slider stretch setting is
			$slider_stretch = siteorigin_setting('home_slider_stretch');
		}
	}

	if( empty($slider) ) return;

	global $vantage_is_main_slider;
	$vantage_is_main_slider = true;

	?><div id="main-slider" <?php if( $slider_stretch ) echo 'data-stretch="true"' ?>><?php


	if($slider == 'demo') get_template_part('slider/demo');
	elseif( substr($slider, 0, 5) == 'meta:' ) {
		list($null, $slider_id) = explode(':', $slider);

		echo do_shortcode( "[metaslider id=" . intval($slider_id) . "]" );
	}

	?></div><?php
	$vantage_is_main_slider = false;
}
endif;


if( !function_exists('vantage_post_class_filter') ) :
function vantage_post_class_filter($classes){
	$classes[] = 'post';

	if( has_post_thumbnail() && !is_singular() ) {
		$classes[] = 'post-with-thumbnail';
		$classes[] = 'post-with-thumbnail-' . siteorigin_setting( 'blog_featured_image_type' );
	}

	$classes = array_unique($classes);
	return $classes;
}
endif;
add_filter('post_class', 'vantage_post_class_filter');


if( !function_exists('vantage_filter_vantage_post_on_parts') ) :
/**
 * Filter the posted on parts to remove the ones disabled in settings.
 *
 * @param $parts
 * @return mixed
 */
function vantage_filter_vantage_post_on_parts($parts){
	if( !siteorigin_setting('blog_post_date') ) $parts['on'] = '';
	if( !siteorigin_setting('blog_post_author') ) $parts['by'] = '';
	if( !siteorigin_setting('blog_post_comment_count') ) $parts['with'] = '';

	return $parts;
}
endif;
add_filter('vantage_post_on_parts', 'vantage_filter_vantage_post_on_parts');


if( !function_exists('vantage_get_site_width') ) :
/**
 * Get the site width.
 *
 * @return int The side width in pixels.
 */
function vantage_get_site_width(){
	return apply_filters('vantage_site_width', !empty($GLOBALS['vantage_site_width']) ? $GLOBALS['vantage_site_width'] : 1080);
}
endif;


if( !function_exists('vantage_responsive_header') ) :
/**
 * Add the responsive header
 */
function vantage_responsive_header(){
	if( siteorigin_setting('layout_responsive') ) {
		?><meta name="viewport" content="width=device-width, initial-scale=1" /><?php
	}
	else {
		?><meta name="viewport" content="width=1280" /><?php
	}
}
endif;
add_action('wp_head', 'vantage_responsive_header');


if( !function_exists('vantage_footer_site_info_sub') ) :
/**

 * Handles the site title, copyright symbol and year string replace for the Footer Copyright theme option.

 */
function vantage_footer_site_info_sub($copyright){

	return str_replace(
		array('{site-title}', '{copyright}', '{year}'),
		array(get_bloginfo('name'), '&copy;', date('Y')),
		$copyright
	);

}
endif;
add_filter( 'vantage_site_info', 'vantage_footer_site_info_sub' );


if( ! function_exists( 'vantage_filter_mobilenav' ) ) :
function vantage_filter_mobilenav($text){

	if( siteorigin_setting('navigation_responsive_menu_text') ) {
		$text['navigate'] = siteorigin_setting('navigation_responsive_menu_text');
	}
	return $text;
}
endif;
add_filter('siteorigin_mobilenav_text', 'vantage_filter_mobilenav');


if( ! function_exists( 'vantage_filter_mobilenav_collapse' ) ) :
function vantage_filter_mobilenav_collapse($collpase){
	return siteorigin_setting('navigation_responsive_menu_collapse');
}
endif;
add_filter('siteorigin_mobilenav_resolution', 'vantage_filter_mobilenav_collapse');


if( ! function_exists( 'vantage_filter_mobilenav_search' ) ) :
function vantage_filter_mobilenav_search( $search ) {
	if( siteorigin_setting( 'navigation_responsive_menu_search' ) ) {
		return $search;
	}
	return false;
}
endif;
add_filter( 'siteorigin_mobilenav_search', 'vantage_filter_mobilenav_search' );

/**
 * Add some plugins to TGM plugin activation
 */
function vantage_recommended_plugins(){
	$plugins = array(
		array(
			'name'      => __('SiteOrigin Page Builder', 'vantage'),
			'slug'      => 'siteorigin-panels',
			'required'  => false,
		),
		array(
			'name'      => __('SiteOrigin Widgets Bundle', 'vantage'),
			'slug'      => 'so-widgets-bundle',
			'required'  => false,
		),
		array(
			'name'      => __('SiteOrigin CSS', 'vantage'),
			'slug'      => 'so-css',
			'required'  => false,
		),
	);

	$config = array(
		'id'           => 'tgmpa-vantage',         // Unique ID for hashing notices for multiple instances of TGMPA.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'vantage_recommended_plugins' );

remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
add_action( 'woocommerce_after_checkout_form', 'woocommerce_checkout_coupon_form' );

add_action( 'woocommerce_after_checkout_form', 'custom_js_script' );
function custom_js_script() { 
	if( !is_user_logged_in() ) {?>
	<script>
		jQuery(document).ready( function($) {
			$('.lost_password').append( '<p class="small-notice">* this password may be different to your app password.</p>');
			$('.lost_password a').attr( 'href', '/my-account/lost-password');
    		var text = "";
    		var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    		for(var i = 0; i < 8; i++) {
        		text += possible.charAt(Math.floor(Math.random() * possible.length));
			}
			$('#account_password').val(text);
			$('#billing_email').change( function() {
				var userName = $(this).val();
				$('#account_username').val(userName);
			});
		});
	</script>
	<style>
		.woocommerce-account-fields {display: none;}
	</style>
<?php }
}