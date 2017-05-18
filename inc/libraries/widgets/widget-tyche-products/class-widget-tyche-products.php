<?php

class Widget_Tyche_Products extends WP_Widget {

	/**
	 * @internal
	 */
	public function __construct() {
		parent::__construct(
			'Tyche_Companion_Products', // Base ID
			__( 'Tyche Companion Products', 'tyche' ), // Name
			array(
				'description'                 => esc_html__( 'Recent Posts!', 'tyche' ),
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

		$params = array(
			'order'   => 'DESC',
			'orderby' => 'date',
		);

		if ( empty( $instance ) ) {
			$instance = array(
				'title'        => esc_attr__( 'Products', 'tyche' ),
				'color'        => 'red',
				'cats'         => array(),
				'show_title'   => 'yes',
				'layout'       => 'layout-c',
				'first_line'   => 'SAVE UP TO',
				'second_line'  => '50%',
				'third_line'   => 'ON OUR GALLA DRESSES',
				'button_link'  => 'http://colorlib.com',
				'button_label' => 'BUY NOW',
				'image'        => get_stylesheet_directory_uri() . '/images/image-placeholder-255x315.jpg',
			);
		}

		foreach ( $instance as $key => $value ) {
			$params[ $key ] = $value;
		}

		$title = $before_title . $params['title'] . $after_title;

		$filepath = dirname( __FILE__ ) . '/view/' . $params['layout'] . '.php';

		$instance = $params;

		$before_widget = str_replace( 'class="', 'class="tyche-products ', $before_widget );
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
	function form( $instance ) {

		$defaults = array(
			'title'        => esc_attr__( 'Products', 'tyche' ),
			'color'        => 'red',
			'show_title'   => 'yes',
			'cats'         => array(),
			'layout'       => 'layout-c',
			'first_line'   => 'SAVE UP TO',
			'second_line'  => '50%',
			'third_line'   => 'ON OUR GALLA DRESSES',
			'button_link'  => 'http://colorlib.com',
			'button_label' => 'BUY NOW',
			'image'        => get_stylesheet_directory_uri() . '/images/image-placeholder-255x315.jpg',
		);

		// Merge the user-selected arguments with the defaults.
		$instance = wp_parse_args( (array) $instance, $defaults );
		// Extract the array to allow easy use of variables.
		extract( $instance );
		// Loads the widget form.
		?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'tyche' ); ?>
                :</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
                   name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>"/>
        </p>
        <p>
            <label
                    for="<?php echo $this->get_field_id( 'show_title' ); ?>"><?php _e( 'Show Title', 'tyche' );
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
            <label for="<?php echo $this->get_field_id( 'cats' ); ?>"><?php _e( 'Categories', 'ensign' ); ?>:</label>
            <select name="<?php echo $this->get_field_name( 'cats' ); ?>[]"
                    id="<?php echo $this->get_field_id( 'cats' ); ?>" class="widefat" style="height: auto;" size="">
                <option value="" <?php if ( empty( $cats ) ) {
					echo 'selected="selected"';
				} ?>><?php _e( '&ndash; Show All &ndash;' ) ?></option>
				<?php

				$categories = get_terms( 'product_cat' );

				foreach ( $categories as $category ) { ?>
                    <option
                            value="<?php echo $category->name; ?>" <?php if ( is_array( $cats ) && in_array( $category->name, $cats ) ) {
						echo 'selected="selected"';
					} ?>><?php echo $category->name; ?></option>
				<?php } ?>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'color' ); ?>"><?php _e( 'Color', 'tyche' ); ?>
                :</label>
            <select name="<?php echo $this->get_field_name( 'color' ); ?>"
                    id="<?php echo $this->get_field_id( 'color' ); ?>" class="widefat" style="height: auto;">
                <option value="primary" <?php echo ( $color == 'primary' ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'Red', 'tyche' ) ?>
                </option>
                <option value="secondary" <?php echo ( $color == 'secondary' ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'Beige', 'tyche' ) ?>
                </option>
                <option value="green" <?php echo ( $color == 'green' ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'Green', 'tyche' ) ?>
                </option>
                <option value="blue" <?php echo ( $color == 'blue' ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'Blue', 'tyche' ) ?>
                </option>
                <option value="light_blue" <?php echo ( $color == 'light_blue' ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'Light Blue', 'tyche' ) ?>
                </option>
                <option value="black" <?php echo ( $color == 'black' ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'Black', 'tyche' ) ?>
                </option>
                <option value="orange" <?php echo ( $color == 'orange' ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'Orange', 'tyche' ) ?>
                </option>
            </select>
        </p>

        <p>
            <label
                    for="<?php echo $this->get_field_id( 'layout' ); ?>"><?php _e( 'Layout (banner position left/right/no banner/list)', 'tyche' ); ?>
                :</label>
        <div class="widget-layouts">
            <a href="javascript:void(0)"
               data-layout="layout-a" <?php echo ( $layout == 'layout-a' ) ? 'class="selected"' : '' ?>>
                <img
                        src="<?php echo plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . 'assets/images/layout-a.png' ?>"/>
            </a>
            <a href="javascript:void(0)"
               data-layout="layout-b" <?php echo ( $layout == 'layout-b' ) ? 'class="selected"' : '' ?>>
                <img
                        src="<?php echo plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . 'assets/images/layout-b.png' ?>"/>
            </a>
            <a href="javascript:void(0)"
               data-layout="layout-c" <?php echo ( $layout == 'layout-c' ) ? 'class="selected"' : '' ?>>
                <img
                        src="<?php echo plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . 'assets/images/layout-c.png' ?>"/>
            </a>
            <a href="javascript:void(0)"
               data-layout="layout-d" <?php echo ( $layout == 'layout-d' ) ? 'class="selected"' : '' ?>>
                <img
                        src="<?php echo plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . 'assets/images/layout-d.png' ?>"/>
            </a>
        </div>

        <select name="<?php echo $this->get_field_name( 'layout' ); ?>"
                id="<?php echo $this->get_field_id( 'layout' ); ?>" class="widefat layout-select hidden"
                style="height: auto;">
            <option value="layout-a" <?php echo ( $layout == 'layout-a' ) ? 'selected' : '' ?>>
				<?php echo esc_html__( 'Products with banner on the left side', 'tyche' ) ?>
            </option>
            <option value="layout-b" <?php echo ( $layout == 'layout-b' ) ? 'selected' : '' ?>>
				<?php echo esc_html__( 'Products with banner on the right side', 'tyche' ) ?>
            </option>
            <option value="layout-c" <?php echo ( $layout == 'layout-c' ) ? 'selected' : '' ?>>
				<?php echo esc_html__( 'Products without banner', 'tyche' ) ?>
            </option>
            <option value="layout-d" <?php echo ( $layout == 'layout-d' ) ? 'selected' : '' ?>>
				<?php echo esc_html__( 'Product list', 'tyche' ) ?>
            </option>
        </select>

        </p>

        <p>
            <label
                    for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Banner Background Image:' ); ?></label>
            <input name="<?php echo $this->get_field_name( 'image' ); ?>"
                   id="<?php echo $this->get_field_id( 'image' ); ?>" class="widefat" type="text" size="36"
                   value="<?php echo esc_url( $image ); ?>"/>
            <input class="upload_image_button button button-primary" type="button" value="Upload Image"/>
        </p>

        <p>
            <label
                    for="<?php echo $this->get_field_id( 'first_line' ); ?>"><?php _e( 'Banner First Line', 'tyche' ); ?>
                :</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'first_line' ); ?>"
                   name="<?php echo $this->get_field_name( 'first_line' ); ?>" type="text"
                   value="<?php echo $first_line; ?>"/>
        </p>
        <p>
            <label
                    for="<?php echo $this->get_field_id( 'second_line' ); ?>"><?php _e( 'Banner Second Line', 'tyche' ); ?>
                :</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'second_line' ); ?>"
                   name="<?php echo $this->get_field_name( 'second_line' ); ?>" type="text"
                   value="<?php echo $second_line; ?>"/>
        </p>
        <p>
            <label
                    for="<?php echo $this->get_field_id( 'third_line' ); ?>"><?php _e( 'Banner Third Line', 'tyche' ); ?>
                :</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'third_line' ); ?>"
                   name="<?php echo $this->get_field_name( 'third_line' ); ?>" type="text"
                   value="<?php echo $third_line; ?>"/>
        </p>
        <p>
            <label
                    for="<?php echo $this->get_field_id( 'button_link' ); ?>"><?php _e( 'Banner Button Link', 'tyche' ); ?>
                :</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'button_link' ); ?>"
                   name="<?php echo $this->get_field_name( 'button_link' ); ?>" type="text"
                   value="<?php echo $button_link; ?>"/>
        </p>
        <p>
            <label
                    for="<?php echo $this->get_field_id( 'button_label' ); ?>"><?php _e( 'Banner Button Label', 'tyche' ); ?>
                :</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'button_label' ); ?>"
                   name="<?php echo $this->get_field_name( 'button_label' ); ?>" type="text"
                   value="<?php echo $button_label; ?>"/>
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
		$instance['color']        = stripslashes( $new_instance['color'] );
		$instance['cats']         = $new_instance['cats'];
		$instance['layout']       = $new_instance['layout'];
		$instance['first_line']   = esc_html( $new_instance['first_line'] );
		$instance['second_line']  = esc_html( $new_instance['second_line'] );
		$instance['third_line']   = esc_html( $new_instance['third_line'] );
		$instance['button_link']  = esc_url_raw( $new_instance['button_link'] );
		$instance['button_label'] = esc_html( $new_instance['button_label'] );
		$instance['image']        = esc_url( $new_instance['image'] );

		return $instance;
	}
}