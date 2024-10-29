<?php
/**
 * Bsoft Elementor Carousel
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
class Bsoft_Carousel extends Widget_Base {
	/**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
		wp_register_style( 'bsoft-carousel', BSOFT_ELEMENTOR_FILES_PATH . 'assets/css/widgets/bsoft-carousel.css', array(), BSOFT_ELEMENTOR_VERSION, false );
		wp_register_script( 'bsoft-carousel', BSOFT_ELEMENTOR_FILES_PATH . 'assets/js/widgets/bsoft-carousel.js', array( 'elementor-frontend' ), BSOFT_ELEMENTOR_VERSION, true );
	}

	/**
	 * Get style depends
	 *
	 * @return string[]
	 */
	public function get_style_depends() {
		return array( 'bsoft-carousel' );
	}

	/**
	 * Get javascript depends
	 *
	 * @return string[]
	 */
	public function get_script_depends() {
		return array( 'bsoft-carousel' );
	}

	/**
	 * Get Name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'bsoft-carousel';
	}

	/**
	 *  Get Title
	 */
	public function get_title() {
		return esc_html__( 'Bsoft Carousel', 'bsoft-elementor' );
	}

	/**
	 * Get Icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-posts-carousel icon-stm';
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
	 * Get General options.
	 *
	 * @author Balcomsoft
	 */
	protected function get_bsoft_content_options() {
		$this->start_controls_section(
			'bsoft_member_section',
			array(
				'label' => esc_html__( 'Content', 'bsoft-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'image_icon',
			array(
				'label'   => esc_html__( 'Image or Icon', 'bsoft-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'Icon',
				'options' => array(
					'image' => esc_html__( 'Image', 'bsoft-elementor' ),
					'icon'  => esc_html__( 'Icon', 'bsoft-elementor' ),
					'none'  => esc_html__( 'None', 'bsoft-elementor' ),
				),
			)
		);
		$repeater->add_control(
			'image',
			array(
				'label'     => esc_html__( 'Choose Image', 'bsoft-elementor' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'dynamic'   => array(
					'active' => true,
				),
				'default'   => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'image_icon' => array( 'image' ),
				),
			)
		);
		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'image',
				'default'   => 'large',
				'separator' => 'none',
				'condition' => array(
					'image_icon' => array( 'image' ),
				),
			)
		);
		$repeater->add_control(
			'bsoft_member_social_icon_1',
			array(
				'label'            => esc_html__( 'Icon', 'bsoft-elementor' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'social',
				'skin'             => 'inline',
				'default'          => array(
					'value'   => 'fas fa-star',
					'library' => 'solid',
				),
				'condition'        => array(
					'image_icon' => array( 'icon' ),
				),
			)
		);

		$repeater->add_control(
			'bsoft_member_name',
			array(
				'label'       => __( 'Title', 'bsoft-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => __( 'Name', 'bsoft-elementor' ),
				'label_block' => true,
			)
		);
		$repeater->add_control(
			'bsoft_member_description',
			array(
				'label'       => __( 'Description', 'bsoft-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'label_block' => true,
			)
		);
		$repeater->add_control(
			'show_button_label',
			array(
				'label'        => esc_html__( 'Enable Button', 'bsoft-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'bsoft-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'bsoft-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);
		$repeater->add_control(
			'button_label',
			array(
				'label'       => esc_html__( 'Button Label', 'bsoft-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Default title', 'bsoft-elementor' ),
				'condition'   => array(
					'show_button_label' => array( 'yes' ),
				),
				'label_block' => true,
			)
		);
		$repeater->add_control(
			'button_link_label',
			array(
				'label'       => esc_html__( 'Button URL', 'bsoft-elementor' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'Paste URL or type', 'bsoft-elementor' ),
				'options'     => array( 'url', 'is_external', 'nofollow' ),
				'default'     => array(
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				),
				'condition'   => array(
					'show_button_label' => array( 'yes' ),
				),
				'label_block' => true,
			)
		);
		$repeater->add_control(
			'show_button_url',
			array(
				'label'        => esc_html__( 'Enable Url', 'bsoft-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'bsoft-elementor' ),
				'label_off'    => esc_html__( 'No', 'bsoft-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);
		$repeater->add_control(
			'bsoft_member_social_link_1',
			array(
				'label'       => esc_html__( 'Link', 'bsoft-elementor' ),
				'type'        => Controls_Manager::URL,
				'default'     => array(
					'url'         => '#',
					'is_external' => 'true',
				),
				'condition'   => array(
					'show_button_url' => array( 'yes' ),
				),
				'dynamic'     => array(
					'active' => true,
				),
				'placeholder' => esc_html__( 'https://your-site.com', 'bsoft-elementor' ),
			)
		);

		$this->add_control(
			'bsoft_member_name_list',
			array(
				'label'   => esc_html__( 'Content items', 'bsoft-elementor' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => array(
					array(
						'bsoft_member_name_item' => __( 'Content items 1', 'bsoft-elementor' ),
					),
					array(
						'bsoft_member_name_item' => __( 'Content items 2', 'bsoft-elementor' ),
					),
					array(
						'bsoft_member_name_item' => __( 'Content items 3', 'bsoft-elementor' ),
					),
				),
			)
		);
		$this->end_controls_section();
	}

	/**
	 * Bsoft Options
	 *
	 * @author Balcomsoft
	 */
	protected function get_bsoft_carousel_options() {
		$slides_to_show = range( 1, 10 );
		$slides_to_show = array_combine( $slides_to_show, $slides_to_show );

		$this->start_controls_section(
			'bsoft_member_carousel_section',
			array(
				'label' => esc_html__( 'Carousel', 'bsoft-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_responsive_control(
			'slides_to_show',
			array(
				'label'              => esc_html__( 'Slides to Show', 'bsoft-elementor' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => array(
					'' => esc_html__( 'Default', 'bsoft-elementor' ),
				) + $slides_to_show,
				'default'            => '4',
				'frontend_available' => true,
				'render_type'        => 'template',
				'selectors'          => array(
					'{{WRAPPER}}' => '--e-image-carousel-slides-to-show: {{VALUE}}',
				),
			)
		);
		$this->add_responsive_control(
			'slides_to_scroll',
			array(
				'label'              => esc_html__( 'Slides to Scroll', 'bsoft-elementor' ),
				'type'               => Controls_Manager::SELECT,
				'description'        => esc_html__( 'Set how many slides are scrolled per swipe.', 'bsoft-elementor' ),
				'options'            => array(
					'' => esc_html__( 'Default', 'bsoft-elementor' ),
				) + $slides_to_show,
				'default'            => '1',
				'condition'          => array(
					'slides_to_show!' => '1',
				),
				'frontend_available' => true,
			)
		);
		$this->add_control(
			'bsoft_member_item_spacing_custom',
			array(
				'label'              => esc_html__( 'Image Spacing', 'bsoft-elementor' ),
				'type'               => Controls_Manager::SLIDER,
				'range'              => array(
					'px' => array(
						'max' => 300,
					),
				),
				'default'            => array(
					'size' => 30,
				),
				'show_label'         => false,
				'condition'          => array(
					'slides_to_show!' => '1',
				),
				'frontend_available' => true,
				'render_type'        => 'none',
				'separator'          => 'after',
			)
		);
		$this->add_control(
			'navigation',
			array(
				'label'              => esc_html__( 'Navigation', 'bsoft-elementor' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'both',
				'options'            => array(
					'both'   => esc_html__( 'Arrows and Dots', 'bsoft-elementor' ),
					'arrows' => esc_html__( 'Arrows', 'bsoft-elementor' ),
					'dots'   => esc_html__( 'Dots', 'bsoft-elementor' ),
					'none'   => esc_html__( 'None', 'bsoft-elementor' ),
				),
				'frontend_available' => true,
			)
		);
		$this->add_control(
			'horizontal_scroll',
			array(
				'label'              => esc_html__( 'Horizontal Scroll', 'bsoft-elementor' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'yes',
				'options'            => array(
					'yes' => esc_html__( 'Yes', 'bsoft-elementor' ),
					'no'  => esc_html__( 'No', 'bsoft-elementor' ),
				),
				'frontend_available' => true,
			)
		);
		$this->add_control(
			'autoplay',
			array(
				'label'              => esc_html__( 'Autoplay', 'bsoft-elementor' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'yes',
				'options'            => array(
					'yes' => esc_html__( 'Yes', 'bsoft-elementor' ),
					'no'  => esc_html__( 'No', 'bsoft-elementor' ),
				),
				'frontend_available' => true,
			)
		);
		$this->add_control(
			'pause_on_hover',
			array(
				'label'              => esc_html__( 'Pause on Hover', 'bsoft-elementor' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'yes',
				'options'            => array(
					'yes' => esc_html__( 'Yes', 'bsoft-elementor' ),
					'no'  => esc_html__( 'No', 'bsoft-elementor' ),
				),
				'condition'          => array(
					'autoplay' => 'yes',
				),
				'render_type'        => 'none',
				'frontend_available' => true,
			)
		);
		$this->add_control(
			'autoplay_speed',
			array(
				'label'              => esc_html__( 'Autoplay Speed', 'bsoft-elementor' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 5000,
				'condition'          => array(
					'autoplay' => 'yes',
				),
				'render_type'        => 'none',
				'frontend_available' => true,
			)
		);
		$this->add_control(
			'slider_loop',
			array(
				'label'              => esc_html__( 'Infinite Loop', 'bsoft-elementor' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'yes',
				'options'            => array(
					'yes' => esc_html__( 'Yes', 'bsoft-elementor' ),
					'no'  => esc_html__( 'No', 'bsoft-elementor' ),
				),
				'frontend_available' => true,
			)
		);
		$this->add_control(
			'effect',
			array(
				'label'              => esc_html__( 'Effect', 'bsoft-elementor' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'slide',
				'options'            => array(
					'slide' => esc_html__( 'Slide', 'bsoft-elementor' ),
					'fade'  => esc_html__( 'Fade', 'bsoft-elementor' ),
				),
				'condition'          => array(
					'slides_to_show' => '1',
				),
				'frontend_available' => true,
			)
		);
		$this->add_control(
			'speed',
			array(
				'label'              => esc_html__( 'Animation Speed', 'bsoft-elementor' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 500,
				'render_type'        => 'none',
				'frontend_available' => true,
			)
		);
		$this->end_controls_section();
	}

	/**
	 * Bsoft Carousel Item
	 *
	 * @author Balcomsoft
	 */
	protected function get_bsoft_carousel_item_style() {
		$this->start_controls_section(
			'bsoft_member_section_carousel_item_style',
			array(
				'label' => esc_html__( 'Item', 'bsoft-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'bsoft_member_section_carousel_item_margin',
			array(
				'label'      => esc_html__( 'Margin', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'after',
			)
		);
		$this->add_responsive_control(
			'bsoft_member_section_carousel_item_padding',
			array(
				'label'      => esc_html__( 'Padding', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'after',
			)
		);
		$this->start_controls_tabs( 'bsoft_member_section_carousel_item_tabs' );
		$this->start_controls_tab(
			'bsoft_member_section_carousel_item_tab_normal',
			array(
				'label' => esc_html__( 'Normal', 'bsoft-elementor' ),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'background_content_normal',
				'types'    => array( 'classic', 'gradient', 'video' ),
				'selector' => '{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__item',
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'bsoft_member_carousel_item_border',
				'selector'  => '{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__item',
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'bsoft_member_carousel_item_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__item, .starter-bsoft_carousel .starter-bsoft_carousel__item::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'bsoft_member_carousel_item_box_shadow',
				'exclude'  => array(
					'box_shadow_position',
				),
				'selector' => '{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__item',
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'bsoft_member_section_carousel_item_hover_tab',
			array(
				'label' => esc_html__( 'Hover', 'bsoft-elementor' ),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'background_content_normal_hover',
				'types'    => array( 'classic', 'gradient', 'video' ),
				'selector' => '{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__item:hover',
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'bsoft_member_carousel_item_hover_border',
				'selector'  => '{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__item:hover',
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'bsoft_member_carousel_item_border_hover_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__item:hover, .starter-bsoft_carousel .starter-bsoft_carousel__item:hover::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'bsoft_member_carousel_item_item_overlay_transition_hover',
			array(
				'label'     => esc_html__( 'Transition Duration', 'bsoft-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max'  => 3,
						'min'  => 0.10,
						'step' => 0.01,
					),
				),
				'default'   => array(
					'size' => 0.5,
				),
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__item' => 'transition:{{SIZE}}s;',
				),
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'bsoft_member_section_carousel_item_style_overlay',
			array(
				'label' => esc_html__( 'Background Overlay', 'bsoft-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'bsoft_member_section_carousel_item_tabs_overlay' );
		$this->start_controls_tab(
			'bsoft_member_section_carousel_item_tab_normal_overlay',
			array(
				'label' => esc_html__( 'Normal', 'bsoft-elementor' ),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'background_content_normal_overlay',
				'types'    => array( 'classic', 'gradient', 'video' ),
				'selector' => '{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__item::before',
			)
		);
		$this->add_control(
			'bsoft_member_carousel_item_overlay_opacity',
			array(
				'label'     => esc_html__( 'Opacity', 'bsoft-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					),
				),
				'default'   => array(
					'size' => 0.45,
				),
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__item::before' => 'opacity: {{SIZE}};',
				),
			)
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'bsoft_member_section_carousel_item_hover_tab_overlay',
			array(
				'label' => esc_html__( 'Hover', 'bsoft-elementor' ),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'background_content_normal_overlay_hover',
				'types'    => array( 'classic', 'gradient', 'video' ),
				'selector' => '{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__item:hover::before',
			)
		);
		$this->add_control(
			'bsoft_member_carousel_item_overlay_opacity_hover',
			array(
				'label'     => esc_html__( 'Opacity', 'bsoft-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					),
				),
				'default'   => array(
					'size' => 0.45,
				),
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__item:hover::before' => 'opacity: {{SIZE}};',
				),
			)
		);
		$this->add_control(
			'bsoft_member_carousel_item_overlay_transition_hover',
			array(
				'label'     => esc_html__( 'Transition Duration', 'bsoft-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max'  => 3,
						'min'  => 0.10,
						'step' => 0.01,
					),
				),
				'default'   => array(
					'size' => 0.5,
				),
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__item::before' => 'transition:{{SIZE}}s;',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	/**
	 * Bsoft icons style.
	 *
	 * @author Balcomsoft
	 */
	protected function get_bsoft_icons_style() {
		$this->start_controls_section(
			'bsoft_member_section_socials_style',
			array(
				'label' => esc_html__( 'Icon', 'bsoft-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'bsoft_member_socials_margin',
			array(
				'label'      => esc_html__( 'Margin', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__socials' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'bsoft_member_section_socials_style_color',
			array(
				'label'     => esc_html__( 'Color', 'bsoft-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__socials i' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'bsoft_member_section_socials_style_color_hover',
			array(
				'label'     => esc_html__( 'Color Hover', 'bsoft-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__item:hover .starter-bsoft_carousel__socials i' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_social_link_size',
			array(
				'label'      => esc_html__( 'Size', 'bsoft-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'unit' => 'px',
					'size' => '45',
				),
				'size_units' => array( '%', 'px', 'vw' ),
				'range'      => array(
					'%'  => array(
						'min' => 1,
						'max' => 100,
					),
					'px' => array(
						'min' => 1,
						'max' => 300,
					),
					'vw' => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__socials i' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_social_link_rotate',
			array(
				'label'      => esc_html__( 'Rotate', 'bsoft-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'unit' => 'deg',
					'size' => '0',
				),
				'size_units' => array( 'deg' ),
				'range'      => array(
					'deg' => array(
						'min' => 1,
						'max' => 360,
					),
				),
				'separator'  => 'after',
				'selectors'  => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__socials i' => 'transform: rotate({{SIZE}}{{UNIT}});',
				),
			)
		);
		$this->add_control(
			'bsoft_member_socials_align',
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
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__socials' => 'text-align: {{VALUE}};',
				),
			)
		);
		$this->end_controls_section();
	}

	/**
	 * Bsoft Image style
	 *
	 * @author Balcomsoft
	 */
	protected function get_bsoft_image_style() {
		$this->start_controls_section(
			'bsoft_member_section_image_style',
			array(
				'label' => esc_html__( 'Image', 'bsoft-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'bsoft_member_image_margin',
			array(
				'label'      => esc_html__( 'Margin', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_image_padding',
			array(
				'label'      => esc_html__( 'Padding', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'caption_align',
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
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__image' => 'text-align: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_image_width',
			array(
				'label'          => esc_html__( 'Width', 'bsoft-elementor' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => array(
					'unit' => '%',
				),
				'tablet_default' => array(
					'unit' => '%',
				),
				'mobile_default' => array(
					'unit' => '%',
				),
				'size_units'     => array( '%', 'px', 'vw' ),
				'range'          => array(
					'%'  => array(
						'min' => 1,
						'max' => 100,
					),
					'px' => array(
						'min' => 1,
						'max' => 1000,
					),
					'vw' => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'selectors'      => array(
					'{{WRAPPER}} img' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_image_height',
			array(
				'label'          => esc_html__( 'Height', 'bsoft-elementor' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => array(
					'unit' => 'px',
				),
				'tablet_default' => array(
					'unit' => 'px',
				),
				'mobile_default' => array(
					'unit' => 'px',
				),
				'size_units'     => array( 'px', 'vh' ),
				'range'          => array(
					'px' => array(
						'min' => 1,
						'max' => 500,
					),
					'vh' => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'selectors'      => array(
					'{{WRAPPER}} img' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->start_controls_tabs( 'image_effects' );
		$this->start_controls_tab(
			'bsoft_member_image_normal',
			array(
				'label' => esc_html__( 'Normal', 'bsoft-elementor' ),
			)
		);
		$this->add_control(
			'bsoft_member_image_opacity',
			array(
				'label'     => esc_html__( 'Opacity', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} img' => 'opacity: {{SIZE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'css_filters',
				'selector' => '{{WRAPPER}} img',
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'bsoft_member_image_border',
				'selector'  => '{{WRAPPER}} img',
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'bsoft_member_image_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'bsoft_member_image_box_shadow',
				'exclude'  => array(
					'box_shadow_position',
				),
				'selector' => '{{WRAPPER}} img',
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'bsoft_member_image_hover',
			array(
				'label' => esc_html__( 'Hover', 'bsoft-elementor' ),
			)
		);
		$this->add_control(
			'bsoft_member_image_opacity_hover',
			array(
				'label'     => esc_html__( 'Opacity', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					),
				),
				'selectors' => array(
					'{{WRAPPER}}:hover img' => 'opacity: {{SIZE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'css_filters_hover',
				'selector' => '{{WRAPPER}}:hover img',
			)
		);
		$this->add_control(
			'bsoft_member_image_background_hover_transition',
			array(
				'label'     => esc_html__( 'Transition Duration', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max'  => 3,
						'step' => 0.1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}}:hover img' => 'transition-duration: {{SIZE}}',
				),
			)
		);
		$this->add_control(
			'bsoft_member_image_hover_animation',
			array(
				'label' => esc_html__( 'Hover Animation', 'bsoft-elementor' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'bsoft_member_image_border_hover',
				'selector'  => '{{WRAPPER}}:hover img',
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'bsoft_member_image_border_radius_hover',
			array(
				'label'      => esc_html__( 'Border Radius', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}}:hover img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'bsoft_member_image_shadow_hover',
				'exclude'  => array(
					'box_shadow_position',
				),
				'selector' => '{{WRAPPER}}:hover img',
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'bsoft_member_image_position',
			array(
				'label'        => esc_html__( 'Background Position', 'bsoft-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'bsoft-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'bsoft-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);
		$this->add_control(
			'bsoft_member_image_position_align_items',
			array(
				'label'     => esc_html__( 'Align Items', 'bsoft-elementor' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''           => esc_html__( 'Default', 'bsoft-elementor' ),
					'flex-start' => esc_html__( 'Start', 'bsoft-elementor' ),
					'center'     => esc_html__( 'Center', 'bsoft-elementor' ),
					'flex-end'   => esc_html__( 'End', 'bsoft-elementor' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel__item .starter-bsoft-background-position' => 'align-items: {{VALUE}};',
				),
				'condition' => array(
					'bsoft_member_image_position' => 'yes',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Bsoft name style.
	 *
	 * @author Balcomsoft
	 */
	protected function get_bsoft_name_style() {
		$this->start_controls_section(
			'bsoft_member_section_name_style',
			array(
				'label' => esc_html__( 'Name', 'bsoft-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'bsoft_member_name_margin',
			array(
				'label'      => esc_html__( 'Margin', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'bsoft_member_name_align',
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
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__name' => 'text-align: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_name_order',
			array(
				'label'     => esc_html__( 'Order', 'bsoft-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '0',
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__name' => 'order: {{VALUE}};',
				),
			)
		);
		$this->start_controls_tabs( 'title_settings' );
		$this->start_controls_tab(
			'bsoft_member_name_normal',
			array(
				'label' => esc_html__( 'Normal', 'bsoft-elementor' ),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_name_color',
			array(
				'label'     => esc_html__( 'Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__name' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_name_color_hover',
			array(
				'label'     => esc_html__( 'Color Hover', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__item:hover .starter-bsoft_carousel__name' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'bsoft_member_name_typography',
				'label'    => esc_html__( 'Typography', 'bsoft-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__name',
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'bsoft_member_name_hover',
			array(
				'label' => esc_html__( 'Hover', 'bsoft-elementor' ),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_name_color_hover_name',
			array(
				'label'     => esc_html__( 'Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel:hover .starter-bsoft_carousel__name' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'bsoft_member_name_typography_hover',
				'label'    => esc_html__( 'Typography', 'bsoft-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .starter-bsoft_carousel:hover .starter-bsoft_carousel__name',
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	/**
	 * Bsoft  description style.
	 *
	 * @author Balcomsoft
	 */
	protected function get_bsoft_description_style() {
		$this->start_controls_section(
			'bsoft_member_section_description_style',
			array(
				'label' => esc_html__( 'Description', 'bsoft-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'bsoft_member_description_margin',
			array(
				'label'      => esc_html__( 'Margin', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'bsoft_member_description_align',
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
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__description' => 'text-align: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_description_order',
			array(
				'label'     => esc_html__( 'Order', 'bsoft-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '0',
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__description' => 'order: {{VALUE}};',
				),
			)
		);
		$this->start_controls_tabs( 'description_settings' );
		$this->start_controls_tab(
			'bsoft_member_description_normal',
			array(
				'label' => esc_html__( 'Normal', 'bsoft-elementor' ),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_description_color',
			array(
				'label'     => esc_html__( 'Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__description' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_description_color_hover',
			array(
				'label'     => esc_html__( 'Color Hover', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__item:hover .starter-bsoft_carousel__description' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'bsoft_member_description_typography',
				'label'    => esc_html__( 'Typography', 'bsoft-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__description',
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'bsoft_member_description_hover',
			array(
				'label' => esc_html__( 'Hover', 'bsoft-elementor' ),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_description_color_hover_description',
			array(
				'label'     => esc_html__( 'Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel:hover .starter-bsoft_carousel__description' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'bsoft_member_description_typography_hover',
				'label'    => esc_html__( 'Typography', 'bsoft-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .starter-bsoft_carousel:hover .starter-bsoft_carousel__description',
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	/**
	 * Bsoft  Button style.
	 *
	 * @author Balcomsoft
	 */
	protected function get_bsoft_button_style() {
		$this->start_controls_section(
			'bsoft_member_section_button_style',
			array(
				'label' => esc_html__( 'Button', 'bsoft-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'bsoft_member_button_margin',
			array(
				'label'      => esc_html__( 'Margin', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'bsoft_member_button_width_switcher',
			array(
				'label'        => esc_html__( 'Width', 'bsoft-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'bsoft-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'bsoft-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);
		$this->add_control(
			'bsoft_member_button_width',
			array(
				'label'      => esc_html__( 'Width', 'textdomain' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'condition'  => array(
					'bsoft_member_button_width_switcher' => 'yes',
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 50,
				),
				'selectors'  => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button a' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'bsoft_member_button_align',
			array(
				'label'     => esc_html__( 'Alignment', 'bsoft-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'margin-right' => array(
						'title' => esc_html__( 'Left', 'bsoft-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'margin'       => array(
						'title' => esc_html__( 'Center', 'bsoft-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'margin-left'  => array(
						'title' => esc_html__( 'Right', 'bsoft-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button a' => '{{VALUE}}: auto;',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_button_color',
			array(
				'label'     => esc_html__( 'Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button a' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_button_color_hover',
			array(
				'label'     => esc_html__( 'Color Hover', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__item:hover .starter-bsoft_carousel__button a' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_button_background',
			array(
				'label'     => esc_html__( 'Background', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__item .starter-bsoft_carousel__button a' => 'background: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_button_background_hover',
			array(
				'label'     => esc_html__( 'Background Hover', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__item:hover .starter-bsoft_carousel__button a' => 'background: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'bsoft_member_button_typography_hover',
				'label'    => esc_html__( 'Typography', 'bsoft-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__item .starter-bsoft_carousel__button',
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	/**
	 * Bsoft carousel arrows.
	 *
	 * @author Balcomsoft
	 */
	protected function get_bsoft_carousel_arrows_style() {
		$this->start_controls_section(
			'bsoft_member_section_carousel_arrows_style',
			array(
				'label' => esc_html__( 'Carousel Arrows', 'bsoft-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'bsoft_member_section_carousel_arrows_margin',
			array(
				'label'      => esc_html__( 'Margin', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-prev' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-next' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'after',
			)
		);
		$this->start_controls_tabs( 'bsoft_member_section_carousel_arrows_tabs' );
		$this->start_controls_tab(
			'bsoft_member_section_carousel_arrows_tab_normal',
			array(
				'label' => esc_html__( 'Normal', 'bsoft-elementor' ),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_section_carousel_arrows_size',
			array(
				'label'     => esc_html__( 'Size', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 300,
					),
				),
				'default'   => array(
					'size' => 15,
				),
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-prev' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-next' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_section_carousel_arrows_width',
			array(
				'label'     => esc_html__( 'Width', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 300,
					),
				),
				'default'   => array(
					'size' => 50,
				),
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-prev' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-next' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_section_carousel_arrows_height',
			array(
				'label'     => esc_html__( 'Height', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 300,
					),
				),
				'default'   => array(
					'size' => 50,
				),
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-prev' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-next' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_carousel_arrows_color',
			array(
				'label'     => esc_html__( 'Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-prev' => 'color: {{VALUE}};',
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-next' => 'color: {{VALUE}};',
				),
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'bsoft_member_carousel_arrows_background',
			array(
				'label'     => esc_html__( 'Background', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-prev' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-next' => 'background-color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'bsoft_member_carousel_arrows_border',
				'selector'  => '{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-prev, {{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-next',
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'bsoft_member_carousel_arrows_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'bsoft_member_carousel_arrows_box_shadow',
				'exclude'  => array(
					'box_shadow_position',
				),
				'selector' => '{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-prev, {{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-next',
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'bsoft_member_section_carousel_arrows_tab_hover',
			array(
				'label' => esc_html__( 'Hover', 'bsoft-elementor' ),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_section_carousel_arrows_size_hover',
			array(
				'label'     => esc_html__( 'Size', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 300,
					),
				),
				'default'   => array(
					'size' => 15,
				),
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-prev:hover' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-next:hover' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_section_carousel_arrows_width_hover',
			array(
				'label'     => esc_html__( 'Width', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 300,
					),
				),
				'default'   => array(
					'size' => 50,
				),
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-prev:hover' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-next:hover' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_section_carousel_arrows_height_hover',
			array(
				'label'     => esc_html__( 'Height', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 300,
					),
				),
				'default'   => array(
					'size' => 50,
				),
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-prev:hover' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-next:hover' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_carousel_arrows_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-prev:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-next:hover' => 'color: {{VALUE}};',
				),
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'bsoft_member_carousel_arrows_background_hover',
			array(
				'label'     => esc_html__( 'Background', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-prev:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-next:hover' => 'background-color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'bsoft_member_carousel_arrows_hover_border',
				'selector'  => '{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-prev:hover, {{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-next',
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'bsoft_member_carousel_arrows_hover_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-prev:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-next:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'bsoft_member_carousel_arrows_hover_box_shadow',
				'exclude'  => array(
					'box_shadow_position',
				),
				'selector' => '{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-prev:hover, {{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__button-next',
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Bsoft carousel bullets.
	 *
	 * @author Balcomsoft
	 */
	protected function get_bsoft_carousel_bullets_style() {
		$this->start_controls_section(
			'bsoft_member_section_carousel_bullets_style',
			array(
				'label' => esc_html__( 'Carousel Dots', 'bsoft-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'bsoft_member_section_carousel_bullets_margin',
			array(
				'label'      => esc_html__( 'Margin', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__pagination .swiper-pagination-bullet' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'after',
			)
		);
		$this->start_controls_tabs( 'bsoft_member_section_carousel_bullets_tabs' );
		$this->start_controls_tab(
			'bsoft_member_section_carousel_bullets_tab_normal',
			array(
				'label' => esc_html__( 'Normal', 'bsoft-elementor' ),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_section_carousel_bullets_width',
			array(
				'label'     => esc_html__( 'Width', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 100,
					),
				),
				'default'   => array(
					'size' => 6,
				),
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_section_carousel_bullets_height',
			array(
				'label'     => esc_html__( 'Height', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 100,
					),
				),
				'default'   => array(
					'size' => 6,
				),
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__pagination .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_carousel_bullets_background',
			array(
				'label'     => esc_html__( 'Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'bsoft_member_carousel_bullets_border',
				'selector'  => '{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__pagination .swiper-pagination-bullet',
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'bsoft_member_carousel_bullets_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__pagination .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'bsoft_member_carousel_bullets_box_shadow',
				'exclude'  => array(
					'box_shadow_position',
				),
				'selector' => '{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__pagination .swiper-pagination-bullet',
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'bsoft_member_section_carousel_bullets_tab_hover',
			array(
				'label' => esc_html__( 'Hover', 'bsoft-elementor' ),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_section_carousel_bullets_width_hover',
			array(
				'label'     => esc_html__( 'Width', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 100,
					),
				),
				'default'   => array(
					'size' => 6,
				),
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__pagination .swiper-pagination-bullet:hover' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_section_carousel_bullets_height_hover',
			array(
				'label'     => esc_html__( 'Height', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 100,
					),
				),
				'default'   => array(
					'size' => 6,
				),
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__pagination .swiper-pagination-bullet:hover' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_carousel_bullets_background_hover',
			array(
				'label'     => esc_html__( 'Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__pagination .swiper-pagination-bullet:hover' => 'background-color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'bsoft_member_carousel_bullets_border_hover',
				'selector'  => '{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__pagination .swiper-pagination-bullet:hover',
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'bsoft_member_carousel_bullets_border_radius_hover',
			array(
				'label'      => esc_html__( 'Border Radius', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__pagination .swiper-pagination-bullet:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'bsoft_member_carousel_bullets_box_shadow_hover',
				'exclude'  => array(
					'box_shadow_position',
				),
				'selector' => '{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__pagination .swiper-pagination-bullet:hover',
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'bsoft_member_section_carousel_bullets_tab_active',
			array(
				'label' => esc_html__( 'Active', 'bsoft-elementor' ),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_section_carousel_bullets_width_active',
			array(
				'label'     => esc_html__( 'Width', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 100,
					),
				),
				'default'   => array(
					'size' => 12,
				),
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_section_carousel_bullets_height_active',
			array(
				'label'     => esc_html__( 'Height', 'bsoft-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 100,
					),
				),
				'default'   => array(
					'size' => 12,
				),
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'bsoft_member_carousel_bullets_background_active',
			array(
				'label'     => esc_html__( 'Color', 'bsoft-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'bsoft_member_carousel_bullets_border_active',
				'selector'  => '{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__pagination .swiper-pagination-bullet.swiper-pagination-bullet-active',
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'bsoft_member_carousel_bullets_border_radius_active',
			array(
				'label'      => esc_html__( 'Border Radius', 'bsoft-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'bsoft_member_carousel_bullets_box_shadow_active',
				'exclude'  => array(
					'box_shadow_position',
				),
				'selector' => '{{WRAPPER}} .starter-bsoft_carousel .starter-bsoft_carousel__pagination .swiper-pagination-bullet.swiper-pagination-bullet-active',
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	/**
	 * Bsoft registor controls.
	 *
	 * @author Balcomsoft
	 */
	protected function register_controls() {
		$this->get_bsoft_content_options();
		$this->get_bsoft_carousel_options();
		$this->get_bsoft_carousel_item_style();
		$this->get_bsoft_icons_style();
		$this->get_bsoft_image_style();
		$this->get_bsoft_name_style();
		$this->get_bsoft_description_style();
		$this->get_bsoft_button_style();
		$this->get_bsoft_carousel_arrows_style();
		$this->get_bsoft_carousel_bullets_style();
	}

	/**
	 * Render.
	 */
	protected function render() {
		$settings                    = $this->get_settings_for_display();
		$bsoft_member_image_position = $settings['bsoft_member_image_position'];

		$show_dots                  = ( in_array( $settings['navigation'], array( 'dots', 'both' ), true ) );
		$show_arrows                = ( in_array( $settings['navigation'], array( 'arrows', 'both' ), true ) );
		$slides_count               = count( $settings['bsoft_member_name_list'] );
		$bsoft_member_social_linkkk = ( ! empty( $bsoft_member_social_linkkk ) );
		$bsoft_member               = ( ! empty( $bsoft_member ) );
		?>
		<div class="starter-bsoft_carousel">
			<div class="swiper-container">
				<div class="swiper-wrapper">          
				<?php
				foreach ( $settings['bsoft_member_name_list'] as $index => $item ) :
					$name        = ( $item['bsoft_member_name'] ) ? '<div class="starter-bsoft_carousel__name">' . $item['bsoft_member_name'] . '</div>' : '';
					$description = ( $item['bsoft_member_description'] ) ? '<div class="starter-bsoft_carousel__description">' . $item['bsoft_member_description'] . '</div>' : '';
					$buttonl     = ( $item['button_label'] ) ? '<div class="starter-bsoft_carousel__button"><a href=" ' . $item['button_link_label']['url'] . ' ">' . $item['button_label'] . '</a></div>' : '';
					$buttonlll   = ( $item['bsoft_member_social_icon_1'] );
					?>
					<div class="swiper-slide">
						<?php if ( 'yes' === $item['show_button_url'] ) : ?>
						<a href="<?php echo esc_url( $item['bsoft_member_social_link_1']['url'] ); ?>">
						<?php endif; ?>
						<div class="starter-bsoft_carousel__item">
							<div class="starter-bsoft_carousel__item_main">
							<?php if ( isset( $item['image']['id'] ) ) : ?>
							<div class="starter-bsoft_carousel__image">   
								<?php $bsoft_member .= $bsoft_member_social_linkkk; ?>       
								<img src="<?php echo esc_attr( $item['image']['url'] ); ?>" />
							</div>
							<?php else : ?>
							<div class="starter-bsoft_carousel__socials">
								<?php \Elementor\Icons_Manager::render_icon( $item['bsoft_member_social_icon_1'], array( 'aria-hidden' => 'true' ) ); ?>
							</div>
								<?php
								endif;
							?>
							<?php if ( 'yes' === $settings['bsoft_member_image_position'] ) : ?>
								<div class="starter-bsoft-background-position"><div>
							<?php endif; ?>
								<?php
								$bsoft_member  = $name;
								$bsoft_member .= $description;
								$bsoft_member .= $buttonl;
								echo wp_kses_post( $bsoft_member );
								?>
								<?php if ( 'yes' === $settings['bsoft_member_image_position'] ) : ?>
								</div></div>
								<?php endif; ?>
						</div>
						</div>
						<div class="starter-bsoft_carousel__item_overlay"></div>
						<?php if ( 'yes' === $item['show_button_url'] ) : ?>
							</a>
						<?php endif; ?>
					</div>
					<?php endforeach; ?>
				</div>
						<?php if ( $settings['slides_to_show'] < $slides_count || 'yes' === $settings['slider_loop'] ) : ?>
							<?php if ( $show_dots ) : ?>
						<div class="starter-bsoft_carousel__pagination"></div>
					<?php endif; ?>
							<?php if ( $show_arrows ) : ?>
						<div class="starter-bsoft_carousel__button-prev">
								<?php $this->render_swiper_button( 'previous' ); ?>
						</div>
						<div class="starter-bsoft_carousel__button-next">
								<?php $this->render_swiper_button( 'next' ); ?>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
						<?php
	}

				/**
				 * Bsoft swiper button
				 *
				 * @param array $type button.
				 */
	private function render_swiper_button( $type ) {
		$direction = 'next' === $type ? 'right' : 'left';

		$icon_value = 'eicon-chevron-' . $direction;

		Icons_Manager::render_icon(
			array(
				'library' => 'eicons',
				'value'   => $icon_value,
			),
			array( 'aria-hidden' => 'true' )
		);
	}
}
