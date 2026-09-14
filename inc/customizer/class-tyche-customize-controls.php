<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return;
}

/**
 * The handful of controls core does not ship, built on WP_Customize_Control.
 *
 * Between them these replace the Kirki field types this theme used that have no core
 * equivalent: a code box, a colour-scheme picker, a Dashicon picker, a sortable on/off
 * list and a repeater.
 *
 * @package Tyche
 */

/**
 * A textarea upgraded to core's CodeMirror when it is available.
 */
class Tyche_Customize_Control_Code extends WP_Customize_Control {
	public $type = 'tyche-code';

	public function enqueue() {
		// wp_enqueue_code_editor is core; it degrades to a plain textarea if the user
		// has turned syntax highlighting off in their profile.
		wp_enqueue_code_editor( array( 'type' => 'text/html' ) );
	}

	public function render_content() {
		$id = '_customize-input-' . $this->id;
		?>
		<label for="<?php echo esc_attr( $id ); ?>">
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php if ( $this->description ) : ?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>
		</label>
		<textarea id="<?php echo esc_attr( $id ); ?>" class="tyche-code-editor widefat" rows="8" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		<?php
	}
}

/**
 * Picks one of the theme's prebuilt colour schemes, showing its swatches.
 */
class Tyche_Customize_Control_Palette extends WP_Customize_Control {
	public $type = 'tyche-palette';

	public function render_content() {
		if ( empty( $this->choices ) ) {
			return;
		}
		?>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<div class="tyche-palette" role="radiogroup" aria-label="<?php echo esc_attr( $this->label ); ?>">
			<?php foreach ( $this->choices as $value => $colors ) : ?>
				<label class="tyche-palette__option">
					<input type="radio" value="<?php echo esc_attr( $value ); ?>"
						name="<?php echo esc_attr( '_customize-radio-' . $this->id ); ?>"
						<?php $this->link(); ?>
						<?php checked( $this->value(), $value ); ?> />
					<span class="tyche-palette__swatches" aria-hidden="true">
						<?php foreach ( (array) $colors as $color ) : ?>
							<span class="tyche-palette__swatch" style="background:<?php echo esc_attr( $color ); ?>"></span>
						<?php endforeach; ?>
					</span>
					<span class="tyche-palette__name"><?php echo esc_html( ucfirst( $value ) ); ?></span>
				</label>
			<?php endforeach; ?>
		</div>
		<?php
	}
}

/**
 * A Dashicon picker. Dashicons ship with WordPress, so the list comes from core's own
 * icon font rather than a bundled icon set.
 */
class Tyche_Customize_Control_Dashicons extends WP_Customize_Control {
	public $type = 'tyche-dashicons';

	/**
	 * A working subset, chosen for a shop: enough to cover the front page info blocks.
	 *
	 * @return array
	 */
	protected function icons() {
		return array(
			'dashicons-cart', 'dashicons-products', 'dashicons-store', 'dashicons-tag',
			'dashicons-money-alt', 'dashicons-awards', 'dashicons-heart', 'dashicons-star-filled',
			'dashicons-phone', 'dashicons-email-alt', 'dashicons-location', 'dashicons-clock',
			'dashicons-shield', 'dashicons-backup', 'dashicons-airplane', 'dashicons-car',
			'dashicons-admin-users', 'dashicons-format-chat', 'dashicons-thumbs-up', 'dashicons-yes-alt',
		);
	}

	public function enqueue() {
		wp_enqueue_style( 'dashicons' );
	}

