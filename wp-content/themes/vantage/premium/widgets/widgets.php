<?php
/**
 * Premium Widgets
 */

/**
 * Widget for displaying a responsive Google map
 */
class SiteOrigin_Widgets_GoogleMap extends WP_Widget {
	function __construct() {
		parent::__construct(
			'siteorigin-google-map',
			__( 'SiteOrigin Google Map', 'vantage' ),
			array(
				'description' => __( 'Displays a very simple Google map', 'vantage' ),
			)
		);
	}

	/**
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {

		$instance = wp_parse_args($instance, array(
			'address' => '',
			'height' => 250,
			'zoom' => 14,
		));

		$map_id = md5( $instance['address'] );

		$address = preg_replace( '/[\r\n]/m', ', ', $instance['address'] );
		$address = preg_replace( '/\,[\s\,]+/', ', ', $address );

		$js_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?sensor=false' );
		wp_enqueue_script( 'siteorigin-widgets-maps', get_template_directory_uri() . '/premium/widgets/js/map' . $js_suffix . '.js', array( 'jquery' ), SITEORIGIN_THEME_VERSION );

		echo $args['before_widget'];
		?>
		<div class="google-map-canvas" style="height:<?php echo $instance['height'] ?>px;" id="map-canvas-<?php echo $map_id ?>" data-address="<?php echo esc_attr( $address ) ?>" data-zoom="<?php echo esc_attr( $instance['zoom'] ) ?>"></div>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * @param array $new
	 * @param array $old
	 * @return array
	 */
	function update( $new, $old ) {
		$new['height'] = intval( $new['height'] );
		$new['zoom'] = intval( $new['zoom'] );

		if ( empty( $new['height'] ) ) $new['height'] = 250;
		if ( empty( $new['zoom'] ) ) $new['zoom'] = 14;

		return $new;
	}

	/**
	 * @param array $instance
	 * @return string|void
	 */
	function form( $instance ) {
		$instance = wp_parse_args($instance, array(
			'address' => '',
			'height' => 250,
			'zoom' => 14,
		));
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'address' ) ?>"><?php _e( 'Map Location', 'vantage' ) ?></label>
			<textarea class="widefat" rows="4" name="<?php echo $this->get_field_name( 'address' ) ?>" id="<?php echo $this->get_field_id( 'address' ) ?>"><?php echo esc_html($instance['address']) ?></textarea>
			<small class="description"><?php _e( 'The Map address', 'vantage' ) ?></small>
		</p>
	
		<p>
			<label for="<?php echo $this->get_field_id( 'height' ) ?>"><?php _e( 'Height', 'vantage' ) ?></label>
			<input type="text" class="small-text" name="<?php echo $this->get_field_name( 'height' ) ?>" id="<?php echo $this->get_field_id( 'height' ) ?>" value="<?php echo esc_attr($instance['height']) ?>" />
			<small class="description"><?php _e( 'Map pixel, the width is decided by the size of its panel.', 'vantage' ) ?></small>
		</p>
	
		<p>
			<label for="<?php echo $this->get_field_id( 'zoom' ) ?>"><?php _e( 'Zoom', 'vantage' ) ?></label>
			<input type="text" class="small-text" name="<?php echo $this->get_field_name( 'zoom' ) ?>" id="<?php echo $this->get_field_id( 'zoom' ) ?>" value="<?php echo esc_attr($instance['zoom']) ?>" />
			<small class="description"><?php _e( 'The zoom of the map.', 'vantage' ) ?></small>
		</p>
		<?php
	}
}


/**
 * A panel that lets you embed video.
 */
class SiteOrigin_Widgets_Video extends WP_Widget {
	function __construct() {
		parent::__construct(
			'embedded-video',
			__( 'SiteOrigin Embedded Video', 'vantage' ),
			array(
				'description' => __( 'Embeds a video.', 'vantage' ),
			)
		);
	}

	/**
	 * Display the video using
	 *
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		$embed = new WP_Embed();

		echo $args['before_widget'];
		?><div class="fitvid"><?php echo $embed->run_shortcode( '[embed]' . $instance['video'] . '[/embed]' ) ?></div><?php
		echo $args['after_widget'];
	}

	function form( $instance ) {
		$instance = wp_parse_args( $instance, array(
			'video' => '',
		) )

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'video' ) ?>"><?php _e( 'Video', 'vantage' ) ?></label>
			<input class="widefat" name="<?php echo $this->get_field_name( 'video' ) ?>" id="<?php echo $this->get_field_id( 'video' ) ?>" <?php echo esc_attr( $instance['video'] ) ?>>
		</p>
		<?php
	}

	function update( $new, $old ) {
		$new['video'] = str_replace( 'https://', 'http://', $new['video'] );
		return $new;
	}
}

/**
 * A basic panel that just generates a list.
 */
class SiteOrigin_Widgets_List extends WP_Widget {
	function __construct() {
		parent::__construct(
			'siteorigin-list',
			__( 'SiteOrigin Bullet List', 'vantage' ),
			array(
				'description' => __( 'A simple bullet list.', 'vantage' ),
			)
		);
	}

