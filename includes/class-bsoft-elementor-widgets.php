<?php
/**
 * Elementor Wdigets.
 *
 * @author  Balcomsoft
 * @package Bsoft
 * @version 1.0.0
 * @since   1.0.0
 */

namespace Bsoft;

/**
 *  Bsoft_Elementor_widgets.
 *
 * @return void
 */
final class Bsoft_Elementor_Widgets {

	/**
	 * Instance
	 *
	 * @var Elementor_Test_Extension The single instance of the class.
	 */
	private static $instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_css' ), 99 );
		add_action( 'plugins_loaded', array( $this, 'bsoft_elementor_init' ) );
		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'bsoft_elementor_edit_styles' ) );
		add_action( 'elementor/elements/categories_registered', array( $this, 'bsoft_elementor_widgets_category' ) );
	}

	/**
	 * Load text domain
	 */
	public function i18n() {
		load_plugin_textdomain( 'bsoft-elementor' );
	}

	/**
	 * On Plugins Loaded
	 *
	 * Checks if Elementor has loaded, and performs some compatibility checks.
	 * If All checks pass, inits the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 */
	public function bsoft_elementor_init() {
		if ( $this->is_compatible() ) {
			add_action( 'elementor/init', array( $this, 'bsoft_elementor_widgets_registered' ) );
		}
	}

	/**
	 * Compatibility Check
	 *
	 * Check if Elementor installed and activated.
	 */
	public function is_compatible() {
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'bsoft_elementor_admin_notice_missing_elementor_plugin' ) );
			return false;
		}

		return true;
	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 */
	public function bsoft_elementor_widgets_registered() {
		$this->i18n();

		add_action( 'elementor/widgets/widgets_registered', array( $this, 'bsoft_elementor_widgets' ) );
	}

	/**
	 * Enqueue
	 *
	 * Enqueue scripts and styles
	 */
	public function bsoft_elementor_edit_styles() {
		wp_enqueue_style( 'bsoft_elementor_editor', BSOFT_ELEMENTOR_FILES_PATH . 'assets/css/editor.css', array(), BSOFT_ELEMENTOR_VERSION, false );
	}

	/**
	 * Frontend
	 *
	 * Enqueue styles
	 */
	public function frontend_css() {
		if ( ! is_admin() ) {
			wp_enqueue_style( 'bsoft-widget-styles', BSOFT_ELEMENTOR_FILES_PATH . 'assets/css/bootstrap.min.css', array(), BSOFT_ELEMENTOR_VERSION );
		};
	}

	/**
	 * Array push assoc
	 *
	 * @param string $array .
	 * @param string $key .
	 * @param string $value .
	 */
	public static function array_push_assoc( $array, $key, $value ) {
		$array[ $key ] = $value;
		return $array;
	}
	/**
	 * Init Widgets Category
	 *
	 *  @param string $bsoft_category category.
	 * @return string.
	 */
	public function bsoft_elementor_widgets_category( $bsoft_category ) {
		$category = __( 'Bsoft Widgets', 'bsoft-elementor' );

		$bsoft_category->add_category(
			'bsoft-widgets',
			array(
				'title' => $category,
				'icon'  => 'eicon-font',
			)
		);

		return $bsoft_category;
	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 */
	public function bsoft_elementor_widgets() {
		$widget_templates = array(
			'class-bsoft-carousel',
			'class-bsoft-post',
		);

		foreach ( $widget_templates as $widget_template ) {
			require_once BSOFT_ELEMENTOR_PATH . '/includes/widgets/' . $widget_template . '.php';
		}

		$class_names = array(
			'bsoft_Carousel',
			'bsoft_Post',
		);

		foreach ( $class_names as $class_name ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new $class_name() );
		}
	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 */
	public function bsoft_elementor_autoload() {
		// Include Widget files.
		bsoft_elementor_autoload( BSOFT_ELEMENTOR_PATH . '/includes/widgets/' );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function bsoft_elementor_admin_notice_missing_elementor_plugin() {
		$elementor_path = 'elementor/elementor.php';
		if ( bsoft_elementor_status() ) {
			if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}
			$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $elementor_path . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $elementor_path );
			$message        = '<p>' . esc_html__( 'Elementor Website Builder is required to start using the Bsoft Elementor Widgets. Please activate the Elementor Website Builder.', 'bsoft-elementor' ) . '</p>';
			$message       .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, esc_html__( 'Activate Elementor Now', 'bsoft-elementor' ) ) . '</p>';
		} else {
			if ( ! current_user_can( 'install_plugins' ) ) {
				return;
			}
			$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
			$message     = '<p>' . esc_html__( 'Elementor Website Builder is required to start using the Bsoft Elementor Widgets. Please install and activate the Elementor Website Builder.', 'bsoft-elementor' ) . '</p>';
			$message    .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__( 'Install Elementor Now', 'bsoft-elementor' ) ) . '</p>';
		}
		echo '<div class="notice notice-error is-dismissible">' . wp_kses_post( $message ) . '</div>';
	}
}

Bsoft_Elementor_Widgets::instance();
