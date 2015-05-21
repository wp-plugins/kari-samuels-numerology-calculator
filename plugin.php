<?php
/**
 * @link              http://www.wordpress-fix.co.uk/
 * @since             1.0.0
 * @package           Kari_Samuels_Numerology_Calculator
 *
 * @wordpress-plugin
 * Plugin Name:       Kari Samuels Numerology Calculator
 * Plugin URI:        http://www.wordpress-fix.co.uk/
 * Description:       This plugin calculates the life path number from dates and names.
 * Version:           1.0.0
 * Author:            Gregory Lampa, BA, MEd, QTS
 * Author URI:        http://www.wordpress-fix.co.uk/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       kari-samuels-numerology-calculator
 * Domain Path:       /languages
 */

// https://wordpress.org/plugins/add/

class Kari_Samuels_Numerology_Calculator {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    	1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct() {

		$this->plugin_name = "kari_samuels_numerology_calculator";
		$this->version = "1.0.0";

		//Enqueue shortcode
		add_shortcode( 'kari_calculator_for_names', array( $this, 'calculator_for_names_shortcode' ) );
		add_shortcode( 'kari_calculator_for_dates', array( $this, 'calculator_for_dates_shortcode' ) );

		//TinyMce button to add shortcode
		add_action('init', array( $this, $this->plugin_name . '_button') );
		
		add_action('wp_ajax_' . $this->plugin_name . '_name_action', array( $this, $this->plugin_name . '_name_action') );
		add_action( 'wp_ajax_nopriv_' . $this->plugin_name . '_name_action', array( $this, $this->plugin_name . '_name_action' ) );
		
		add_action('wp_ajax_' . $this->plugin_name . '_date_action', array( $this, $this->plugin_name . '_date_action') );
		add_action( 'wp_ajax_nopriv_' . $this->plugin_name . '_date_action', array( $this, $this->plugin_name . '_date_action' ) );

		//Enqueue styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

	}

	public function kari_samuels_numerology_calculator_name_action(){
		include_once( 'partials/' . $this->plugin_name . '_name_action.php' );
 	}

	public function kari_samuels_numerology_calculator_date_action(){
		include_once( 'partials/' . $this->plugin_name . '_date_action.php' );
 	}

	public function register_button( $buttons ) {
	   array_push( $buttons, "|", $this->plugin_name . "_name" );
	   array_push( $buttons, "|", $this->plugin_name . "_date" );
	   return $buttons;
	}

	public function add_plugin( $plugin_array ) {
	   $plugin_array[ $this->plugin_name . '_name' ] = plugins_url( 'js/plugins/', __FILE__ ) . $this->plugin_name . '_name_tinymce.js';
	   $plugin_array[ $this->plugin_name . '_date' ] = plugins_url( 'js/plugins/', __FILE__ ) . $this->plugin_name . '_date_tinymce.js';
	   return $plugin_array;
	}

	/**
	 * Add Button to TinyMCE Editor
	 *
	 * @since    1.0.0
	 */
	public function kari_samuels_numerology_calculator_button() {
	   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
	      return;
	   }
	   if ( get_user_option('rich_editing') == 'true' ) {
	   		add_filter('mce_external_plugins', array( $this, 'add_plugin') );
			add_filter('mce_buttons', array( $this, 'register_button') );
	   }
	}


	public function calculator_for_names_shortcode( $atts, $content = null  ) {
		
		$attributes = shortcode_atts( 
			array( 
				'show_calculations' => 'false',
				'placeholder_text' => 'Enter your full name',
				), $atts );

		include( 'partials/kari_samuels_numerology_calculator_name.php' );

	    return $output;
	}

	public function calculator_for_dates_shortcode( $atts, $content = null  ) {

		$attributes = shortcode_atts( array( 'show_calculations' => 'false' ), $atts );

		include( 'partials/kari_samuels_numerology_calculator_date.php' );

	    return $output;
	}


	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		if(!is_admin()){
			//Enqueue jQuery UI Smoothness CSS Theme
			wp_enqueue_style( $this->plugin_name . '-jquery-ui-smoothness', '//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css', array(), '1.11.4' );

			//Enqueue Font Awesome
			wp_enqueue_style( $this->plugin_name . 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), '4.3.0' );

			//Enqueue Plugin CSS Styles
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/kari-samuels-numerology-calculator-public.css', array($this->plugin_name . '-jquery-ui-smoothness', $this->plugin_name . 'font-awesome'), '1.0.0', 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		if(!is_admin()){

			//Enqueue jQuery UI Core and Datepicker
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-ui-datepicker');

			//Enqueue Underscore.js
			wp_enqueue_script('underscore');

			//Enqueue jQuery Plugins to calculate Life Path Numbers
			wp_enqueue_script( $this->plugin_name . '-numerology-date-calculator', plugin_dir_url( __FILE__ ) . 'js/plugins/numerology-date-calculator.js', array( 'jquery', 'underscore' ), '1.0.0', true );
			wp_enqueue_script( $this->plugin_name . '-numerology-name-calculator', plugin_dir_url( __FILE__ ) . 'js/plugins/numerology-name-calculator.js', array( 'jquery', 'underscore' ), '1.0.0', true );

			//Enqueue jQuery Scrips
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/kari-samuels-numerology-calculator-public.js', array( 'jquery', $this->plugin_name . '-numerology-date-calculator', $this->plugin_name . '-numerology-name-calculator', 'jquery-ui-core', 'jquery-ui-datepicker' ), '1.0.0', true );

		}
	}
}

new Kari_Samuels_Numerology_Calculator();