<?php

class Widget_Tyche_Banner extends WP_Widget {
	/**
	 * @internal
	 */
	public function __construct() {
		parent::__construct(
			'Tyche_Companion_Banner', // Base ID
			__( 'Tyche Companion Banner', 'tyche' ), // Name
			array(
				'description'                 => esc_html__( 'Tyche Companion Banners', 'tyche' ),
				'customize_selective_refresh' => true
			) // Args
		);
	}

	/**
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$params = array();

		if ( empty( $instance ) ) {
			$instance = array(
				'title'        => esc_attr__( 'Tyche Companion Banners', 'tyche' ),
				'show_title'   => 'no',
				'image'        => '',
				'image_url'    => '',
				'banner_type'  => 'image',
				'adsense_code' => '',
			);

		}

		foreach ( $instance as $key => $value ) {
			$params[ $key ] = $value;
		}

		$title = $before_title . $params['title'] . $after_title;

		$filepath = dirname( __FILE__ ) . '/view/' . $params['banner_type'][0] . '.php';

		$instance = $params;

		$before_widget = str_replace( 'class="', 'class="tyche-' . $params['banner_type'][0] . ' ', $before_widget );
		echo $before_widget;

		if ( $params['show_title'][0] == 'yes' ) {
			echo $title;
		}

		if ( file_exists( $filepath ) ) {
			include $filepath;
		}

		echo $after_widget;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 *
	 * @return string;
	 */
	public function form( $instance ) {
		$defaults = array(
			'title'        => esc_attr__( 'Tyche Companion Banners', 'tyche' ),
			'show_title'   => 'no',
			'image'        => plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . 'assets/images/banner.jpg',
			'image_url'    => '',
			'banner_type'  => 'image',
			'adsense_code' => '',
		);

		// Merge the user-selected arguments with the defaults.
		$instance = wp_parse_args( (array) $instance, $defaults );
		// Extract the array to allow easy use of variables.
		extract( $instance );
		// Loads the widget form.
		?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
                   name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
                   value="<?php echo esc_attr( $title ); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'show_title' ); ?>"><?php _e( 'Show Title', 'tyche' );
				?>:</label>
            <select name="<?php echo $this->get_field_name( 'show_title' ); ?>[]"
                    id="<?php echo $this->get_field_id( 'show_title' ); ?>" class="widefat" style="height: auto;">
                <option value="yes" <?php echo ( $show_title[0] == 'yes' ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'Yes', 'tyche' ) ?>
                </option>
                <option value="no" <?php echo ( $show_title[0] == 'no' ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'No', 'tyche' ) ?>
                </option>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'banner_type' ); ?>"><?php _e( 'Banner Type', 'tyche' );
				?>:</label>
            <select name="<?php echo $this->get_field_name( 'banner_type' ); ?>[]"
                    id="<?php echo $this->get_field_id( 'banner_type' ); ?>" class="widefat" style="height: auto;">
                <option value="image" <?php echo ( $banner_type[0] == 'image' ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'Image', 'tyche' ) ?>
                </option>
                <option value="adsense" <?php echo ( $banner_type[0] == 'adsense' ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'Adsense', 'tyche' ) ?>
                </option>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Image:' ); ?></label>
            <input name="<?php echo $this->get_field_name( 'image' ); ?>"
                   id="<?php echo $this->get_field_id( 'image' ); ?>" class="widefat" type="text" size="36"
                   value="<?php echo esc_url( $image ); ?>"/>
            <input class="upload_image_button button button-primary" type="button" value="Upload Image"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'adsense_code' ); ?>"><?php _e( 'Adsense Code:' ); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id( 'adsense_code' ); ?>"
                      name="<?php echo $this->get_field_name( 'adsense_code' ); ?>" type="text"
                      value="<?php echo esc_attr( $adsense_code ); ?>">
			</textarea>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'image_url' ); ?>"><?php _e( 'Image URL:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'image_url' ); ?>"
                   name="<?php echo $this->get_field_name( 'image_url' ); ?>" type="text"
                   value="<?php echo esc_attr( $image_url ); ?>">
        </p>

		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	function update( $new_instance, $old_instance ) {
		$instance                 = $old_instance;
		$instance['title']        = strip_tags( $new_instance['title'] );
		$instance['show_title']   = $new_instance['show_title'];
		$instance['image']        = esc_url( $new_instance['image'] );
		$instance['image_url']    = esc_url( $new_instance['image_url'] );
		$instance['banner_type']  = $new_instance['banner_type'];
		$instance['adsense_code'] = esc_js( $new_instance['adsense_code'] );

		return $instance;
	}
}