<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


$search_query = get_search_query();
if( is_product_category() ) {
	$term = get_queried_object();
	$parent_id   = $term->parent;
} elseif (is_single()){
	global $post;
	$term_list = wp_get_post_terms($post->ID,'product_cat');
	$term = $term_list[0];
	$parent_id = $term_list[0]->parent;
}

?>
<div id="shop-container" class="row">
	<?php get_sidebar('shop'); ?>
	<div id="shop-content" role="main" class="col-md-9">
		<div id="top-shop">
			<div id="shop-search">
				<strong>Search<?php if( $term ) { $name = ( $parent_id > 0 ) ? get_term_by( 'term_id', $parent_id, 'product_cat' )->name : $term->name; echo ' '.$name; };?> </strong>
				<form method="get" action="<?php bloginfo("url"); ?>/">
					<input value="<?php echo $search_query; ?>" name="s" class="search-input" type="text">
					<input type="submit" value=">>" class="search-submit">
					<input name="post_type" value="product" type="hidden">
					<?php if( $term ) {
						// If a parent term id exist, we get the parent term slug
						$slug = ( $parent_id > 0 ) ? get_term_by( 'term_id', $parent_id, 'product_cat' )->slug : $term->slug;
						echo '<input type="hidden" value="'.$slug.'" name="product_cat" />';
					};?>
				</form>
			</div>
			
			<br clear="all" />
		</div>
			
		