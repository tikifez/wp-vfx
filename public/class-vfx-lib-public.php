<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/tikifez
 * @since      1.0.0
 *
 * @package    Vfx_Lib
 * @subpackage Vfx_Lib/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Vfx_Lib
 * @subpackage Vfx_Lib/public
 * @author     Xristopher Anderton <xris@tikidream.com>
 */
class Vfx_Lib_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->libraries = json_decode( file_get_contents( plugin_dir_path( dirname( __FILE__ )  ) . 'includes/libraries.json' ), true );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vfx-lib-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		// wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vfx-lib-public.js', array( 'jquery' ), $this->version, false );

			foreach($this->libraries as $library) {
				foreach($library["members"]as $member) {

					if(get_option($member['slug'])){
						$dependencies = [];
						if($member['dependencies']) {
							// TODO: improve dependency handling
							$dependencies = [$member['dependencies']];
						}
						wp_enqueue_script( $member['slug'], plugin_dir_url( __FILE__ ) . '..' . $library['basepath'] . '/' . $member['path'], $dependencies, $this->version, true );

					}
				}
			}
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vfx-lib-public.js', array( 'jquery' ), $this->version, false );

	}

}
