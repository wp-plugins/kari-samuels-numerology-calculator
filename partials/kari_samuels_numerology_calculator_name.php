<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public/partials
 */

$output = '
<section class="calculator-for-names">

    <header class="calculator-for-name-output">
        <h2>0</h2>
    </header>

    <fieldset class="calculator-for-name-input">
    	<input type="text" class="form-control" placeholder="' . $attributes['placeholder_text'] . '">
    </fieldset>';

  if( $attributes['show_calculations'] == 'true' ){
	$output .= '
	<footer class="calculator-for-name-proof">
		<h3>Your Numbers</h3>
		<div></div>
	</footer>';
}

$output .= '</section><!-- END #calculator-for-names -->';