	/**
	 * Render the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( $instance['headline'] ) {
			echo $args['before_title'] . esc_html( $instance['headline'] ) . $args['after_title'];
		}

		if ( empty( $instance['style'] ) ) $instance['style'] = 'default';

		// Add the list items
		$instance['text'] = preg_replace( "/\*+(.*)?/i", "<ul><li>$1</li></ul>", $instance['text'] );
		$instance['text'] = preg_replace( "/(\<\/ul\>\n(.*)\<ul\>*)+/", "", $instance['text'] );
		$instance['text'] = wpautop( $instance['text'] );

		?><div class="<?php echo esc_attr( 'list-style-' . $instance['style'] ) ?> entry-content"><?php echo $instance['text'] ?></div><?php

		echo $args['after_widget'];
	}

	/**
	 * Display the form
	 *
	 * @param array $instance
	 * @return string|void
	 */
	function form( $instance ) {
		$instance = wp_parse_args( $instance, array(
			'headline' => '',
			'text' => '',
			'style' => false,
		) );

		$styles = apply_filters( 'siteorigin_list_styles', array( 'default' => __( 'Default', 'vantage' ) ) );

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'headline' ) ?>"><?php _e( 'Headline', 'vantage' ) ?></label>
			<input class="widefat" name="<?php echo $this->get_field_name( 'headline' ) ?>" id="<?php echo $this->get_field_id( 'headline' ) ?>" value="<?php echo esc_attr( $instance['headline'] ) ?>">
		</p>
	
		<p>
			<label for="<?php echo $this->get_field_id( 'text' ) ?>"><?php _e( 'List Text', 'vantage' ) ?></label>
			<textarea class="widefat" rows="6" name="<?php echo $this->get_field_name( 'text' ) ?>" id="<?php echo $this->get_field_id( 'text' ) ?>"><?php echo esc_textarea( $instance['text'] ) ?></textarea>
			<small class="description"><?php _e( 'Use a * at the beginning of each list entry line.', 'vantage' ) ?></small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'style' ) ?>"><?php _e( 'List Text', 'vantage' ) ?></label>
			<select name="<?php echo $this->get_field_name( 'style' ) ?>">
				<?php foreach ( $styles as $k => $v ) : ?>
				<option value="<?php echo esc_attr( $k ) ?>" <?php selected( $k, $instance['style'] ) ?>><?php echo esc_html( $v ) ?></option>
				<?php endforeach ?>
			</select>
		</p>
		<?php
	}

	function update( $new, $old ) {
		return $new;
	}
}

/**
 * A widget for displaying a contact form
 */
class SiteOrigin_Widgets_CF7 extends WP_Widget {
	function __construct() {
		parent::__construct(
			'siteorigin-cf7',
			__( 'SiteOrigin Contact Form 7', 'vantage' ),
			array(
				'description' => __( 'Displays a contact form.', 'vantage' ),
			)
		);
	}

	/**
	 *
	 *
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		if ( !empty( $instance['title'] ) ) {
			echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title'];
		}
		echo do_shortcode( '[contact-form-7 id="' . intval( $instance['form'] ) . '" title=""]' );
	}

	/**
	 * Display the CF7 widget form.
	 *
	 * @param array $instance
	 * @return string|void
	 */
	function form( $instance ) {
		if ( !is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
			?><p><?php _e( 'This widget requires the Contact Form 7 plugin.', 'vantage' ) ?></p><?php
			return;
		}

		$instance = wp_parse_args( $instance, array(
			'title' => '',
			'form' => 0,
		) );

		$forms = get_posts( array(
			'post_type' => 'wpcf7_contact_form',
			'numberposts' => -1,
		) );

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ) ?>"><?php _e( 'Title', 'vantage' ) ?></label>
			<input class="widefat" name="<?php echo $this->get_field_name( 'title' ) ?>" id="<?php echo $this->get_field_id( 'title' ) ?>" value="<?php echo esc_attr( $instance['title'] ) ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'form' ) ?>"><?php _e( 'Contact Form', 'vantage' ) ?></label>
			<select name="<?php echo $this->get_field_name( 'form' ) ?>" id="<?php echo $this->get_field_id( 'form' ) ?>">
				<?php foreach ( $forms as $form ) : ?>
				<option value="<?php echo $form->ID ?>" <?php selected( $instance['form'], $form->ID ) ?>><?php echo esc_html( $form->post_title ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<?php
	}

	function update( $new, $old ) {
		$new['form'] = intval( $new['form'] );
		return $new;
	}
}

function siteorigin_widgets_premium_register() {
	register_widget( 'SiteOrigin_Widgets_GoogleMap' );
	register_widget( 'SiteOrigin_Widgets_Video' );
	register_widget( 'SiteOrigin_Widgets_List' );
	register_widget( 'SiteOrigin_Widgets_CF7' );
}
