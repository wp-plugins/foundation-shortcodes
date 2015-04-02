<?php
/*
Plugin Name: Foundation Shortcodes
Plugin URI: http://www.oyova.com
Description: Craft Foundation markup, including rows and columns, using WordPress shortcodes. Requires a theme built with Foundation 5.
Author: Oyova
Version: 1.0.5
Author URI: http://www.oyova.com
Text Domain: foundation-shortcodes
 */

class Oyova_Foundation_Shortcodes {

	public function __construct() {
		// remove and re-prioritize wpautop to prevent auto formatting inside shortcodes
		// shortcode_unautop is a core function
		remove_filter( 'the_content', 'wpautop' );
		add_filter( 'the_content', 'wpautop', 99 );
		add_filter( 'the_content', 'shortcode_unautop', 100 );

		add_filter( 'no_texturize_shortcodes', 'oyova_shortcode_exclude' );

		add_shortcode( 'row', array( $this, 'row' ) );
		add_shortcode( 'column', array( $this, 'column' ) );
		add_shortcode( 'blockgrid', array( $this, 'blockgridul' ) );
		add_shortcode( 'item', array( $this, 'blockgridli' ) );
		add_shortcode( 'button', array( $this, 'buttons' ) );
		add_shortcode( 'flexvideo', array( $this, 'flexvideo' ) );
		add_shortcode( 'tabs', array( $this, 'tabs' ) );
		add_shortcode( 'tab-title', array( $this, 'tabs_title' ) );
		add_shortcode( 'tab-content', array( $this, 'tabs_content' ) );
		add_shortcode( 'tab-panel', array( $this, 'tabs_panel' ) );
		add_shortcode( 'accordion', array( $this, 'accordion' ) );
		add_shortcode( 'accordion-item', array( $this, 'tabs_accordion_item' ) );
		add_shortcode( 'modal', array( $this, 'modal' ) );
	}

	public function row( $atts, $content = null ) {
		return '<div class="row">' . do_shortcode( $content ) . '</div>';
	}

	public function column( $atts, $content = null ) {
		$specs = shortcode_atts( array(
			'screen'     => 'medium',
			'columns'    => '12',
			'altscreen'  => '',
			'altcolumns' => '',
		), $atts );

		return '<div class="' . esc_attr( $specs['screen'] ) . '-' . esc_attr( $specs['columns'] ) . ' ' . esc_attr( $specs['altscreen'] ) . '-' . esc_attr( $specs['altcolumns'] ) . ' columns">' . do_shortcode( $content ) . '</div>';
	}

	public function blockgridul( $atts, $content = null ) {
		$specs = shortcode_atts( array(
			'screen'     => 'medium',
			'columns'    => '4',
			'altscreen'  => '',
			'altcolumns' => '',
		), $atts );

		return '<ul class="' . esc_attr( $specs['screen'] ) . '-block-grid-' . esc_attr( $specs['columns'] ) . ' ' . esc_attr( $specs['altscreen'] ) . '-block-grid-' . esc_attr( $specs['altcolumns'] ) . '">' . do_shortcode( $content ) . '</ul>';
	}

	public function blockgridli( $atts, $content = null ) {
		return '<li>' . do_shortcode( $content ) . '</li>';
	}

	public function buttons( $atts, $content = null ) {
		$specs = shortcode_atts( array(
			'url'   => '#',
			'style' => ''
		), $atts );

		return '<a href="' . esc_attr( $specs['url'] ) . '" class="button ' . esc_attr( $specs['style'] ) . '">' . $content . '</a>';
	}

	public function flexvideo( $atts, $content = null ) {
		return '<div class="flex-video">' . $content . '</div>';
	}

	public function tabs( $atts, $content = null ) {
		$specs = shortcode_atts( array(
			'style' => ''
		), $atts );

		return '<ul class="tabs ' . esc_attr( $specs['style'] ) . '" data-tab>' . do_shortcode( $content ) . '</ul>';
	}

	public function tabs_title( $atts, $content = null ) {
		static $i = 0;
		if ( $i == 0 ) {
			$class = 'active';
		} else {
			$class = null;
		}
		$i ++;
		$value = '<li class="tab-title ' . $class . '"><a href="#tabpanel' . $i . '">' . $content . '</a></li>';

		return $value;
	}

	public function tabs_content( $atts, $content = null ) {
		return '<div class="tabs-content">' . do_shortcode( $content ) . '</div>';
	}

	public function tabs_panel( $atts, $content = null ) {
		static $i = 0;
		if ( $i == 0 ) {
			$class = 'active';
		} else {
			$class = null;
		}
		$i ++;

		return '<section role="tabpanel" aria-hidden="false" class="content ' . $class . '" id="tabpanel' . $i . '">' . $content . '</section>';
	}

	// accordions and associated
	public function accordion( $atts, $content = null ) {
		return '<dl class="accordion" data-accordion>' . do_shortcode( $content ) . '</dl>';
	}

	public function tabs_accordion_item( $atts, $content = null ) {
		$specs = shortcode_atts( array(
			'title' => ''
		), $atts );
		static $i = 0;
		/*	if ( $i == 0 ) {
				$class = 'active';
			} else {
				$class = NULL;
			}*/
		$i ++;
		$value = '<dd class="accordion-navigation"><a href="#panel' . $i . '">' . esc_attr( $specs['title'] ) . '</a><div id="panel' . $i . '" class="content">' . $content . '</div></dd>';

		return $value;
	}


	public function modal( $atts, $content = null ) {
		$specs = shortcode_atts( array(
			'title' => '',
			'class' => '',
			'id'    => 'foundationModal',
		), $atts );

		return '<a class="' . esc_attr( $specs['class'] ) . '" href="#" data-reveal-id="' . esc_attr( $specs['id'] ) . '">' . esc_attr( $specs['title'] ) . '</a><div id="' . esc_attr( $specs['id'] ) . '" class="reveal-modal" data-reveal>' . do_shortcode( $content ) . '<a class="close-reveal-modal">&#215;</a></div>';
	}

	//disables wp texturize on registered shortcodes
	public function shortcode_exclude( $shortcodes ) {
		$shortcodes[] = 'row';
		$shortcodes[] = 'column';
		$shortcodes[] = 'blockgrid';
		$shortcodes[] = 'item';
		$shortcodes[] = 'button';
		$shortcodes[] = 'flexvideo';
		$shortcodes[] = 'tabs';
		$shortcodes[] = 'tab-title';
		$shortcodes[] = 'tab-content';
		$shortcodes[] = 'tab-panel';
		$shortcodes[] = 'accordion';
		$shortcodes[] = 'accordion-item';
		$shortcodes[] = 'modal';

		return $shortcodes;
	}
}

new Oyova_Foundation_Shortcodes;