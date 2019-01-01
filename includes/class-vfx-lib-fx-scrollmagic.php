<?php

class Vfx_Library_Item {
	public $title;
	public $description;
	public $path;
	public $slug;
	public $isRequired;

	public function __construct($path, $title, $description, $slug, $isRequired = false) {
		$this->title = $title;
		$this->description = $description;
		$this->path = $path;
		$this->slug = $slug;
		$this->isRequired = $isRequired;
	}
}

/**
 * Provides ScrollMagic functionality to the plugin
 *
 * @link       https://github.com/tikifez
 * @since      1.0.0
 *
 * @package    Vfx_Lib
 * @subpackage Vfx_Lib/includes
 */

class Vfx_Lib_Fx_ScrollMagic {

	private $libraryItems = array(),
	$libraryName = 'ScrollMagic',
	$settingsGroup = 'vfx-scrollmagic',
	$sectionName = 'vfx-sm',
   $activeStyles,
	$activeScripts,
	$lib_path,
	$plugin_name,
	$version;


	public function __construct($plugin_name, $version){
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->lib_path = plugin_dir_url( __FILE__ )  . '../node_modules/scrollmagic/scrollmagic/minified';

		// add library items
		$this->libraryItems[] = new Vfx_Library_Item('ScrollMagic.min.js', 'ScrollMagic Core', 'The ScrollMagic core, required for any ScrollMagic functionality. Note that you may need to disable other scroll handlers to avoid conflicts.', 'vfx-sm-core', true);

		$this->libraryItems[] = new Vfx_Library_Item('plugins/jquery.ScrollMagic.min.js', 'jQuery Plugin', 'Enables support for jQuery.', 'vfx-sm-jquery');
		$this->libraryItems[] = new Vfx_Library_Item('plugins/animation.gsap.min.js', 'GSAP Animation Plugin', 'Enables support for GSAP.', 'sm-gsap');
		$this->libraryItems[] = new Vfx_Library_Item('plugins/animation.velocity.min.js', 'Velocity Animation Plugin', 'Enables support for Velocity.', 'vfx-sm-velocity');
		$this->libraryItems[] = new Vfx_Library_Item('plugins/animation.gsap.min.js', 'Debug Add Indicators', 'Enables indicators for debugging.','vfx-sm-debug-add-indicators');

		add_settings_section( $this->sectionGroupName, __( $this->libraryName, 'textdomain' ), null, $this->plugin_name);
	}

   /**
	 * Register the stylesheets for the library.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vfx-lib-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the library.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vfx-lib-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function create_settings(){

		foreach($this->library_items as $item) {
			register_setting($this->settingsGroup, $item->slug);
			add_settings_field($item->slug, __($item->title, 'textdomain'), array('Vfx_Lib_Fx_ScrollMagic', 'lib_checkbox_display'), $this->plugin_name, $this->sectionName);
			// TODO: if selected, enqueue the script
		}
	}

   public function enqueue_libraries () {
      // plugins/vfx-lib/node_modules/scrollmagic/scrollmagic/minified/ScrollMagic.min.js
   }

	public function lib_checkbox_display()
{
   ?>
        <!-- Here we are comparing stored value with 1. Stored value is 1 if user checks the checkbox otherwise empty string. -->
        <input type="checkbox" name="vfx-sm-core" value="1" <?php checked(1, get_option('vfx-sm-core'), true); ?> />
   <?php
}

}
