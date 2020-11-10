<div id="single-comments-wrapper">
	<?php
	$original_template = SiteOrigin_Premium_Ajax_Comments::single()->original_comments_template;

	if( ! empty( $original_template ) && file_exists( $original_template ) ) {
		include $original_template;
	}
	else{
		$file = locate_template( array( basename( $original_template ), 'comments.php' ) );
		if( ! empty( $file ) ){
			include $file;
		}
	}
	?>
</div>