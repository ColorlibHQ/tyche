<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * A customizer section that lists the theme's setup actions.
 *
 * This is a plain WP_Customize_Section subclass. The Customizer renders sections from
 * Underscore templates that core already loads, so render_template() below is all the
 * markup this needs -- no framework, no bundled template engine, no extra dependency.
 *
 * @package Tyche
 */
class Tyche_Customize_Section_Actions extends WP_Customize_Section {

	/**
	 * @var string Section type, matched to the JS template id.
	 */
	public $type = 'tyche-actions';

	/**
	 * @var array Actions to list.
	 */
	public $actions = array();

	/**
	 * Send the actions to the control pane along with the usual section data.
	 *
	 * @return array
	 */
	public function json() {
		$json            = parent::json();
		$json['actions'] = array_values( $this->actions );

		return $json;
	}

	/**
	 * The section's Underscore template.
	 *
	 * Mirrors core's own section markup so the section behaves like every other one --
	 * same open/close animation, same back button, same accessible title.
	 */
	protected function render_template() {
		?>
		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
			<h3 class="accordion-section-title">{{ data.title }}</h3>

			<ul class="tyche-actions">
				<# _.each( data.actions, function( action ) { #>
					<li class="tyche-action {{ action.done ? 'is-done' : 'is-todo' }}" data-action-id="{{ action.id }}">
						<div class="tyche-action__head">
							<span class="tyche-action__status" aria-hidden="true">{{ action.done ? '✓' : '•' }}</span>
							<span class="tyche-action__title">{{ action.title }}</span>
							<button type="button" class="tyche-action__dismiss" aria-label="<?php esc_attr_e( 'Dismiss this action', 'tyche' ); ?>">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<# if ( action.description ) { #>
							<p class="tyche-action__description">{{ action.description }}</p>
						<# } #>
						<# if ( action.help ) { #>
							<div class="tyche-action__help">{{{ action.help }}}</div>
						<# } #>
						<# if ( action.button_url ) { #>
							<p><a class="button button-secondary" href="{{ action.button_url }}">{{ action.button_label }}</a></p>
						<# } #>
					</li>
				<# }); #>
			</ul>

			<p class="tyche-actions__empty" hidden><?php esc_html_e( 'Nothing left to set up. Have a look around.', 'tyche' ); ?></p>
		</li>
		<?php
	}
}
