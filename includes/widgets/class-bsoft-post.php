<?php
/**
 * Bsoft Elementor Post
 *
 * @author  Balcomsoft
 * @package Bsoft
 * @version 1.0.0
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

/**
 * Bsoft shortcode class
 *
 * @return void
 */
class Bsoft_Post extends Widget_Base {
	/**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
		wp_register_style( 'bsoft-post', BSOFT_ELEMENTOR_FILES_PATH . 'assets/css/widgets/bsoft-post.css', array(), BSOFT_ELEMENTOR_VERSION, false );
		wp_register_script( 'bsoft-post', BSOFT_ELEMENTOR_FILES_PATH . 'assets/js/widgets/bsoft-post.js', array( 'elementor-frontend' ), BSOFT_ELEMENTOR_VERSION, true );
	}
	/**
	 * Get style depends
	 *
	 * @return string[]
	 */
	public function get_style_depends() {
		return array( 'bsoft-post' );
	}

	/**
	 * Get javascript depends
	 *
	 * @return string[]
	 */
	public function get_script_depends() {
		return array( 'bsoft-post' );
	}

	/**
	 * Get Name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'bsoft-post';
	}

	/**
	 *  Get Title
	 */
	public function get_title() {
		return esc_html__( 'Bsoft Post', 'bsoft-elementor' );
	}

	/**
	 * Get Icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return '';
	}

	/**
	 * Get Categories.
	 *
	 * @return string[]
	 */
	public function get_categories() {
		return array( 'bsoft-widgets' );
	}

