<?php

class Widget_Tyche_Contact extends WP_Widget {
	/**
	 * @internal
	 */
	public function __construct() {
		parent::__construct(
			'Tyche_Companion_Contact', // Base ID
			__( 'Tyche Companion Contact Widget', 'tyche' ), // Name
			array(
				'description'                 => esc_html__( 'Tyche Companion Contact Widget', 'tyche' ),
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
				'contact_title' => esc_html__( 'Contact', 'tyche' ),
				'address'       => esc_html__( '123 Street Name, City, England.', 'tyche' ),
				'phone'         => esc_html__( '(123) 456-7890', 'tyche' ),
				'email'         => esc_html__( 'mail@shopper.com', 'tyche' ),
			);

		}

		foreach ( $instance as $key => $value ) {
			$params[ $key ] = $value;
		}

		$filepath = dirname( __FILE__ ) . '/view/default.php';

		$instance = $params;

		$before_widget = str_replace( 'class="', 'class="tyche-companion-contact-widget ', $before_widget );
		echo $before_widget;

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
			'contact_title' => esc_html( 'Contact' ),
			'address'       => esc_html( '123 Street Name, City, England.' ),
			'phone'         => esc_html( '(123) 456-7890' ),
			'email'         => esc_html( 'mail@shopper.com' ),
		);

		// Merge the user-selected arguments with the defaults.
		$instance = wp_parse_args( (array) $instance, $defaults );
		// Extract the array to allow easy use of variables.
		extract( $instance );
		// Loads the widget form.
		?>

        <p>
            <label
                    for="<?php echo $this->get_field_id( 'contact_title' ); ?>"><?php _e( 'Contact section title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'contact_title' ); ?>"
                   name="<?php echo $this->get_field_name( 'contact_title' ); ?>" type="text"
                   value="<?php echo esc_attr( $contact_title ); ?>">
        </p>
        <p>
            <label
                    for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e( 'Address:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'address' ); ?>"
                   name="<?php echo $this->get_field_name( 'address' ); ?>" type="text"
                   value="<?php echo esc_attr( $address ); ?>">
        </p>
        <p>
            <label
                    for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e( 'Phone number:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>"
                   name="<?php echo $this->get_field_name( 'phone' ); ?>" type="tel"
                   value="<?php echo esc_attr( $phone ); ?>">
        </p>
        <p>
            <label
                    for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>"
                   name="<?php echo $this->get_field_name( 'email' ); ?>" type="email"
                   value="<?php echo esc_attr( $email ); ?>">
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
		$instance                  = $old_instance;
		$instance['contact_title'] = esc_html( $new_instance['contact_title'] );
		$instance['address']       = esc_html( $new_instance['address'] );
		$instance['phone']         = esc_html( $new_instance['phone'] );
		$instance['email']         = esc_html( $new_instance['email'] );

		return $instance;
	}
}