	public function render_content() {
		$current = $this->value();
		?>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<div class="tyche-dashicons" role="radiogroup" aria-label="<?php echo esc_attr( $this->label ); ?>">
			<?php foreach ( $this->icons() as $icon ) : ?>
				<label class="tyche-dashicons__option<?php echo $current === $icon ? ' is-selected' : ''; ?>" title="<?php echo esc_attr( $icon ); ?>">
					<input type="radio" value="<?php echo esc_attr( $icon ); ?>"
						name="<?php echo esc_attr( '_customize-radio-' . $this->id ); ?>"
						<?php $this->link(); ?>
						<?php checked( $current, $icon ); ?> />
					<span class="dashicons <?php echo esc_attr( $icon ); ?>" aria-hidden="true"></span>
					<span class="screen-reader-text"><?php echo esc_html( $icon ); ?></span>
				</label>
			<?php endforeach; ?>
		</div>
		<?php
	}
}

/**
 * An ordered, switchable list. Uses jQuery UI sortable, which WordPress bundles.
 */
class Tyche_Customize_Control_Sortable extends WP_Customize_Control {
	public $type = 'tyche-sortable';

	public function enqueue() {
		wp_enqueue_script( 'jquery-ui-sortable' );
	}

	public function render_content() {
		if ( empty( $this->choices ) ) {
			return;
		}

		$value = $this->value();
		$value = is_array( $value ) ? $value : array_filter( explode( ',', (string) $value ) );

		// Saved order first, then anything the theme has added since.
		$ordered = array_values( array_intersect( $value, array_keys( $this->choices ) ) );
		$rest    = array_values( array_diff( array_keys( $this->choices ), $ordered ) );
		?>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<?php if ( $this->description ) : ?>
			<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		<?php endif; ?>
		<ul class="tyche-sortable">
			<?php foreach ( array_merge( $ordered, $rest ) as $key ) : ?>
				<li class="tyche-sortable__item<?php echo in_array( $key, $ordered, true ) ? '' : ' is-off'; ?>" data-value="<?php echo esc_attr( $key ); ?>">
					<span class="tyche-sortable__handle dashicons dashicons-menu" aria-hidden="true"></span>
					<label>
						<input type="checkbox" <?php checked( in_array( $key, $ordered, true ) ); ?> />
						<?php echo esc_html( $this->choices[ $key ] ); ?>
					</label>
				</li>
			<?php endforeach; ?>
		</ul>
		<input type="hidden" class="tyche-sortable__value" value="<?php echo esc_attr( implode( ',', $ordered ) ); ?>" <?php $this->link(); ?> />
		<?php
	}
}

/**
 * Repeating rows, built from whatever subfields the field declares.
 *
 * The slider is the only user of this, and it declares seven subfields -- an image and
 * six bits of call-to-action text. The rows are stored as an array of associative
 * arrays keyed by those field names, which is the shape main-slider.php reads, and the
 * image is stored as an attachment id because that is what wp_get_attachment_image()
 * wants.
 */
class Tyche_Customize_Control_Repeater extends WP_Customize_Control {
	public $type = 'tyche-repeater';

	/**
	 * @var array Subfield definitions, keyed by field name.
	 */
	public $fields = array();

	public function enqueue() {
		wp_enqueue_media();
	}

	public function to_json() {
		parent::to_json();
		$this->json['fields'] = $this->fields;
		$value                = $this->value();
		$this->json['rows']   = is_array( $value ) ? array_values( $value ) : array();
	}

	public function render_content() {
		?>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<?php if ( $this->description ) : ?>
			<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		<?php endif; ?>

		<div class="tyche-repeater"
			data-fields="<?php echo esc_attr( wp_json_encode( $this->fields ) ); ?>"
			data-rows="<?php echo esc_attr( wp_json_encode( $this->json['rows'] ) ); ?>"
			data-choose="<?php esc_attr_e( 'Choose image', 'tyche' ); ?>"
			data-remove="<?php esc_attr_e( 'Remove row', 'tyche' ); ?>">
			<div class="tyche-repeater__rows"></div>
			<button type="button" class="button tyche-repeater__add"><?php esc_html_e( 'Add row', 'tyche' ); ?></button>
			<input type="hidden" class="tyche-repeater__value" value="<?php echo esc_attr( wp_json_encode( $this->json['rows'] ) ); ?>" <?php $this->link(); ?> />
		</div>
		<?php
	}
}