	/**
	 * Bsoft Registor controls
	 *
	 * @author Balcomsoft
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'bsoft_blog_posts_general',
			array(
				'label' => esc_html__( 'Layout', 'bsoft-elementor' ),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_layout_style',
			array(
				'label'   => esc_html__( 'Layout Style', 'bsoft-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'bsoft-blog-block-post' => esc_html__( 'Block', 'bsoft-elementor' ),
					'bsoft-post-image-card' => esc_html__( 'Grid With Thumb', 'bsoft-elementor' ),
					'bsoft-post-card'       => esc_html__( 'Grid Without Thumb', 'bsoft-elementor' ),
				),
				'default' => 'bsoft-blog-block-post',
			)
		);

		$this->add_control(
			'bsoft_blog_posts_feature_img',
			array(
				'label'     => esc_html__( 'Show Featured Image', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'bsoft-elementor' ),
				'label_off' => esc_html__( 'No', 'bsoft-elementor' ),
				'default'   => 'yes',
				'condition' => array(
					'bsoft_blog_posts_layout_style!' => 'bsoft-post-card',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_layout_style_thumb',
			array(
				'label'     => esc_html__( 'Image Position', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'block' => esc_html__( 'Top', 'bsoft-elementor' ),
					'flex'  => esc_html__( 'Left', 'bsoft-elementor' ),
				),
				'default'   => 'block',
				'selectors' => array(
					'{{WRAPPER}} .bsoft-post-image-card' => 'display: {{VALUE}}',
				),
				'condition' => array(
					'bsoft_blog_posts_layout_style' => 'bsoft-post-image-card',
					'bsoft_blog_posts_feature_img'  => 'yes',
				),
			)
		);

		/**
		* Control: Featured Image Size
		*/
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'           => 'bsoft_blog_posts_feature_img_size',
				'fields_options' => array(
					'size' => array(
						'label' => esc_html__( 'Featured Image Size', 'bsoft-elementor' ),
					),
				),
				'exclude'        => array( 'custom' ),
				'default'        => 'large',
				'condition'      => array(
					'bsoft_blog_posts_feature_img'   => 'yes',
					'bsoft_blog_posts_layout_style!' => 'bsoft-post-card',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_feature_img_float',
			array(
				'label'     => esc_html__( 'Featured Image Alignment', 'bsoft-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'  => array(
						'title' => esc_html__( 'Left', 'bsoft-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'bsoft-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'condition' => array(
					'bsoft_blog_posts_feature_img'  => 'yes',
					'bsoft_blog_posts_layout_style' => 'bsoft-blog-block-post',
				),
				'default'   => 'left',
			)
		);

		$this->add_control(
			'bsoft_blog_posts_column',
			array(
				'label'     => esc_html__( 'Show Posts Per Row', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'col-lg-12 col-md-12' => esc_html__( '1', 'bsoft-elementor' ),
					'col-lg-6 col-md-6'   => esc_html__( '2', 'bsoft-elementor' ),
					'col-lg-4 col-md-6'   => esc_html__( '3', 'bsoft-elementor' ),
					'col-lg-3 col-md-6'   => esc_html__( '4', 'bsoft-elementor' ),
					'col-lg-2 col-md-6'   => esc_html__( '6', 'bsoft-elementor' ),
				),
				'condition' => array(
					'bsoft_blog_posts_layout_style' => array( 'bsoft-post-image-card', 'bsoft-post-card' ),
				),
				'default'   => 'col-lg-4 col-md-6',
			)
		);

		$this->add_control(
			'bsoft_blog_posts_title',
			array(
				'label'     => esc_html__( 'Show Title', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'bsoft-elementor' ),
				'label_off' => esc_html__( 'No', 'bsoft-elementor' ),
				'default'   => 'yes',
			)
		);
		$this->add_control(
			'bsoft_blog_posts_title_trim',
			array(
				'label'     => esc_html__( 'Crop title by word', 'bsoft-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '',
				'condition' => array(
					'bsoft_blog_posts_title' => 'yes',
				),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_content',
			array(
				'label'     => esc_html__( 'Show Content', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'bsoft-elementor' ),
				'label_off' => esc_html__( 'No', 'bsoft-elementor' ),
				'default'   => 'yes',
			)
		);
		$this->add_control(
			'bsoft_blog_posts_content_trim',
			array(
				'label'     => esc_html__( 'Crop content by word', 'bsoft-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '',
				'condition' => array(
					'bsoft_blog_posts_content' => 'yes',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_read_more',
			array(
				'label'     => esc_html__( 'Show Read More', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'bsoft-elementor' ),
				'label_off' => esc_html__( 'No', 'bsoft-elementor' ),
				'default'   => 'yes',
				'condition' => array( 'bsoft_blog_posts_layout_style!' => 'bsoft-blog-block-post' ),
			)
		);

			$this->add_control(
				'grid_masonry',
				array(
					'label'     => esc_html__( 'Enable Masonry', 'bsoft-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'bsoft_blog_posts_layout_style!' => 'bsoft-blog-block-post',
					),
				)
			);

		$this->end_controls_section();
		$this->start_controls_section(
			'bsoft_blog_posts_content_section',
			array(
				'label' => esc_html__( 'Query', 'bsoft-elementor' ),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_num',
			array(
				'label'   => esc_html__( 'Posts Count', 'bsoft-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 100,
				'default' => 3,
			)
		);
		$options = array();
		$posts   = get_posts(
			array(
				'post_type' => 'post',
			)
		);
		foreach ( $posts as $key => $post ) {
			$options[ $post->ID ] = get_the_title( $post->ID );
		}
		$this->add_control(
			'bsoft_blog_posts_is_manual_selection',
			array(
				'label'   => esc_html__( 'Select posts by:', 'bsoft-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					'recent' => esc_html__( 'Recent Post', 'bsoft-elementor' ),
					'yes'    => esc_html__( 'Selected Post', 'bsoft-elementor' ),
				),

			)
		);

		$this->add_control(
			'bsoft_blog_posts_manual_selection',
			array(
				'label'       => esc_html__( 'Search & Select', 'bsoft-elementor' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => $options,
				'label_block' => true,
				'multiple'    => true,
				'condition'   => array( 'bsoft_blog_posts_is_manual_selection' => 'yes' ),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_offset',
			array(
				'label'   => esc_html__( 'Offset', 'bsoft-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 20,
				'default' => 0,
			)
		);

		$this->add_control(
			'bosft_blog_posts_order_by',
			array(
				'label'   => esc_html__( 'Order by', 'bsoft-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'date'          => esc_html__( 'Date', 'bsoft-elementor' ),
					'title'         => esc_html__( 'Title', 'bsoft-elementor' ),
					'author'        => esc_html__( 'Author', 'bsoft-elementor' ),
					'modified'      => esc_html__( 'Modified', 'bsoft-elementor' ),
					'comment_count' => esc_html__( 'Comments', 'bsoft-elementor' ),
				),
				'default' => 'date',
			)
		);

		$this->add_control(
			'bsoft_blog_posts_sort',
			array(
				'label'   => esc_html__( 'Order', 'bsoft-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'ASC'  => esc_html__( 'ASC', 'bsoft-elementor' ),
					'DESC' => esc_html__( 'DESC', 'bsoft-elementor' ),
				),
				'default' => 'DESC',
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'bsoft_blog_posts_meta_data_tab',
			array(
				'label' => esc_html__( 'Meta Data', 'bsoft-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'bsoft_blog_posts_floating_date',
			array(
				'label'     => esc_html__( 'Show Floating Date', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'bsoft-elementor' ),
				'label_off' => esc_html__( 'No', 'bsoft-elementor' ),
				'default'   => 'no',
				'condition' => array(
					'bsoft_blog_posts_layout_style' => 'bsoft-post-image-card',
				),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_floating_category',
			array(
				'label'     => esc_html__( 'Show Floating Category', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'bsoft-elementor' ),
				'label_off' => esc_html__( 'No', 'bsoft-elementor' ),
				'default'   => 'no',
				'condition' => array(
					'bsoft_blog_posts_layout_style' => 'bsoft-post-image-card',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_meta',
			array(
				'label'     => esc_html__( 'Show Meta Data', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'bsoft-elementor' ),
				'label_off' => esc_html__( 'No', 'bsoft-elementor' ),
				'default'   => 'yes',
			)
		);
		$this->add_control(
			'btn_meta_flex',
			array(
				'label'     => esc_html__( 'Button & Meta Flex', 'bsoft-elementor' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''     => esc_html__( 'Default', 'bsoft-elementor' ),
					'flex' => esc_html__( 'Flex', 'bsoft-elementor' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .bsoft-post-image-card .bsoft-post-body .btn_meta_flex, .bsoft-post-card .bsoft-post-body .btn_meta_flex' => 'display: {{VALUE}}; justify-content: space-between; align-items: center;',
				),
				'condition' => array(
					'bsoft_blog_posts_title_position' => 'after_button',
				),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_title_position',
			array(
				'label'     => esc_html__( 'Meta Position', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'after_meta'    => esc_html__( 'Before Title', 'bsoft-elementor' ),
					'before_meta'   => esc_html__( 'After Title', 'bsoft-elementor' ),
					'after_content' => esc_html__( 'After Content', 'bsoft-elementor' ),
					'after_button'  => esc_html__( 'After Button', 'bsoft-elementor' ),
				),
				'default'   => 'after_meta',
				'condition' => array(
					'bsoft_blog_posts_meta' => 'yes',
				),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_meta_select',
			array(
				'label'     => esc_html__( 'Meta Data', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SELECT2,
				'options'   => array(
					'author'   => esc_html__( 'Author', 'bsoft-elementor' ),
					'date'     => esc_html__( 'Date', 'bsoft-elementor' ),
					'category' => esc_html__( 'Category', 'bsoft-elementor' ),
					'comment'  => esc_html__( 'Comment', 'bsoft-elementor' ),
				),
				'multiple'  => true,
				// 'default'   => [
				// 'author',
				// 'date'
				// ],
				'condition' => array(
					'bsoft_blog_posts_meta' => 'yes',
				),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_author_image',
			array(
				'label'     => esc_html__( 'Show Author Image', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'bsoft-elementor' ),
				'label_off' => esc_html__( 'No', 'bsoft-elementor' ),
				'default'   => 'no',
				'condition' => array(
					'bsoft_blog_posts_meta'        => 'yes',
					'bsoft_blog_posts_meta_select' => 'author',
				),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_meta_author_icons',
			array(
				'label'            => esc_html__( 'Author Icon', 'bsoft-elementor' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'bsoft_blog_posts_meta_author_icon',
				'default'          => array(
					'value'   => 'icon icon-user',
					'library' => '',
				),
				'condition'        => array(
					'bsoft_blog_posts_author_image!' => 'yes',
					'bsoft_blog_posts_meta'          => 'yes',
					'bsoft_blog_posts_meta_select'   => 'author',
				),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_meta_date_icons',
			array(
				'label'            => esc_html__( 'Date Icon', 'bsoft-elementor' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'bsoft_blog_posts_meta_date_icon',
				'default'          => array(
					'value'   => '',
					'library' => '',
				),
				'condition'        => array(
					'bsoft_blog_posts_meta'        => 'yes',
					'bsoft_blog_posts_meta_select' => 'date',
				),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_meta_category_icons',
			array(
				'label'            => esc_html__( 'Category Icon', 'bsoft-elementor' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'bsoft_blog_posts_meta_category_icon',
				'default'          => array(
					'value'   => 'icon icon-folder',
					'library' => '',
				),
				'condition'        => array(
					'bsoft_blog_posts_meta'        => 'yes',
					'bsoft_blog_posts_meta_select' => 'category',
				),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_meta_comment_icons',
			array(
				'label'            => esc_html__( 'Comment Icon', 'bsoft-elementor' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'bsoft_blog_posts_meta_comment_icon',
				'default'          => array(
					'value'   => '',
					'library' => '',
				),
				'condition'        => array(
					'bsoft_blog_posts_meta'        => 'yes',
					'bsoft_blog_posts_meta_select' => 'comment',
				),
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'bsoft_blog_posts_more_section',
			array(
				'label'     => esc_html__( 'Read More Button', 'bsoft-elementor' ),
				'condition' => array(
					'bsoft_blog_posts_read_more'     => 'yes',
					'bsoft_blog_posts_layout_style!' => 'bsoft-blog-block-post',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_btn_text',
			array(
				'label'       => esc_html__( 'Label', 'bsoft-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => esc_html__( 'Learn more ', 'bsoft-elementor' ),
				'placeholder' => esc_html__( 'Learn more ', 'bsoft-elementor' ),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_btn_icons__switch',
			array(
				'label'     => esc_html__( 'Add icon? ', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => esc_html__( 'Yes', 'bsoft-elementor' ),
				'label_off' => esc_html__( 'No', 'bsoft-elementor' ),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_btn_icons',
			array(
				'label'            => esc_html__( 'Icon', 'bsoft-elementor' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'bsoft_blog_posts_btn_icon',
				'default'          => array(
					'value' => '',
				),
				'label_block'      => true,
				'condition'        => array(
					'bsoft_blog_posts_btn_icons__switch' => 'yes',
				),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_btn_icon_align',
			array(
				'label'     => esc_html__( 'Icon Position', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'left',
				'options'   => array(
					'left'  => esc_html__( 'Before', 'bsoft-elementor' ),
					'right' => esc_html__( 'After', 'bsoft-elementor' ),
				),
				'condition' => array(
					'bsoft_blog_posts_btn_icons__switch' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_blog_posts_btn_align',
			array(
				'label'     => esc_html__( 'Alignment', 'bsoft-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'bsoft-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'bsoft-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'bsoft-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .btn-wraper' => 'text-align: {{VALUE}};',
				),
				'default'   => 'left',
			)
		);

		$this->add_control(
			'bsoft_blog_posts_btn_class',
			array(
				'label'       => esc_html__( 'Class', 'bsoft-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'placeholder' => esc_html__( 'Class Name', 'bsoft-elementor' ),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_btn_id',
			array(
				'label'       => esc_html__( 'id', 'bsoft-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'placeholder' => esc_html__( 'ID', 'bsoft-elementor' ),
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'bsoft_blog_posts_style',
			array(
				'label' => esc_html__( 'Wrapper', 'bsoft-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs(
			'bsoft_blog_posts_tabs'
		);

		$this->start_controls_tab(
			'bsoft_blog_posts_tab_normal',
			array(
				'label' => esc_html__( 'Normal', 'bsoft-elementor' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_background',
				'label'    => esc_html__( 'Background', 'bsoft-elementor' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .bsoft-blog-block-post, {{WRAPPER}} .bsoft-post-image-card, {{WRAPPER}} .bsoft-post-card',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_shadow',
				'selector' => '{{WRAPPER}} .bsoft-blog-block-post, {{WRAPPER}} .bsoft-post-image-card, {{WRAPPER}} .bsoft-post-card',
			)
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'bsoft_blog_posts_tab_hover',
			array(
				'label' => esc_html__( 'Hover', 'bsoft-elementor' ),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'           => 'bsoft_blog_posts_background_hover',
				'label'          => esc_html__( 'Background', 'bsoft-elementor' ),
				'types'          => array( 'classic', 'gradient' ),
				'selector'       => '{{WRAPPER}} .bsoft-blog-block-post:hover, {{WRAPPER}} .bsoft-post-image-card:hover, {{WRAPPER}} .bsoft-post-card:hover',
				'fields_options' => array(
					'background' => array(
						'prefix_class' => 'bsoft-blog-posts--bg-hover bg-hover-',
					),
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_shadow_hover',
				'selector' => '{{WRAPPER}} .bsoft-blog-block-post:hover, {{WRAPPER}} .bsoft-post-image-card:hover, {{WRAPPER}} .bsoft-post-card:hover',
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'bsoft_blog_posts_hr',
			array(
				'type' => \Elementor\Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'bsoft_blog_posts_vertical_alignment',
			array(
				'label'     => esc_html__( 'Vertical Alignment', 'bsoft-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => esc_html__( 'Top', 'bsoft-elementor' ),
						'icon'  => 'eicon-v-align-top',
					),
					'center'     => array(
						'title' => esc_html__( 'Middle', 'bsoft-elementor' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Bottom', 'bsoft-elementor' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'condition' => array(
					'bsoft_blog_posts_layout_style' => 'bsoft-blog-block-post',
				),
				'default'   => 'flex-start',
				'selectors' => array(
					'{{WRAPPER}} .bsoft-blog-block-post > .row'    => 'align-items: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_radius',
			array(
				'label'      => esc_html__( 'Container Border radius', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-blog-block-post, {{WRAPPER}} .bsoft-post-image-card, {{WRAPPER}} .bsoft-post-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_padding',
			array(
				'label'      => esc_html__( 'Container Padding', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-blog-block-post, {{WRAPPER}} .bsoft-post-image-card, {{WRAPPER}} .bsoft-post-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_margin',
			array(
				'label'          => esc_html__( 'Container Margin', 'bsoft-elementor' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', '%', 'em' ),
				'tablet_default' => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '30',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => 'false',
				),
				'mobile_default' => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '30',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => 'false',
				),
				'selectors'      => array(
					'{{WRAPPER}} .bsoft-blog-block-post, {{WRAPPER}} .bsoft-post-image-card, {{WRAPPER}} .bsoft-post-card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_text_content_wraper_padding',
			array(
				'label'      => esc_html__( 'Content Padding', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-blog-block-post .bsoft-post-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .bsoft-post-image-card .bsoft-post-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_container_border_title',
			array(
				'label'     => esc_html__( 'Container Border', 'bsoft-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_border',
				'label'    => esc_html__( 'Container Border', 'bsoft-elementor' ),
				'selector' => '{{WRAPPER}} .bsoft-blog-block-post, {{WRAPPER}} .bsoft-post-image-card, {{WRAPPER}} .bsoft-post-card',
			)
		);

		$this->add_control(
			'bsoft_blog_posts_content_border_title',
			array(
				'label'     => esc_html__( 'Content Border', 'bsoft-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'bsoft_blog_posts_layout_style' => 'bsoft-post-image-card',
					'bsoft_blog_posts_feature_img'  => 'yes',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_content_background',
			array(
				'label'     => esc_html_x( 'Container Background Color', 'bsoft', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .bsoft-post-body' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_content_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'bsoft-elementor' ),
				'selector' => '{{WRAPPER}} .bsoft-post-body',
			)
		);

		$this->add_control(
			'bsoft_blog_posts_content_border_style',
			array(
				'label'     => esc_html_x( 'Border Type', 'Border Control', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					''       => esc_html__( 'None', 'bsoft-elementor' ),
					'solid'  => esc_html_x( 'Solid', 'Border Control', 'bsoft-elementor' ),
					'double' => esc_html_x( 'Double', 'Border Control', 'bsoft-elementor' ),
					'dotted' => esc_html_x( 'Dotted', 'Border Control', 'bsoft-elementor' ),
					'dashed' => esc_html_x( 'Dashed', 'Border Control', 'bsoft-elementor' ),
					'groove' => esc_html_x( 'Groove', 'Border Control', 'bsoft-elementor' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .bsoft-post-body' => 'border-style: {{VALUE}};',
				),
				'condition' => array(
					'bsoft_blog_posts_layout_style' => 'bsoft-post-image-card',
					'bsoft_blog_posts_feature_img'  => 'yes',
				),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_content_border_dimensions',
			array(
				'label'     => esc_html_x( 'Width', 'Border Control', 'bsoft-elementor' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => array(
					'{{WRAPPER}} .bsoft-post-body' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => array(
					'bsoft_blog_posts_layout_style' => 'bsoft-post-image-card',
					'bsoft_blog_posts_feature_img'  => 'yes',
				),
			)
		);
		$this->start_controls_tabs(
			'bsoft_blog_posts_content_border_tabs',
			array(
				'condition' => array(
					'bsoft_blog_posts_layout_style' => 'bsoft-post-image-card',
					'bsoft_blog_posts_feature_img'  => 'yes',
				),
			)
		);
		$this->start_controls_tab(
			'bsoft_blog_posts_content_border_normal',
			array(
				'label' => esc_html__( 'Normal', 'bsoft-elementor' ),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_content_border_color_normal',
			array(
				'label'     => esc_html_x( 'Color', 'Border Control', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .bsoft-post-body' => 'border-color: {{VALUE}};',
				),
			)
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'bsoft_blog_posts_content_border_color_hover_style',
			array(
				'label' => esc_html__( 'Hover', 'bsoft-elementor' ),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_content_border_color_hover',
			array(
				'label'     => esc_html_x( 'Color', 'Border Control', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .bsoft-post-image-card:hover .bsoft-post-body ' => 'border-color: {{VALUE}};',
				),
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
		$this->start_controls_section(
			'bsoft_blog_posts_feature_img_style',
			array(
				'label'     => esc_html__( 'Featured Image', 'bsoft-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'bsoft_blog_posts_layout_style!' => 'bsoft-post-card',
					'bsoft_blog_posts_feature_img'   => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_feature_img_size',
			array(
				'label'     => esc_html__( 'Image Width', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 1,
						'max' => 500,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .bsoft-entry-thumb' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}',
				),
				'condition' => array(
					'bsoft_blog_posts_layout_style'       => 'bsoft-post-image-card',
					'bsoft_blog_posts_layout_style_thumb' => 'flex',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_feature_img_shadow',
				'selector' => '{{WRAPPER}} .bsoft-entry-thumb',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_feature_img_border',
				'label'    => esc_html__( 'Border', 'bsoft-elementor' ),
				'selector' => '{{WRAPPER}} .bsoft-entry-thumb',
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_feature_img_radius',
			array(
				'label'      => esc_html__( 'Border radius', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-entry-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_feature_img_margin',
			array(
				'label'      => esc_html__( 'Margin', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-entry-thumb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_feature_img_padding',
			array(
				'label'      => esc_html__( 'Padding', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					' {{WRAPPER}} .bsoft-wid-con .bsoft-entry-thumb' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'bsoft_blog_posts_meta_style',
			array(
				'label'     => esc_html__( 'Meta', 'bsoft-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'bsoft_blog_posts_meta' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_meta_typography',
				'selector' => '{{WRAPPER}} .post-meta-list a, {{WRAPPER}} .post-meta-list .meta-date-text',
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_meta_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'bsoft-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'bsoft-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'bsoft-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'bsoft-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'selectors' => array(
					'{{WRAPPER}} .post-meta-list' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_meta_margin',
			array(
				'label'      => esc_html__( 'Container Margin', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .post-meta-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_meta_item_margin',
			array(
				'label'      => esc_html__( 'Item Margin', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .post-meta-list > span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_meta_padding',
			array(
				'label'      => esc_html__( 'Item Padding', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .post-meta-list > span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_meta_icon_padding',
			array(
				'label'      => esc_html__( 'Icon Spacing', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .post-meta-list > span > i, {{WRAPPER}} .post-meta-list > span > svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_meta_icon_size',
			array(
				'label'     => esc_html__( 'Icon Size', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 6,
						'max' => 300,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .post-meta-list > span > i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .post-meta-list > span > svg'  => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs(
			'bsoft_blog_posts_meta_background_normal_and_hover_tab'
		);
		$this->start_controls_tab(
			'bsoft_blog_posts_meta_background_normal_tab',
			array(
				'label' => esc_html__( 'Normal', 'bsoft-elementor' ),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_meta_color_normal',
			array(
				'label'     => esc_html__( 'Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .post-meta-list > span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .post-meta-list > span > svg path' => 'strock: {{VALUE}}; fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_meta_color_icon_normal',
			array(
				'label'     => esc_html__( 'Icon Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .post-meta-list > span > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .post-meta-list > span > svg path' => 'stroke: {{VALUE}}; fill: {{VALUE}};',
				),
			)
		);

		// $this->add_group_control(
		// Group_Control_Background::get_type(),
		// array(
		// 'name'     => 'bsoft_blog_posts_meta_background_normal',
		// 'label'    => esc_html__( 'Background', 'bsoft-elementor' ),
		// 'types'    => array( 'classic', 'gradient' ),
		// 'selector' => '{{WRAPPER}} .post-meta-list > span',
		// 'exclude'  => array(
		// 'image',
		// ),
		// )
		// );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_meta_border_normal',
				'label'    => esc_html__( 'Border', 'bsoft-elementor' ),
				'selector' => '{{WRAPPER}} .post-meta-list > span',
			)
		);

		$this->add_control(
			'bsoft_blog_posts_meta_border_radius_normal',
			array(
				'label'      => esc_html__( 'Border Radius', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .post-meta-list > span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_meta_box_shadow_normal',
				'label'    => esc_html__( 'Box Shadow', 'bsoft-elementor' ),
				'selector' => '{{WRAPPER}} .post-meta-list > span',
			)
		);

		// $this->add_group_control(
		// Group_Control_Text_Shadow::get_type(),
		// array(
		// 'name'     => 'bsoft_blog_posts_meta_shadow_normal',
		// 'selector' => '{{WRAPPER}} .post-meta-list > span',
		// )
		// );

		$this->end_controls_tab();

		$this->start_controls_tab(
			'bsoft_blog_posts_meta_background_hover_tab',
			array(
				'label' => esc_html__( 'Hover', 'bsoft-elementor' ),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_meta_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .post-meta-list > span:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .post-meta-list > span:hover > svg path' => 'strock: {{VALUE}}; fill: {{VALUE}};',

					'{{WRAPPER}}.bsoft-blog-posts--bg-hover .bsoft-post-image-card:hover .post-meta-list > span' => 'color: {{VALUE}};',
					'{{WRAPPER}}.bsoft-blog-posts--bg-hover .bsoft-post-image-card:hover .post-meta-list > span > svg path' => 'strock: {{VALUE}}; fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_meta_color_icon_hover',
			array(
				'label'     => esc_html__( 'Icon Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .post-meta-list > span:hover > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .post-meta-list > span:hover > svg path' => 'stroke: {{VALUE}}; fill: {{VALUE}};',

					'{{WRAPPER}}.bsoft-blog-posts--bg-hover .bsoft-post-image-card:hover .post-meta-list > span:hover > i' => 'color: {{VALUE}};',
					'{{WRAPPER}}.bsoft-blog-posts--bg-hover .bsoft-post-image-card:hover .post-meta-list > span > svg path' => 'strock: {{VALUE}}; fill: {{VALUE}};',
				),
			)
		);

		// $this->add_group_control(
		// Group_Control_Background::get_type(),
		// array(
		// 'name'     => 'bsoft_blog_posts_meta_background_hover',
		// 'label'    => esc_html__( 'Background', 'bsoft-elementor' ),
		// 'types'    => array( 'classic', 'gradient' ),
		// 'selector' => '{{WRAPPER}} .post-meta-list > span:hover, {{WRAPPER}}.bsoft-blog-posts--bg-hover .bsoft-post-image-card:hover .post-meta-list > span',
		// 'exclude'  => array(
		// 'image',
		// ),
		// )
		// );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_meta_border_hover',
				'label'    => esc_html__( 'Border', 'bsoft-elementor' ),
				'selector' => '{{WRAPPER}} .post-meta-list > span:hover, {{WRAPPER}}.bsoft-blog-posts--bg-hover .bsoft-post-image-card:hover .post-meta-list > span',
			)
		);

		$this->add_control(
			'bsoft_blog_posts_meta_border_radius_hover',
			array(
				'label'      => esc_html__( 'Border Radius', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .post-meta-list > span:hover, {{WRAPPER}}.bsoft-blog-posts--bg-hover .bsoft-post-image-card:hover .post-meta-list > span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_meta_box_shadow_hover',
				'label'    => esc_html__( 'Box Shadow', 'bsoft-elementor' ),
				'selector' => '{{WRAPPER}} .post-meta-list > span:hover, {{WRAPPER}}.bsoft-blog-posts--bg-hover .bsoft-post-image-card:hover .post-meta-list > span',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
		$this->start_controls_section(
			'bsoft_blog_posts_floating_date_style_area',
			array(
				'label'     => esc_html__( 'Floating Date', 'bsoft-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'bsoft_blog_posts_floating_date' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_floating_date_height',
			array(
				'label'      => esc_html__( 'Height', 'bsoft-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => '',
				),
				'range'      => array(
					'px' => array(
						'min'  => -30,
						'step' => 1,
					),
				),
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-meta-lists .bsoft-single-meta'   => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'bsoft_blog_posts_floating_date_style' => 'style1',
				),

			)
		);
		$this->add_responsive_control(
			'bsoft_blog_posts_floating_date_width',
			array(
				'label'      => esc_html__( 'Width', 'bsoft-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => '',
				),
				'range'      => array(
					'px' => array(
						'min'  => -30,
						'step' => 1,
					),
				),
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-meta-lists .bsoft-single-meta'   => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'bsoft_blog_posts_floating_date_style' => 'style1',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_blog_posts_floating_date_left_pos',
			array(
				'label'      => esc_html__( 'Left', 'bsoft-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => '',
				),
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => -100,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-meta-lists' => 'left: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'bsoft_blog_posts_floating_date_style' => 'style1',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_blog_posts_floating_date_top_pos',
			array(
				'label'      => esc_html__( 'Top', 'bsoft-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => '',
				),
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => -100,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-meta-lists' => 'top: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'bsoft_blog_posts_floating_date_style' => 'style1',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_blog_posts_floating_date_bottom_pos',
			array(
				'label'      => esc_html__( 'Bottom', 'bsoft-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => '',
				),
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-meta-lists.bsoft-style-tag'  => 'bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'bsoft_blog_posts_floating_date_style' => 'style2',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_blog_posts_floating_date_style2_left_pos',
			array(
				'label'      => esc_html__( 'Left', 'bsoft-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => '-10',
					'unit' => 'px',
				),
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => -10,
						'max'  => 100,
						'step' => 1,
					),
					'%'  => array(
						'min'  => -10,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-meta-lists.bsoft-style-tag'  => 'left: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'bsoft_blog_posts_floating_date_style' => 'style2',
				),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_floating_date_heading',
			array(
				'label'     => esc_html__( 'Date Typography', 'bsoft-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_floating_date_typography_group',
				'selector' => '{{WRAPPER}} .bsoft-meta-lists .bsoft-single-meta .bsoft-meta-wraper strong',
			)
		);

		$this->add_control(
			'bsoft_blog_posts_floating_date_color',
			array(
				'label'     => esc_html__( 'Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bsoft-meta-lists .bsoft-single-meta .bsoft-meta-wraper strong' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_floating_date_month_heading',
			array(
				'label'     => esc_html__( 'Month Typography', 'bsoft-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_floating_date_month_typography_group',
				'selector' => '{{WRAPPER}} .bsoft-meta-lists .bsoft-single-meta',
			)
		);

		$this->add_control(
			'bsoft_blog_posts_floating_date_month_color',
			array(
				'label'     => esc_html__( 'Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bsoft-meta-lists .bsoft-single-meta .bsoft-meta-wraper' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_floating_date_padding',
			array(
				'label'      => esc_html__( 'Padding', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-meta-lists.bsoft-style-tag > .bsoft-single-meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'bsoft_blog_posts_floating_date_style' => 'style2',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'bsoft_blog_posts_floating_date_border_group',
				'label'     => esc_html__( 'Border', 'bsoft-elementor' ),
				'selector'  => '{{WRAPPER}} .bsoft-meta-lists .bsoft-single-meta',
				'condition' => array(
					'bsoft_blog_posts_floating_date_style' => 'style1',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_blog_posts_floating_date_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'top'    => '',
					'right'  => '',
					'bottom' => '',
					'left'   => '',
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-meta-lists .bsoft-single-meta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'bsoft_blog_posts_floating_date_style' => 'style',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'bsoft_blog_posts_floating_date_shadow_group',
				'selector'  => '{{WRAPPER}} .bsoft-meta-lists .bsoft-single-meta',
				'condition' => array(
					'bsoft_blog_posts_floating_date_style' => 'style',
				),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_floating_date_triangle_title',
			array(
				'label'     => esc_html__( 'Triangle', 'bsoft-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'bsoft_blog_posts_floating_date_style' => 'style2',
				),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_floating_date_triangle_color',
			array(
				'label'     => esc_html__( 'Triangle Background', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bsoft-meta-lists.bsoft-style-tag > .bsoft-single-meta::before' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'bsoft_blog_posts_floating_date_style' => 'style2',
				),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_floating_date_triangle_size',
			array(
				'label'      => esc_html__( 'Triangle Size', 'bsoft-elementor' ),
				'condition'  => array(
					'bsoft_blog_posts_floating_date_style' => 'style2',
				),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 5,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-meta-lists.bsoft-style-tag > .bsoft-single-meta::before' => 'border-width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'bsoft_blog_posts_floating_date_style' => 'style2',
				),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_floating_date_triangle_position_left',
			array(
				'label'      => esc_html__( 'Triangle Position Left', 'bsoft-elementor' ),
				'condition'  => array(
					'bsoft_blog_posts_floating_date_style' => 'style2',
				),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-meta-lists.bsoft-style-tag > .bsoft-single-meta::before' => 'left: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'bsoft_blog_posts_floating_date_style' => 'style2',
				),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_floating_date_triangle_position_top',
			array(
				'label'      => esc_html__( 'Triangle Position Top', 'bsoft-elementor' ),
				'condition'  => array(
					'bsoft_blog_posts_floating_date_style' => 'style2',
				),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => -10,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-meta-lists.bsoft-style-tag > .bsoft-single-meta::before' => 'top: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'bsoft_blog_posts_floating_date_style' => 'style2',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_floating_date_triangle_position_alignment',
			array(
				'label'     => esc_html__( 'Triangle Direction', 'bsoft-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'triangle_left'  => array(
						'title' => esc_html__( 'From Left', 'bsoft-elementor' ),
						'icon'  => 'fa fa-caret-right',
					),
					'triangle_right' => array(
						'title' => esc_html__( 'From Right', 'bsoft-elementor' ),
						'icon'  => 'fa fa-caret-left',
					),
				),
				'default'   => 'triangle_left',
				'toggle'    => true,
				'condition' => array(
					'bsoft_blog_posts_floating_date_style' => 'style2',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_floating_date_triangle_hr',
			array(
				'type'      => Controls_Manager::DIVIDER,
				'style'     => 'thick',
				'condition' => array(
					'bsoft_blog_posts_floating_date_style' => 'style2',
				),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'bsoft_blog_posts_floating_category_style',
			array(
				'label'     => esc_html__( 'Floating Category', 'bsoft-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'bsoft_blog_posts_floating_category' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_floating_category_top_pos',
			array(
				'label'      => esc_html__( 'Top', 'bsoft-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => '',
				),
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => -100,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-meta-categories' => 'top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_floating_category_left_pos',
			array(
				'label'      => esc_html__( 'Left', 'bsoft-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => '',
				),
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => -100,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-meta-categories' => 'left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_floating_category_typography',
				'selector' => '{{WRAPPER}} .bsoft-meta-categories .bsoft-meta-wraper span a',
			)
		);

		$this->add_control(
			'bsoft_blog_posts_floating_category_color',
			array(
				'label'     => esc_html__( 'Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bsoft-meta-categories .bsoft-meta-wraper span a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_floating_category_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bsoft-meta-categories .bsoft-meta-wraper span' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_floating_category_padding',
			array(
				'label'      => esc_html__( 'Padding', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'default'    => array(
					'unit'   => 'px',
					'top'    => '4',
					'right'  => '8',
					'bottom' => '4',
					'left'   => '8',
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-meta-categories .bsoft-meta-wraper span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_floating_category_padding_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'separator'  => 'after',
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-meta-categories .bsoft-meta-wraper span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_floating_category_margin_right',
			array(
				'label'      => esc_html__( 'Space Between Categories', 'bsoft-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => '',
				),
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => -100,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-meta-categories .bsoft-meta-wraper span:not(:last-child)'   => 'margin-right: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'bsoft_blog_posts_title_style',
			array(
				'label'     => esc_html__( 'Title', 'bsoft-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'bsoft_blog_posts_title' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_title_typography',
				'selector' => '{{WRAPPER}} .bsoft-post-body .entry-title, {{WRAPPER}} .bsoft-entry-header .entry-title, {{WRAPPER}} .bsoft-post-image-card .bsoft-post-body .entry-title  a,  {{WRAPPER}} .bsoft-post-card .bsoft-entry-header .entry-title  a,{{WRAPPER}} .bsoft-blog-block-post .bsoft-post-body .entry-title a',
			)
		);

		$this->start_controls_tabs(
			'bsoft_blog_posts_title_tabs'
		);

		$this->start_controls_tab(
			'bsoft_blog_posts_title_normal',
			array(
				'label' => esc_html__( 'Normal', 'bsoft-elementor' ),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_title_color',
			array(
				'label'     => esc_html__( 'Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bsoft-post-body .entry-title a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .bsoft-entry-header .entry-title a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'bsoft_blog_posts_title_hover',
			array(
				'label' => esc_html__( 'Hover', 'bsoft-elementor' ),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_title_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bsoft-post-body .entry-title a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .bsoft-entry-header .entry-title a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .bsoft-post-card:hover .entry-title a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .bsoft-post-image-card:hover .entry-title a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'bsoft_blog_posts_title_hover_shadow_hr',
			array(
				'type'  => Controls_Manager::DIVIDER,
				'style' => 'thick',
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_title_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'bsoft-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'bsoft-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => esc_html__( 'Center', 'bsoft-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'   => array(
						'title' => esc_html__( 'Right', 'bsoft-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
					'justify' => array(
						'title' => esc_html__( 'justify', 'bsoft-elementor' ),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'default'   => 'left',
				'devices'   => array( 'desktop', 'tablet', 'mobile' ),
				'selectors' => array(
					'{{WRAPPER}} .bsoft-post-body .entry-title' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .bsoft-entry-header .entry-title' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-post-body .entry-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .bsoft-entry-header .entry-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_title_separator_hr',
			array(
				'type'      => Controls_Manager::DIVIDER,
				'style'     => 'thick',
				'condition' => array(
					'bsoft_blog_posts_layout_style' => 'bsoft-post-card',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_title_separator',
			array(
				'label'     => esc_html__( 'Show Separator', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'bsoft-elementor' ),
				'label_off' => esc_html__( 'No', 'bsoft-elementor' ),
				'default'   => 'yes',
				'condition' => array(
					'bsoft_blog_posts_layout_style' => 'bsoft-post-card',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_title_separator_color',
			array(
				'label'     => esc_html__( 'Separator Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'bsoft_blog_posts_title_separator' => 'yes',
					'bsoft_blog_posts_layout_style'    => 'bsoft-post-card',
				),
				'selectors' => array(
					'{{WRAPPER}} .bsoft-border-hr' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_title_separator_width',
			array(
				'label'      => esc_html__( 'Width', 'bsoft-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 5,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-border-hr' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'bsoft_blog_posts_title_separator' => 'yes',
					'bsoft_blog_posts_layout_style'    => 'bsoft-post-card',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_title_separator_height',
			array(
				'label'      => esc_html__( 'Height', 'bsoft-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 3,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-border-hr' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'bsoft_blog_posts_title_separator' => 'yes',
					'bsoft_blog_posts_layout_style'    => 'bsoft-post-card',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_title_separator_margin',
			array(
				'label'      => esc_html__( 'Margin', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-border-hr' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'bsoft_blog_posts_title_separator' => 'yes',
					'bsoft_blog_posts_layout_style'    => 'bsoft-post-card',
				),
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'bsoft_blog_posts_content_style',
			array(
				'label'     => esc_html__( 'Content', 'bsoft-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'bsoft_blog_posts_content' => 'yes',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_content_color',
			array(
				'label'     => esc_html__( 'Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bsoft-post-footer > p' => 'color: {{VALUE}};',
					'{{WRAPPER}} .bsoft-post-body > p'   => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_content_color_hover',
			array(
				'label'     => esc_html__( 'Hover Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bsoft-blog-block-post:hover .bsoft-post-footer > p' => 'color: {{VALUE}};',
					'{{WRAPPER}} .bsoft-post-image-card:hover .bsoft-post-footer > p' => 'color: {{VALUE}};',
					'{{WRAPPER}} .bsoft-post-card:hover .bsoft-post-footer > p' => 'color: {{VALUE}};',
					'{{WRAPPER}} .bsoft-blog-block-post:hover .bsoft-post-body > p' => 'color: {{VALUE}};',
					'{{WRAPPER}} .bsoft-post-image-card:hover .bsoft-post-body > p' => 'color: {{VALUE}};',
					'{{WRAPPER}} .bsoft-post-card:hover .bsoft-post-body > p' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_content_typography',
				'selector' => '{{WRAPPER}} .bsoft-post-footer > p, {{WRAPPER}} .bsoft-post-body > p',
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_content_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'bsoft-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'bsoft-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => esc_html__( 'Center', 'bsoft-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'   => array(
						'title' => esc_html__( 'Right', 'bsoft-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
					'justify' => array(
						'title' => esc_html__( 'justify', 'bsoft-elementor' ),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'default'   => 'left',
				'devices'   => array( 'desktop', 'tablet', 'mobile' ),
				'selectors' => array(
					'{{WRAPPER}} .bsoft-post-footer'   => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .bsoft-post-body > p' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_content_margin',
			array(
				'label'      => esc_html__( 'Margin', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-post-footer'   => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .bsoft-blog-block-post .bsoft-post-footer > p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .bsoft-post-body > p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_content_highlight_border',
			array(
				'label'        => esc_html__( 'Show Highlight  Border', 'bsoft-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'bsoft-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'bsoft-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'separator'    => 'before',
			)
		);

		$this->add_control(
			'bsoft_blog_posts_content_highlight_border_height',
			array(
				'label'      => esc_html__( 'Hight', 'bsoft-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 5,
						'max'  => 300,
						'step' => 1,
					),

				),
				'default'    => array(
					'unit' => 'px',
					'size' => 100,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-post-body.bsoft-highlight-border:before' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'bsoft_blog_posts_content_highlight_border' => 'yes',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_content_highlight_border_width',
			array(
				'label'      => esc_html__( 'Width', 'bsoft-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 10,
						'step' => 1,
					),

				),
				'default'    => array(
					'unit' => 'px',
					'size' => 2,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-post-body.bsoft-highlight-border:before' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'bsoft_blog_posts_content_highlight_border' => 'yes',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_content_highlight_border_top_bottom_pos',
			array(
				'label'      => esc_html__( 'Top Bottom Position', 'bsoft-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min'  => -10,
						'max'  => 110,
						'step' => 1,
					),

				),
				'default'    => array(
					'unit' => '%',
					'size' => 50,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-post-body.bsoft-highlight-border:before' => 'top: {{SIZE}}{{UNIT}};',
				),

				'condition'  => array(
					'bsoft_blog_posts_content_highlight_border' => 'yes',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_content_highlight_border_left_right_pos',
			array(
				'label'      => esc_html__( 'Left Right Position', 'bsoft-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min'  => -5,
						'max'  => 120,
						'step' => 1,
					),

				),
				'default'    => array(
					'unit' => '%',
					'size' => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-post-body.bsoft-highlight-border:before' => 'left: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'bsoft_blog_posts_content_highlight_border' => 'yes',
				),
			)
		);

		$this->start_controls_tabs(
			'bsoft_blog_posts_border_highlight_color_tabs',
			array(
				'condition' => array(
					'bsoft_blog_posts_content_highlight_border' => 'yes',
				),
			)
		);

		$this->start_controls_tab(
			'bsoft_blog_posts_border_highlight_color_normal_tab',
			array(
				'label' => esc_html__( 'Normal', 'bsoft-elementor' ),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'bsoft_blog_posts_border_highlight_color_hover_tab',
			array(
				'label' => esc_html__( 'Hover', 'bsoft-elementor' ),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_content_highlight_border_transition',
			array(
				'label'      => esc_html__( 'Transition', 'bsoft-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 's' ),
				'range'      => array(
					's' => array(
						'min'  => .1,
						'max'  => 5,
						'step' => .1,
					),

				),
				'default'    => array(
					'unit' => 's',
					'size' => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-post-body.bsoft-highlight-border:before' => '-webkit-transition: all {{SIZE}}{{UNIT}}; -o-transition: all {{SIZE}}{{UNIT}}; transition: all {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'bsoft_blog_posts_content_highlight_border' => 'yes',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'bsoft_blog_posts_author_img_style',
			array(
				'label'     => esc_html__( 'Author Image', 'bsoft-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'bsoft_blog_posts_author_image' => 'yes',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_author_img_size_width',
			array(
				'label'      => esc_html__( 'Image Width', 'bsoft-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 30,
						'max'  => 200,
						'step' => 1,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 30,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-post-body  .meta-author .author-img' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_author_img_size_height',
			array(
				'label'      => esc_html__( 'Image Height', 'bsoft-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 30,
						'max'  => 200,
						'step' => 1,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 30,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-post-body  .meta-author .author-img' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_author_img_shadow',
				'selector' => '{{WRAPPER}} .bsoft-post-body .author-img',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_author_img_border',
				'label'    => esc_html__( 'Border', 'bsoft-elementor' ),
				'selector' => '{{WRAPPER}} .bsoft-post-body .author-img',
			)
		);

		$this->add_control(
			'bsoft_blog_posts_author_img_margin',
			array(
				'label'      => esc_html__( 'Margin', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'default'    => array(
					'top'      => '0',
					'right'    => '15',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-post-body .author-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_author_img_radius',
			array(
				'label'      => esc_html__( 'Radius', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'separator'  => 'after',
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-post-body .author-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'bsoft_blog_posts_btn_section_style',
			array(
				'label'     => esc_html__( 'Button', 'bsoft-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'bsoft_blog_posts_read_more'     => 'yes',
					'bsoft_blog_posts_layout_style!' => 'bsoft-blog-block-post',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_btn_text_padding',
			array(
				'label'      => esc_html__( 'Padding', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_btn_normal_icon_font_size',
			array(
				'label'      => esc_html__( 'Font Size Icon', 'bsoft-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'em',
					'rem',
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-btn i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bsoft-btn svg' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_btn_normal_icon_spacing',
			array(
				'label'      => esc_html__( 'Icon Spacing', 'bsoft-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 50,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-btn i' => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_btn_typography',
				'label'    => esc_html__( 'Typography', 'bsoft-elementor' ),
				'selector' => '{{WRAPPER}} .bsoft-btn',
			)
		);

		$this->start_controls_tabs( 'bsoft_blog_posts_btn_tabs_style' );

		$this->start_controls_tab(
			'bsoft_blog_posts_btn_tabnormal',
			array(
				'label' => esc_html__( 'Normal', 'bsoft-elementor' ),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_btn_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .bsoft-btn'          => 'color: {{VALUE}};',
					'{{WRAPPER}} .bsoft-btn svg path' => 'stroke: {{VALUE}}; fill: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_btn_bg_color',
				'default'  => '',
				'selector' => '{{WRAPPER}} .bsoft-btn',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'bsoft_blog_posts_btn_tab_button_hover',
			array(
				'label' => esc_html__( 'Hover', 'bsoft-elementor' ),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_btn_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .bsoft-post-image-card:hover .bsoft-btn' => 'color: {{VALUE}};',
					'{{WRAPPER}} .bsoft-post-image-card:hover .bsoft-btn svg path' => 'stroke: {{VALUE}}; fill: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_btn_bg_hover_color',
				'default'  => '',
				'selector' => '{{WRAPPER}} .bsoft-btn:hover',
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'bsoft_blog_posts_btn_border_style',
			array(
				'label'     => esc_html_x( 'Border Type', 'Border Control', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					''       => esc_html__( 'None', 'bsoft-elementor' ),
					'solid'  => esc_html_x( 'Solid', 'Border Control', 'bsoft-elementor' ),
					'double' => esc_html_x( 'Double', 'Border Control', 'bsoft-elementor' ),
					'dotted' => esc_html_x( 'Dotted', 'Border Control', 'bsoft-elementor' ),
					'dashed' => esc_html_x( 'Dashed', 'Border Control', 'bsoft-elementor' ),
					'groove' => esc_html_x( 'Groove', 'Border Control', 'bsoft-elementor' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .bsoft-btn' => 'border-style: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_btn_border_dimensions',
			array(
				'label'     => esc_html_x( 'Width', 'Border Control', 'bsoft-elementor' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => array(
					'{{WRAPPER}} .bsoft-btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => array(
					'bsoft_blog_posts_btn_border_style!' => '',
				),
			)
		);
		$this->start_controls_tabs( 'xs_tabs_button_border_style' );
		$this->start_controls_tab(
			'bsoft_blog_posts_btn_tab_border_normal',
			array(
				'label'     => esc_html__( 'Normal', 'bsoft-elementor' ),
				'condition' => array(
					'bsoft_blog_posts_btn_border_style!' => '',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_btn_border_color',
			array(
				'label'     => esc_html_x( 'Color', 'Border Control', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .bsoft-btn' => 'border-color: {{VALUE}};',
				),
				'condition' => array(
					'bsoft_blog_posts_btn_border_style!' => '',
				),
			)
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'bsoft_blog_posts_btn_tab_button_border_hover',
			array(
				'label'     => esc_html__( 'Hover', 'bsoft-elementor' ),
				'condition' => array(
					'bsoft_blog_posts_btn_border_style!' => '',
				),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_btn_hover_border_color',
			array(
				'label'     => esc_html_x( 'Color', 'Border Control', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .bsoft-btn:hover' => 'border-color: {{VALUE}};',
				),
				'condition' => array(
					'bsoft_blog_posts_btn_border_style!' => '',
				),
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_responsive_control(
			'bsoft_blog_posts_btn_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'top'    => '',
					'right'  => '',
					'bottom' => '',
					'left'   => '',
				),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'bsoft_blog_posts_btn_box_shadow_group',
				'selector' => '{{WRAPPER}} .bsoft-btn',
			)
		);

		$this->add_responsive_control(
			'bsoft_blog_posts_btn_meta_text_padding',
			array(
				'label'      => esc_html__( 'Padding Flex', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .bsoft-post-image-card .bsoft-post-body .btn_meta_flex' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_btn_meta_border_style',
			array(
				'label'     => esc_html_x( 'Border Type Flex', 'Border Control', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					''       => esc_html__( 'None', 'bsoft-elementor' ),
					'solid'  => esc_html_x( 'Solid', 'Border Control', 'bsoft-elementor' ),
					'double' => esc_html_x( 'Double', 'Border Control', 'bsoft-elementor' ),
					'dotted' => esc_html_x( 'Dotted', 'Border Control', 'bsoft-elementor' ),
					'dashed' => esc_html_x( 'Dashed', 'Border Control', 'bsoft-elementor' ),
					'groove' => esc_html_x( 'Groove', 'Border Control', 'bsoft-elementor' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .bsoft-post-image-card .bsoft-post-body .btn_meta_flex' => 'border-style: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_btn_meta_border_dimensions',
			array(
				'label'     => esc_html_x( 'Width', 'Border Control', 'bsoft-elementor' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => array(
					'{{WRAPPER}} .bsoft-post-image-card .bsoft-post-body .btn_meta_flex' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => array(
					'bsoft_blog_posts_btn_meta_border_style!' => '',
				),
			)
		);
		$this->start_controls_tabs( 'xs_tabs_button_meta_border_style' );
		$this->start_controls_tab(
			'bsoft_blog_posts_btn_meta_tab_border_normal',
			array(
				'label'     => esc_html__( 'Normal', 'bsoft-elementor' ),
				'condition' => array(
					'bsoft_blog_posts_btn_meta_border_style!' => '',
				),
			)
		);

		$this->add_control(
			'bsoft_blog_posts_btn_meta_border_color',
			array(
				'label'     => esc_html_x( 'Color', 'Border Control', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .bsoft-post-image-card .bsoft-post-body .btn_meta_flex' => 'border-color: {{VALUE}};',
				),
				'condition' => array(
					'bsoft_blog_posts_btn_meta_border_style!' => '',
				),
			)
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'bsoft_blog_posts_btn_meta_tab_button_border_hover',
			array(
				'label'     => esc_html__( 'Hover', 'bsoft-elementor' ),
				'condition' => array(
					'bsoft_blog_posts_btn_meta_border_style!' => '',
				),
			)
		);
		$this->add_control(
			'bsoft_blog_posts_btn_meta_hover_border_color',
			array(
				'label'     => esc_html_x( 'Color', 'Border Control', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .bsoft-post-image-card:hover .btn_meta_flex' => 'border-color: {{VALUE}};',
				),
				'condition' => array(
					'bsoft_blog_posts_btn_meta_border_style!' => '',
				),
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Bsoft render
	 *
	 * @author Balcomsoft
	 */
	protected function render() {
		echo '<div class="bsoft-wid-con" >';
		$this->render_raw();
		echo '</div>';
	}

	/**
	 * Bsoft render raw
	 *
	 * @author Balcomsoft
	 */
	protected function render_raw() {
		$settings = $this->get_settings();
		extract( $settings );  // phpcs:ignore WordPress.PHP.DontExtract.extract_extract

		$highlight_border                     = $bsoft_blog_posts_content_highlight_border == 'yes' ? 'bsoft-highlight-border' : '';
		$bsoft_blog_posts_offset              = ( $bsoft_blog_posts_offset === '' ) ? 0 : $bsoft_blog_posts_offset;
		$bsoft_blog_posts_floating_date_style = ( ! empty( $bsoft_blog_posts_floating_date_style ) );
		$bsoft_member_social_linkkk           = ( ! empty( $bsoft_member_social_linkkk ) );
		$bsoft_member                         = ( ! empty( $bsoft_member ) );

		$default = array(
			'orderby'        => array( $bosft_blog_posts_order_by => $bsoft_blog_posts_sort ),
			'posts_per_page' => $bsoft_blog_posts_num,
			'offset'         => $bsoft_blog_posts_offset,
			'post_status'    => 'publish',
		);

		if ( $bsoft_blog_posts_is_manual_selection == 'yes' ) {
			$default = \Bsoft\Bsoft_Elementor_Widgets::array_push_assoc(
				$default,
				'post__in',
				( ! empty( $bsoft_blog_posts_manual_selection && count( $bsoft_blog_posts_manual_selection ) > 0 ) ) ? $bsoft_blog_posts_manual_selection : array( -1 )
			);
		}

		$this->add_render_attribute(
			'post_items',
			array(
				'id'    => 'post-items--' . $this->get_id(),
				'class' => 'row post-items',
			)
		);

		if ( $grid_masonry === 'yes' ) :
			$this->add_render_attribute( 'post_items', 'data-masonry-config', 'true' );
		endif;

		$post_query = new \WP_Query( $default );

		?>
		<div <?php echo $this->get_render_attribute_string( 'post_items' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Already escaped by elementor ?>>
		<?php
		if ( 'bsoft-blog-block-post' == $bsoft_blog_posts_layout_style ) {
			$bsoft_blog_posts_column = 'col-md-12';
		}
		$column_size   = 'col-md-12';
		$img_order     = 'order-1';
		$content_order = 'order-2';

		if ( 'right' == $bsoft_blog_posts_feature_img_float ) {
			$img_order     = 'order-2';
			$content_order = 'order-1';
		}
		while ( $post_query->have_posts() ) :
			$post_query->the_post();
			if ( 'yes' === $bsoft_blog_posts_feature_img
			&& has_post_thumbnail()
			&& ( 'yes' === $bsoft_blog_posts_title
			|| 'yes' === $bsoft_blog_posts_content
			|| 'yes' === $bsoft_blog_posts_meta
			|| 'yes' === $bsoft_blog_posts_author ) ) {
				$column_size = 'col-md-6';
			}

			ob_start();
			?>
				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>">
						<?php
						if ( ! empty( $bsoft_blog_posts_title_trim ) || $bsoft_blog_posts_title_trim > 0 ) :
							echo esc_html( wp_trim_words( get_the_title(), $bsoft_blog_posts_title_trim ) );
						else :
							the_title();
						endif;
						?>
					</a>
				</h2>
			<?php
			$title_html = ob_get_clean();

			$meta_data_html = '';
			if ( 'yes' == $bsoft_blog_posts_meta ) :
				ob_start();
				?>
					<?php if ( $bsoft_blog_posts_meta == 'yes' && $bsoft_blog_posts_meta_select != '' ) : ?>
						<div class="post-meta-list">
							<?php foreach ( $bsoft_blog_posts_meta_select as $meta ) : ?>
								<?php if ( 'author' == $meta ) : ?>
									<span class="meta-author">
										<?php if ( 'yes' == $bsoft_blog_posts_author_image ) : ?>
											<span class="author-img">
												<?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?>
											</span>
										<?php else : ?>
											<?php
												$migrated = isset( $settings['__fa4_migrated']['bsoft_blog_posts_meta_author_icons'] );
												$is_new   = empty( $settings['bsoft_blog_posts_meta_author_icon'] );
											if ( $is_new || $migrated ) {
												Icons_Manager::render_icon( $settings['bsoft_blog_posts_meta_author_icons'], array( 'aria-hidden' => 'true' ) );
											} else {
												?>
													<i class="<?php echo esc_attr( $settings['bsoft_blog_posts_meta_author_icon'] ); ?>" aria-hidden="true"></i>
													<?php
											}
											?>

										<?php endif; ?>
										<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="author-name"><?php the_author_meta( 'display_name' ); ?></a>
									</span>
								<?php endif; ?>
								<?php if ( $meta == 'date' ) : ?>
									<span class="meta-date">

										<?php
											$migrated = isset( $settings['__fa4_migrated']['bsoft_blog_posts_meta_date_icons'] );
											$is_new   = empty( $settings['bsoft_blog_posts_meta_date_icon'] );
										if ( $is_new || $migrated ) {
											Icons_Manager::render_icon( $settings['bsoft_blog_posts_meta_date_icons'], array( 'aria-hidden' => 'true' ) );
										} else {
											?>
												<?php
										}
										?>

										<span class="meta-date-text">
											<?php echo esc_html( get_the_date( 'j M, Y' ) ); ?>
										</span>
									</span>
								<?php endif; ?>
								<?php if ( $meta == 'category' ) : ?>
									<span class="post-cat">
										<?php
											$migrated = isset( $settings['__fa4_migrated']['bsoft_blog_posts_meta_category_icons'] );
											$is_new   = empty( $settings['bsoft_blog_posts_meta_category_icon'] );
										if ( $is_new || $migrated ) {
											Icons_Manager::render_icon( $settings['bsoft_blog_posts_meta_category_icons'], array( 'aria-hidden' => 'true' ) );
										} else {
											?>
												<i class="<?php echo esc_attr( $settings['bsoft_blog_posts_meta_category_icon'] ); ?>" aria-hidden="true"></i>
												<?php
										}
										?>

										<?php echo get_the_category_list( ' | ' ); // phpcs:ignore WordPress.Security.EscapeOutput -- Already escaped by WordPress ?>
									</span>
								<?php endif; ?>
								<?php if ( $meta == 'comment' ) : ?>
									<span class="post-comment">
										<?php
											$migrated = isset( $settings['__fa4_migrated']['bsoft_blog_posts_meta_comment_icons'] );
											$is_new   = empty( $settings['bsoft_blog_posts_meta_comment_icon'] );
										if ( $is_new || $migrated ) {
											Icons_Manager::render_icon( $settings['bsoft_blog_posts_meta_comment_icons'], array( 'aria-hidden' => 'true' ) );
										} else {
											?>
												<i class="<?php echo esc_attr( $settings['bsoft_blog_posts_meta_comment_icon'] ); ?>" aria-hidden="true"></i>
												<?php
										}
										?>

										<a href="<?php comments_link(); ?>"><?php echo esc_html( get_comments_number() ); ?></a>
									</span>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
						<?php
					endif;
					$meta_data_html .= ob_get_clean();
			endif;

			?>
			<div class="<?php echo esc_attr( $bsoft_blog_posts_column ); ?>">

				<?php if ( 'bsoft-blog-block-post' == $bsoft_blog_posts_layout_style ) : ?>
					<div class="<?php echo esc_attr( $bsoft_blog_posts_layout_style ); ?>">
						<div class="row no-gutters">
							<?php if ( 'yes' == $bsoft_blog_posts_feature_img && has_post_thumbnail() ) : ?>
								<div class="<?php echo esc_attr( $column_size . ' ' . $img_order ); ?>">
									<a href="<?php the_permalink(); ?>" class="bsoft-entry-thumb">
										<img src="<?php the_post_thumbnail_url( esc_attr( $bsoft_blog_posts_feature_img_size_size ) ); ?>" alt="<?php the_title(); ?>">
									</a><!-- .bsoft-entry-thumb END -->
								</div>
							<?php endif; ?>

							<div class="<?php echo esc_attr( $column_size . ' ' . $content_order ); ?>">
								<div class="bsoft-post-body <?php echo esc_attr( $highlight_border ); ?>">
									<div class="bsoft-entry-header">
										<?php if ( 'yes' == $bsoft_blog_posts_title && 'before_meta' == $bsoft_blog_posts_title_position ) : ?>
											<?php echo wp_kses_post( $title_html ); ?>
										<?php endif; ?>

											<?php if ( 'after_content' != $bsoft_blog_posts_title_position && 'after_button' != $bsoft_blog_posts_title_position ) : ?>
												<?php echo wp_kses_post( $meta_data_html ); ?>
											<?php endif; ?>

											<?php if ( 'yes' == $bsoft_blog_posts_title && 'after_content' == $bsoft_blog_posts_title_position ) : ?>
												<?php echo wp_kses_post( $title_html ); ?>
											<?php endif; ?>

											<?php if ( 'after_button' == $bsoft_blog_posts_title_position ) : ?>
												<?php echo wp_kses_post( $title_html ); ?>
											<?php endif; ?>

											<?php if ( 'yes' == $bsoft_blog_posts_title && 'after_meta' == $bsoft_blog_posts_title_position ) : ?>
												<?php echo wp_kses_post( $title_html ); ?>
											<?php endif; ?>
									</div><!-- .bsoft-entry-header END -->

									<?php if ( 'yes' == $bsoft_blog_posts_content ) : ?>
										<div class="bsoft-post-footer">
											<?php if ( $bsoft_blog_posts_content_trim != '' || $bsoft_blog_posts_content_trim > 0 ) : ?>
												<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), $bsoft_blog_posts_content_trim ) ); ?></p>
											<?php else : ?>
												<?php the_excerpt(); ?>
											<?php endif; ?>
											<?php if ( 'after_content' == $bsoft_blog_posts_title_position ) : ?>
												<?php echo wp_kses_post( $meta_data_html ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
											<?php endif; ?>
											<?php if ( 'after_button' == $bsoft_blog_posts_title_position ) : ?>
												<?php echo wp_kses_post( $meta_data_html ); ?>
											<?php endif; ?>
										</div><!-- .bsoft-post-footer END -->
									<?php endif; ?>
								</div><!-- .bsoft-post-body END -->
							</div>
						</div>
					</div><!-- .bsoft-blog-block-post .radius .gradient-bg END -->
				<?php else : ?>
					<div class="<?php echo esc_attr( $bsoft_blog_posts_layout_style ); ?>">
						<div class="bsoft-entry-header">
							<?php if ( 'bsoft-post-image-card' == $bsoft_blog_posts_layout_style && 'yes' == $bsoft_blog_posts_feature_img && has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>" class="bsoft-entry-thumb">
									<img src="<?php the_post_thumbnail_url( esc_attr( $bsoft_blog_posts_feature_img_size_size ) ); ?>" alt="<?php the_title(); ?>">
								</a><!-- .bsoft-entry-thumb END -->
								<?php if ( 'yes' == $settings['bsoft_blog_posts_floating_date'] ) : ?>
									<?php if ( $bsoft_blog_posts_floating_date_style == 'style1' ) : ?>
									<div class="bsoft-meta-lists">
										<div class="bsoft-single-meta"><span class="bsoft-meta-wraper"><strong><?php echo get_the_date( 'd' ); ?></strong><?php echo get_the_date( 'M' ); ?></span></div>
									</div>
								<?php elseif ( $bsoft_blog_posts_floating_date_style == 'style2' ) : ?>
									<div class="bsoft-meta-lists bsoft-style-tag">
										<div class="bsoft-single-meta <?php echo esc_attr( $settings['bsoft_blog_posts_floating_date_triangle_position_alignment'] ); ?>"><span class="bsoft-meta-wraper"><strong><?php echo get_the_date( 'd' ); ?></strong><?php echo get_the_date( 'M' ); ?></span></div>
									</div>
								<?php endif; ?>
								<?php endif; ?>
							<?php endif; ?>

							<?php if ( 'yes' == $settings['bsoft_blog_posts_floating_category'] ) : ?>
								<div class="bsoft-meta-categories">
									<span class="bsoft-meta-wraper">
										<span><?php echo get_the_category_list( '</span><span>' ); // phpcs:ignore WordPress.Security.EscapeOutput -- Already escaped by WordPress ?></span>
									</span>
								</div>
							<?php endif; ?>

							<?php
							if ( 'bsoft-post-card' == $bsoft_blog_posts_layout_style ) :
								if ( 'yes' == $bsoft_blog_posts_title && 'before_meta' == $bsoft_blog_posts_title_position ) :
									?>
									<?php echo wp_kses_post( $title_html ); ?>

									<?php if ( 'yes' == $bsoft_blog_posts_title_separator ) : ?>
										<span class="bsoft-border-hr"></span>
									<?php endif; ?>
								<?php endif; ?>

								<?php if ( 'after_content' != $bsoft_blog_posts_title_position && 'after_button' != $bsoft_blog_posts_title_position ) : ?>
									<?php echo wp_kses_post( $meta_data_html ); ?>
								<?php endif; ?>

								<?php if ( 'yes' == $bsoft_blog_posts_title && 'after_content' == $bsoft_blog_posts_title_position ) : ?>
									<?php echo wp_kses_post( $title_html ); ?>

									<?php if ( 'yes' == $bsoft_blog_posts_title_separator ) : ?>
										<span class="bsoft-border-hr"></span>
									<?php endif; ?>
								<?php endif; ?>
								
								<?php if ( 'after_button' == $bsoft_blog_posts_title_position ) : ?>
												<?php echo wp_kses_post( $title_html ); ?>
									<?php endif; ?>

								<?php if ( 'yes' == $bsoft_blog_posts_title && 'after_meta' == $bsoft_blog_posts_title_position ) : ?>
									<?php echo wp_kses_post( $title_html ); ?>

									<?php if ( 'yes' == $bsoft_blog_posts_title_separator ) : ?>
										<span class="bsoft-border-hr"></span>
									<?php endif; ?>
								<?php endif; ?>
							<?php endif; ?>
						</div><!-- .bsoft-entry-header END -->

						<div class="bsoft-post-body <?php echo esc_attr( $highlight_border ); ?>">
							<?php
							if ( 'bsoft-post-image-card' == $bsoft_blog_posts_layout_style ) :
								if ( 'yes' == $bsoft_blog_posts_title && 'before_meta' == $bsoft_blog_posts_title_position ) :
									?>
									<?php echo wp_kses_post( $title_html ); ?>
								<?php endif; ?>

								<?php if ( 'after_content' != $bsoft_blog_posts_title_position && 'after_button' != $bsoft_blog_posts_title_position ) : ?>
									<?php echo wp_kses_post( $meta_data_html ); ?>
								<?php endif; ?>

								<?php if ( 'yes' == $bsoft_blog_posts_title && 'after_content' == $bsoft_blog_posts_title_position ) : ?>
									<?php echo wp_kses_post( $title_html ); ?>
								<?php endif; ?>

								<?php if ( 'after_button' == $bsoft_blog_posts_title_position ) : ?>
												<?php echo wp_kses_post( $title_html ); ?>
									<?php endif; ?>

								<?php if ( 'yes' == $bsoft_blog_posts_title && 'after_meta' == $bsoft_blog_posts_title_position ) : ?>
									<?php echo wp_kses_post( $title_html ); ?>
								<?php endif; ?>
							<?php endif; ?>
							<?php if ( 'yes' == $bsoft_blog_posts_content ) : ?>
								<?php if ( $bsoft_blog_posts_content_trim != '' || $bsoft_blog_posts_content_trim > 0 ) : ?>
									<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), $bsoft_blog_posts_content_trim ) ); ?></p>
								<?php else : ?>
									<?php the_excerpt(); ?>
								<?php endif; ?>
							<?php endif; ?>
							<?php if ( 'after_content' == $bsoft_blog_posts_title_position ) : ?>
									<?php echo wp_kses_post( $meta_data_html ); ?>
							<?php endif; ?>
							<?php
							if ( $bsoft_blog_posts_read_more == 'yes' ) :
								$btn_text   = $settings['bsoft_blog_posts_btn_text'];
								$btn_class  = ( $settings['bsoft_blog_posts_btn_class'] != '' ) ? $settings['bsoft_blog_posts_btn_class'] : '';
								$btn_id     = ( $settings['bsoft_blog_posts_btn_id'] != '' ) ? 'id=' . $settings['bsoft_blog_posts_btn_id'] : '';
								$icon_align = $settings['bsoft_blog_posts_btn_icon_align'];

								$btn_class .= ' whitespace--normal';
								?>
								<?php if ( 'after_button' == $bsoft_blog_posts_title_position ) : ?>
								<div class="btn_meta_flex">
								<?php endif; ?>
								<div class="btn-wraper">
									<?php if ( $icon_align == 'right' ) : ?>
										<a href="<?php echo esc_url( the_permalink() ); ?>" class="bsoft-btn <?php echo esc_attr( $btn_class ); ?>" <?php echo esc_attr( $btn_id ); ?>>
											<?php echo esc_html( $btn_text ); ?>
											<?php
											if ( $settings['bsoft_blog_posts_btn_icons__switch'] === 'yes' ) :

												$migrated = isset( $settings['__fa4_migrated']['bsoft_blog_posts_btn_icons'] );
												$is_new   = empty( $settings['bsoft_blog_posts_btn_icon'] );
												if ( $is_new || $migrated ) {
													Icons_Manager::render_icon( $settings['bsoft_blog_posts_btn_icons'], array( 'aria-hidden' => 'true' ) );
												} else {
													?>
													<i class="<?php echo esc_attr( $settings['bsoft_blog_posts_btn_icon'] ); ?>" aria-hidden="true"></i>
													<?php
												}

												endif;
											?>
										</a>
									<?php endif; ?>

									<?php if ( $icon_align == 'left' ) : ?>
										<a href="<?php echo esc_url( the_permalink() ); ?>" class="bsoft-btn <?php echo esc_attr( $btn_class ); ?>" <?php echo esc_attr( $btn_id ); ?>>
										<?php
										if ( $settings['bsoft_blog_posts_btn_icons__switch'] === 'yes' ) :
												$migrated = isset( $settings['__fa4_migrated']['bsoft_blog_posts_btn_icons'] );
												$is_new   = empty( $settings['bsoft_blog_posts_btn_icon'] );
											if ( $is_new || $migrated ) {
												Icons_Manager::render_icon( $settings['bsoft_blog_posts_btn_icons'], array( 'aria-hidden' => 'true' ) );
											} else {
												?>
													<i class="<?php echo esc_attr( $settings['bsoft_blog_posts_btn_icon'] ); ?>" aria-hidden="true"></i>
													<?php
											}

											endif;
										?>
											<?php echo esc_html( $btn_text ); ?>
										</a>
									<?php endif; ?>
								</div>
								<?php if ( 'after_button' == $bsoft_blog_posts_title_position ) : ?>
									<?php echo wp_kses_post( $meta_data_html ); ?>
							<?php endif; ?>
								<?php if ( 'after_button' == $bsoft_blog_posts_title_position ) : ?>
							</div>
							<?php endif; ?>
							<?php endif; ?>
						</div><!-- .bsoft-post-body END -->
					</div>
				<?php endif; ?>

			</div>
		<?php endwhile; ?>
		</div>
		<?php
		wp_reset_postdata();

		if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) :
			$this->render_editor_script();
		endif;
	}

	/**
	 * Bsoft render editor script
	 *
	 * @author Balcomsoft
	 */
	protected function render_editor_script() {
		?>
	   <script>
		   (function ($) {
			   'use strict';

			   $(function () {
				   var $postItems = $('#post-items--<?php echo esc_attr( $this->get_id() ); ?>[data-masonry-config]');

				   $postItems.imagesLoaded(function () {
					   $postItems.masonry();
				   });
			   });
		   }(jQuery));
	   </script>
		<?php
	}

}
