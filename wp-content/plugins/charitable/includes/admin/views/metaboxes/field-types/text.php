<?php
/**
 * Display text field.
 *
 * @author    Eric Daams
 * @package   Charitable/Admin Views/Metaboxes
 * @copyright Copyright (c) 2017, Studio 164a
 * @since     1.2.0
 * @version   1.5.0
 */

if ( ! array_key_exists( 'form_view', $view_args ) || ! $view_args['form_view']->field_has_required_args( $view_args ) ) {
    return;
}

?>
<div id="<?php echo esc_attr( $view_args['wrapper_id'] ) ?>" class="charitable-metabox-wrap charitable-text-field-wrap">
	<?php if ( isset( $view_args['label'] ) ) : ?>
		<label for="<?php echo esc_attr( $view_args['id'] ) ?>"><?php echo $view_args['label']  ?></label>
	<?php endif ?>
	<input type="text" 
		id="<?php echo esc_attr( $view_args['id'] ) ?>" 
		name="<?php echo esc_attr( $view_args['key'] ) ?>"
		value="<?php echo esc_attr( $view_args['value'] ) ?>"
        tabindex="<?php echo esc_attr( $view_args['tabindex'] ) ?>" />
</div>
