<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/tikifez
 * @since      1.0.0
 *
 * @package    Vfx_Lib
 * @subpackage Vfx_Lib/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Vfx_Lib
 * @subpackage Vfx_Lib/admin
 * @author     Xristopher Anderton <xris@tikidream.com>
 */
class Vfx_Lib_Admin {

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

	private $libraries;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Vfx_Lib_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vfx_Lib_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vfx-lib-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Vfx_Lib_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vfx_Lib_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vfx-lib-admin.js', array( 'jquery' ), $this->version, false );

	}

		/**
	 * Create the admin menu.
	 *
	 * @since    1.0.0
	 */
	public function settings_menu() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Lib_Sm_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Lib_Sm_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		add_options_page( __('VFX Libraries', 'textdomain' ), __('VFX Libraries', 'textdomain' ), 'manage_options',  $this->plugin_name, array($this, 'view_settings_page')  );

		// load libraries
		$this->libraries = json_decode( file_get_contents( plugin_dir_path( dirname( __FILE__ )  ) . 'includes/libraries.json' ), true );
		$option_group = 'vfx-libraries' ;
		// configure settings form fields
		foreach($this->libraries as $library) {
		// add each library
			add_settings_section( $library['slug'], __( $library['title'], 'textdomain' ), null, $this->plugin_name);

			// add each library member
			foreach($library["members"]as $member) {
				// var_dump($this->plugin_name);
				// register setting so it will save
				register_setting( $option_group, $member['slug']);
				// var_dump($option_group . " " . $member['slug']);

				add_settings_field( $member['slug'], __( $member['title'], 'textdomain' ), array('Vfx_Lib_Admin', 'lib_checkbox_display'), $this->plugin_name, $library['slug'], array($member['slug'], $member['title']) );

				// add_settings_field( $member->slug, __( $member['title'], 'textdomain' ), array('Vfx_Lib_Admin', 'lib_checkbox_display'), $this->plugin_name, $library['slug'] );
			}
		}


	/*
	 * http://codex.wordpress.org/Function_Reference/add_settings_field
	 * add_settings_field( $id, $title, $callback, $page, $section, $args );
	 * */
  	// add_settings_field( 'vfx-sm-core', __( 'ScrollMagic Core', 'textdomain' ), array('Vfx_Lib_Admin', 'lib_checkbox_display'), $this->plugin_name, 'section-1' );
  	// add_settings_field( 'vfx-sm-core', __( 'ScrollMagic Core', 'textdomain' ), array('Vfx_Lib_Admin', 'lib_checkbox_display'), $this->plugin_name, $library['slug'] );

	}

	public function view_settings_page() {
		include plugin_dir_path( __FILE__ ) .'partials/vfx-lib-admin-display.php';
	}

	public function lib_checkbox_display($args) {
		echo '<input type="checkbox" name="' . $args[0] . '" value="1" ' . checked(1, get_option($args[0]), false) . ' />';
	}

	public function lib_checkbox_display_legacy() {
			?>
			<input type="checkbox" name="vfx-sm-core" value="1" <?php checked(1, get_option('vfx-sm-core'), true); ?> />
			<?php
	}

}
