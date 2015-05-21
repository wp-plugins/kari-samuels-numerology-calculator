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

$timestamp = time();

$currentDay = date('j', $timestamp);
$currentMonth = date('n', $timestamp);
$currentYear = date('Y', $timestamp);

$months = array("1" => "Jan", "2" => "Feb", "3" => "Mar", "4" => "Apr", "5" => "May", "6" => "Jun", "7" => "Jul", "8" => "Aug", "9" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dec");

$optionsMonth = "";

foreach ($months as $key=>$value) {
 	$optionsMonth .= "<option value='$key' " . selected( $currentMonth , $key, false ) . ">$value</option>";
}

$optionsDays = "";

foreach (range(1, 31) as $day) {
 	$optionsDays .= "<option value='$day' " . selected( $currentDay , $day, false ) . ">$day</option>";
}

$optionsYear = "";

foreach (range(1942, 2026) as $year) {
 	$optionsYear .= "<option value='$year' " . selected( $currentYear , $year, false ) . ">$year</option>";
}

$output = "
<section class='calculator-for-dates'>

  <header class='calculator-for-dates-output'>
      <h2>0</h2>
  </header>

  <fieldset class='calculator-for-dates-input'>
    <label>Enter your birth date:</label>
    <select class='selectDay'>$optionsDays</select>
    <select class='selectMonth'>$optionsMonth</select>
    <select class='selectYear'>$optionsYear</select>
    <input type='hidden' class='calculator-for-dates-datepicker' />
  </fieldset>";

  if( $attributes['show_calculations'] == 'true' ){
	$output .= '
	<footer class="calculator-for-dates-proof">
		<h3>Your Numbers</h3>
		<div></div>
	</footer>';
}

$output .= '</section><!-- END #calculator-for-dates -->';
			