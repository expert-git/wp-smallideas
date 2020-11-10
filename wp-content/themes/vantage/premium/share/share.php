<?php

/**
 * Render the share buttons.
 *
 * @param array $settings Settings for the share buttons.
 */
function siteorigin_share_render( $settings = array() ) {
	$settings = wp_parse_args( $settings, array(
		'width' => 25,
		'like_text' => __( 'like', 'vantage' ),
		'twitter' => ''
	) );

	static $facebook_loaded = false;
	if(!$facebook_loaded) {
		?>
		<div id="fb-root"></div>
		<script type="text/javascript">
			(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		</script>
		<?php
		$facebook_loaded = true;
	}

	static $google_loaded = false;
	if(!$google_loaded) {
		?>
		<script type="text/javascript">
			// Google Plus One
			(function () {
				var po = document.createElement( 'script' );
				po.type = 'text/javascript';
				po.async = true;
				po.src = 'https://apis.google.com/js/plusone.js';
				var s = document.getElementsByTagName( 'script' )[0];
				s.parentNode.insertBefore( po, s );
			})();
		</script>
		<?php
		$google_loaded = true;
	}

	static $linkedin_loaded = false;
	if(!$linkedin_loaded) {
		?>
		<script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script>
		<?php
		$linkedin_loaded = true;
	}

	?>
	<ul class="share-buttons">
		<li class="network facebook" style="width:<?php echo intval( $settings['width'] ) ?>%">

			<div
				class="fb-like"
				data-href="<?php echo get_permalink() ?>"
				data-width="<?php echo intval( $settings['width'] ) ?>"
				data-layout="button_count"
				data-send="false"
				data-height="21"
				data-show-faces="false"
				data-action="<?php echo esc_attr($settings['like_text']) ?>"></div>
		</li>

		<li class="network twitter" style="width:<?php echo intval( $settings['width'] ) ?>%">
			<?php
			$related = array();
			$related[ ] = $settings['twitter'];
			$twitter_url = add_query_arg( array(
				'url' => get_permalink(),
				'via' => siteorigin_setting( 'social_twitter' ),
				'text' => get_the_title(),
				'related' => implode( ',', $related )
			), 'http' . (is_ssl() ? 's' : '' ) . '://platform.twitter.com/widgets/tweet_button.html' );

			?>
			<iframe allowtransparency="true" frameborder="0" scrolling="no" src="<?php echo esc_attr( $twitter_url ) ?>" style="height:20px;"></iframe>
		</li>

		<li class="network plusone" style="width:<?php echo intval( $settings['width'] )-4 ?>%">
			<div class="g-plusone" data-size="medium" data-width="160"></div>
		</li>

		<li class="network linkedin" style="width:<?php echo intval( $settings['width'] )+4 ?>%;">
			<script type="IN/Share" data-counter="right"></script>
		</li>
	</ul>
	<?php
}