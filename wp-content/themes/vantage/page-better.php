<?php


/* Template Name: Better Blog Archive */

get_header(); ?>

<div id="primary" class="content-area">

	<div id="content" class="site-content" role="main">

		<?php get_template_part( 'loops/loop', siteorigin_setting('blog_archive_layout') ) ?>

	</div><!-- #content .site-content -->

</div><!-- #primary .content-area -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>