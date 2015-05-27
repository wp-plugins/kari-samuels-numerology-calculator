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
?>

<script type="text/javascript">
  (function($) {
    $('#kari-samuels-numerology-calculator-names-submit').click(function(){
    var options = { 
      'show_calculations' : 'false',
      'placeholder_text'  : 'Enter your full name'     
    },
    $table = $('#kari-samuels-numerology-calculator-names-form-table'),
    shortcode = '[kari_calculator_for_names';
      
    for( var index in options) {
        var $element, value;
        
        $element = $table.find('#kari-samuels-numerology-calculator-names-' + index);
        value = $element.val();
        
        $table.find('#kari-samuels-numerology-calculator-names-' + index).val('');
        
        if(index == 'show_calculations') value = $element.is(':checked') ? 'true' : 'false';

        // attaches the attribute to the shortcode only if it's different from the default value
        if ( value !== options[index] ) {
            shortcode += ' ' + index + '="' + value + '"';
        }
    } 
   
    shortcode += ']';
   
    // inserts the shortcode into the active editor
    tinyMCE.activeEditor.execCommand('mceInsertContent', false, shortcode);
   
    // closes Thickbox
    tb_remove();
    });
  })(jQuery)
</script>

<div id="kari-samuels-numerology-calculator-names-form">
  <table id="kari-samuels-numerology-calculator-names-form-table" class="form-table">
      <h1>Kari Samuels Numerology Calculator - Names/Places</h1>
      <h2>Shortcode Options</h2>
      <p>Please fill in the following fields to generate the required shortcode.</p>
      <tr>
        <th>
          <label for="kari-samuels-numerology-calculator-names-placeholder_text">Placeholder text:</label>
        </th>
        <td>
          <input type="text" id="kari-samuels-numerology-calculator-names-placeholder_text" name="kari-samuels-numerology-calculator-names-placeholder_text" class="large-text" placeholder="placeholder text" /><br />
          <small>Please enter the text that will be displayed as a placeholder.</small>
        </td>
      </tr>
    <tr>
      <th>
        <label for="kari-samuels-numerology-calculator-names-show_calculations">Show Calculations:</label>
      </th>
    <td>
      <input type="checkbox" id="kari-samuels-numerology-calculator-names-show_calculations" name="kari-samuels-numerology-calculator-names-show_calculations"  value="0" /><br />
      <small>This option determins whether the calculator will display the proof for the calculation.</small></td>
    </tr>
    </table>

  <p class="submit">
    <input type="button" id="kari-samuels-numerology-calculator-names-submit" class="button-primary" value="Insert Shortcode" name="submit" />
  </p>
</div>

<?php wp_die(); ?>