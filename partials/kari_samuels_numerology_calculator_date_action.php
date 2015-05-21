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
    $('#kari-samuels-numerology-calculator-date-submit').click(function(){
    var options = { 
      'show_calculations'          : 'false'
    },
    $table = $('#kari-samuels-numerology-calculator-date-form-table'),
    shortcode = '[kari_calculator_for_dates';
      
    for( var index in options) {
        var $element, value;
        
        $element = $table.find('#kari-samuels-numerology-calculator-date-' + index);
        value = $element.val();
        
        $table.find('#kari-samuels-numerology-calculator-date-' + index).val('');
        
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

<div id="kari-samuels-numerology-calculator-date-form">
  <table id="kari-samuels-numerology-calculator-date-form-table" class="form-table">
      <h1>Kari Samuels Numerology Calculator - Date</h1>
      <h2>Shortcode Options</h2>
      <p>Please fill in the following fields to generate the required shortcode.</p>

    <tr>
      <th>
        <label for="kari-samuels-numerology-calculator-date-show_calculations">Show Calculations:</label>
      </th>
    <td>
      <input type="checkbox" id="kari-samuels-numerology-calculator-date-show_calculations" name="kari-samuels-numerology-calculator-date-show_calculations"  value="0" /><br />
      <small>This is option determins whether the calculator will display the calculations.</small></td>
    </tr>
    </table>

  <p class="submit">
    <input type="button" id="kari-samuels-numerology-calculator-date-submit" class="button-primary" value="Insert Shortcode" name="submit" />
  </p>
</div>

<?php wp_die(); ?>