<?php

/**
 * Class Widget_Tyche_Products
 */
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
		$params = array(
			'order'   => 'DESC',
			'orderby' => 'date',
		);

		$defaults = array(
			'title'        => esc_attr__( 'Products', 'tyche' ),
			'color'        => 'red',
			'show_title'   => 'yes',
			'cats'         => '',
			'show_rating'  => 'no',
			'layout'       => 'layout-a',
			'first_line'   => 'SAVE UP TO',
			'second_line'  => '50%',
			'third_line'   => 'ON OUR GALLA DRESSES',
			'button_link'  => 'http://colorlib.com',
			'button_label' => 'BUY NOW',
			'image'        => '',
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		foreach ( $instance as $key => $value ) {
			$params[ $key ] = $value;
		}

		$title = $args['before_title'] . $params['title'] . $args['after_title'];

		$filepath = dirname( __FILE__ ) . '/view/' . $params['layout'] . '.php';

		$args['before_widget'] = str_replace( 'class="', 'class="tyche-products ', $args['before_widget'] );

		echo $args['before_widget'];

		if ( $params['show_title'] == 'yes' ) {
			echo $title;
		}

		if ( file_exists( $filepath ) ) {
			include $filepath;
		}

		echo $args['after_widget'];
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
		wp_enqueue_media();
		wp_enqueue_style( 'tyche_media_upload_css', get_template_directory_uri() . '/inc/customizer/assets/css/upload-media.css' );
		wp_enqueue_script( 'tyche_media_upload_js', get_template_directory_uri() . '/inc/customizer/assets/js/upload-media.js', array( 'jquery' ) );
		wp_localize_script( 'tyche_media_upload_js', 'WPUrls', array(
			'siteurl' => get_option( 'siteurl' ),
			'theme'   => get_template_directory_uri(),
			'ajaxurl' => admin_url( 'admin-ajax.php' )
		) );

		$defaults = array(
			'title'        => esc_attr__( 'Products', 'tyche' ),
			'color'        => 'red',
			'show_title'   => 'yes',
			'cats'         => '',
			'show_rating'  => 'no',
			'layout'       => 'layout-a',
			'first_line'   => 'SAVE UP TO',
			'second_line'  => '50%',
			'third_line'   => 'ON OUR GALLA DRESSES',
			'button_link'  => 'http://colorlib.com',
			'button_label' => 'BUY NOW',
			'image'        => '',
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'tyche' ); ?>
                :</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $instance['title'] ); ?>"/>
        </p>
        <p>
            <label
                    for="<?php echo esc_attr( $this->get_field_id( 'show_title' ) ); ?>"><?php esc_html_e( 'Show Title', 'tyche' );
				?>:</label>
            <select name="<?php echo esc_attr( $this->get_field_name( 'show_title' ) ); ?>"
                    id="<?php echo esc_attr( $this->get_field_id( 'show_title' ) ); ?>" class="widefat"
                    style="height: auto;">
                <option value="yes" <?php echo ( $instance['show_title'] == 'yes' ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'Yes', 'tyche' ) ?>
                </option>
                <option value="no" <?php echo ( $instance['show_title'] == 'no' ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'No', 'tyche' ) ?>
                </option>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'cats' ) ); ?>"><?php esc_html_e( 'Categories', 'ensign' ); ?>
                :</label>
            <select name="<?php echo esc_attr( $this->get_field_name( 'cats' ) ); ?>"
                    id="<?php echo esc_attr( $this->get_field_id( 'cats' ) ); ?>" class="widefat" style="height: auto;"
                    size="">
                <option value="" <?php echo empty( $instance['cats'] ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( '&ndash; Select a category &ndash;', 'tyche' ) ?></option>
				<?php
				$categories = get_terms( 'product_cat' );

				foreach ( $categories as $category ) { ?>
                    <option value="<?php echo esc_attr( $category->name ); ?>" <?php selected( esc_attr( $category->name ), $instance['cats'] ); ?>><?php echo esc_html( $category->name ); ?></option>
				<?php } ?>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'color' ) ); ?>"><?php esc_html_e( 'Color', 'tyche' ); ?>
                :</label>
            <select name="<?php echo esc_attr( $this->get_field_name( 'color' ) ); ?>"
                    id="<?php echo esc_attr( $this->get_field_id( 'color' ) ); ?>" class="widefat"
                    style="height: auto;">
                <option value="primary" <?php echo ( $instance['color'] == 'primary' ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'Red', 'tyche' ) ?>
                </option>
                <option value="secondary" <?php echo ( $instance['color'] == 'secondary' ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'Beige', 'tyche' ) ?>
                </option>
                <option value="green" <?php echo ( $instance['color'] == 'green' ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'Green', 'tyche' ) ?>
                </option>
                <option value="blue" <?php echo ( $instance['color'] == 'blue' ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'Blue', 'tyche' ) ?>
                </option>
                <option value="light_blue" <?php echo ( $instance['color'] == 'light_blue' ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'Light Blue', 'tyche' ) ?>
                </option>
                <option value="black" <?php echo ( $instance['color'] == 'black' ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'Black', 'tyche' ) ?>
                </option>
                <option value="orange" <?php echo ( $instance['color'] == 'orange' ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'Orange', 'tyche' ) ?>
                </option>
            </select>
        </p>
        <p>
            <label
                    for="<?php echo esc_attr( $this->get_field_id( 'show_rating' ) ); ?>"><?php esc_html_e( 'Show Product Rating', 'tyche' );
				?>:</label>
            <select name="<?php echo esc_attr( $this->get_field_name( 'show_rating' ) ); ?>"
                    id="<?php echo esc_attr( $this->get_field_id( 'show_rating' ) ); ?>" class="widefat"
                    style="height: auto;">
                <option value="yes" <?php echo ( $instance['show_rating'] == 'yes' ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'Yes', 'tyche' ) ?>
                </option>
                <option value="no" <?php echo ( $instance['show_title'] == 'no' ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'No', 'tyche' ) ?>
                </option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php esc_html_e( 'Layout (banner position left/right/no banner/list)', 'tyche' ); ?>
                :</label>
        <div class="widget-layouts">
            <a href="javascript:void(0)"
               data-layout="layout-a" <?php echo ( $instance['layout'] == 'layout-a' ) ? 'class="selected"' : '' ?>>
                <img src="<?php echo get_template_directory_uri() . '/assets/images/layout-a.png' ?>"/>
            </a>
            <a href="javascript:void(0)"
               data-layout="layout-b" <?php echo ( $instance['layout'] == 'layout-b' ) ? 'class="selected"' : '' ?>>
                <img src="<?php echo get_template_directory_uri() . '/assets/images/layout-b.png' ?>"/>
            </a>
            <a href="javascript:void(0)"
               data-layout="layout-c" <?php echo ( $instance['layout'] == 'layout-c' ) ? 'class="selected"' : '' ?>>
                <img src="<?php echo get_template_directory_uri() . '/assets/images/layout-c.png' ?>"/>
            </a>
            <a href="javascript:void(0)"
               data-layout="layout-d" <?php echo ( $instance['layout'] == 'layout-d' ) ? 'class="selected"' : '' ?>>
                <img src="<?php echo get_template_directory_uri() . '/assets/images/layout-d.png' ?>"/>
            </a>
        </div>

        <select name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>"
                id="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>" class="widefat layout-select hidden"
                style="height: auto;">
            <option value="layout-a" <?php echo ( $instance['layout'] == 'layout-a' ) ? 'selected' : '' ?>>
				<?php echo esc_html__( 'Products with banner on the left side', 'tyche' ) ?>
            </option>
            <option value="layout-b" <?php echo ( $instance['layout'] == 'layout-b' ) ? 'selected' : '' ?>>
				<?php echo esc_html__( 'Products with banner on the right side', 'tyche' ) ?>
            </option>
            <option value="layout-c" <?php echo ( $instance['layout'] == 'layout-c' ) ? 'selected' : '' ?>>
				<?php echo esc_html__( 'Products without banner', 'tyche' ) ?>
            </option>
            <option value="layout-d" <?php echo ( $instance['layout'] == 'layout-d' ) ? 'selected' : '' ?>>
				<?php echo esc_html__( 'Product list', 'tyche' ) ?>
            </option>
        </select>

        </p>

        <p class="tyche-media-control"
           data-delegate-container="<?php echo esc_attr( $this->get_field_id( 'image' ) ) ?>">
            <label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php esc_html_e( 'Banner Image', 'tyche' );
				?>:</label>

			<?php echo wp_get_attachment_image( $instance['image'], 'full', false ); ?>

            <input type="hidden"
                   name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>"
                   id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"
                   value="<?php echo absint( $instance['image'] ); ?>"
                   class="image-id">

            <button type="button" class="button upload-button"><?php esc_html_e( 'Choose Image', 'tyche' ); ?></button>
            <button type="button" class="button remove-button"><?php esc_html_e( 'Remove Image', 'tyche' ); ?></button>
        </p>


        <p>
            <label
                    for="<?php echo esc_attr( $this->get_field_id( 'first_line' ) ); ?>"><?php esc_html_e( 'Banner First Line', 'tyche' ); ?>
                :</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'first_line' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'first_line' ) ); ?>" type="text"
                   value="<?php echo $instance['first_line']; ?>"/>
        </p>
        <p>
            <label
                    for="<?php echo esc_attr( $this->get_field_id( 'second_line' ) ); ?>"><?php esc_html_e( 'Banner Second Line', 'tyche' ); ?>
                :</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'second_line' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'second_line' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $instance['second_line'] ); ?>"/>
        </p>
        <p>
            <label
                    for="<?php echo esc_attr( $this->get_field_id( 'third_line' ) ); ?>"><?php esc_html_e( 'Banner Third Line', 'tyche' ); ?>
                :</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'third_line' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'third_line' ) ); ?>" type="text"
                   value="<?php echo $instance['third_line']; ?>"/>
        </p>
        <p>
            <label
                    for="<?php echo esc_attr( $this->get_field_id( 'button_link' ) ); ?>"><?php esc_html_e( 'Banner Button Link', 'tyche' ); ?>
                :</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_link' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'button_link' ) ); ?>" type="text"
                   value="<?php echo $instance['button_link']; ?>"/>
        </p>
        <p>
            <label
                    for="<?php echo esc_attr( $this->get_field_id( 'button_label' ) ); ?>"><?php esc_html_e( 'Banner Button Label', 'tyche' ); ?>
                :</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_label' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'button_label' ) ); ?>" type="text"
                   value="<?php echo $instance['button_label']; ?>"/>
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
		$instance['show_title']   = strip_tags( $new_instance['show_title'] );
		$instance['color']        = stripslashes( $new_instance['color'] );
		$instance['cats']         = strip_tags( $new_instance['cats'] );
		$instance['layout']       = strip_tags( $new_instance['layout'] );
		$instance['first_line']   = strip_tags( $new_instance['first_line'] );
		$instance['second_line']  = strip_tags( $new_instance['second_line'] );
		$instance['third_line']   = strip_tags( $new_instance['third_line'] );
		$instance['button_link']  = esc_url_raw( $new_instance['button_link'] );
		$instance['button_label'] = strip_tags( $new_instance['button_label'] );
		$instance['image']        = absint( $new_instance['image'] );

		return $instance;
	}
}