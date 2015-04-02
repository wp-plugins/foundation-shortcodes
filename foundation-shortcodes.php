<?php
/*
Plugin Name: Foundation Shortcodes
Plugin URI: http://www.oyova.com
Description: Craft Foundation markup, including rows and columns, using WordPress shortcodes. Requires a theme built with Foundation 5.
Author URI: http://www.oyova.com
Version: 1.0.6
Text Domain: foundation-shortcodes
 */

// adds row shortcode
function oyova_foundation_row ( $atts, $content = null ) {
	return '<div class="row">' . do_shortcode ( $content ) . '</div>';
}

add_shortcode ('row', 'oyova_foundation_row' );

// adds column shortcode
function oyova_foundation_column ( $atts, $content = null ) {
	$specs = shortcode_atts( array(
		'screen'		=> 'medium',
		'columns'		=> '12',
		'altscreen'		=> '',
		'altcolumns'	=> '',
		), $atts );
	return '<div class="' . esc_attr($specs['screen'] ) . '-' . esc_attr($specs['columns']) . ' ' . esc_attr($specs['altscreen'] ) . '-' . esc_attr($specs['altcolumns']) . ' columns">' . do_shortcode ( $content ) . '</div>';
}

add_shortcode ('column', 'oyova_foundation_column' );

// adds block grid shortcode
function oyova_foundation_blockgridul ( $atts, $content = null ) {
	$specs = shortcode_atts( array(
		'screen'		=> 'medium',
		'columns'		=> '4',
		'altscreen'		=> '',
		'altcolumns'	=> '',
		), $atts );
	return '<ul class="' . esc_attr($specs['screen'] ) . '-block-grid-' . esc_attr($specs['columns']) . ' ' . esc_attr($specs['altscreen'] ) . '-block-grid-' . esc_attr($specs['altcolumns']) .'">' . do_shortcode ( $content ) . '</ul>';
}

add_shortcode ('blockgrid', 'oyova_foundation_blockgridul' );

// adds block grid list items
function oyova_foundation_blockgridli ( $atts, $content = null ) {
	return '<li>' .  do_shortcode ( $content ) . '</li>';
}

add_shortcode ('item', 'oyova_foundation_blockgridli' );

// adds button control
function oyova_foundation_buttons ( $atts, $content = null ) {
	$specs = shortcode_atts( array(
		'url'	=> '#',
		'style'	=> ''
		), $atts );
	return '<a href="' . esc_attr($specs['url'] ) . '" class="button ' . esc_attr($specs['style'] ) . '">' . $content . '</a>';
	//return '<ul class="' . esc_attr($specs['screen'] ) . '-block-grid-' . esc_attr($specs['columns']) . '">' . $content . '</div>';
}

add_shortcode ('button', 'oyova_foundation_buttons' );

// adds flex video shortcode
function oyova_foundation_flexvideo ( $atts, $content = null ) {
	return '<div class="flex-video">' . $content . '</div>';
}

add_shortcode ('flexvideo', 'oyova_foundation_flexvideo' );

// adds tabs, titles and tab content
function oyova_foundation_tabs( $atts, $content = null ) {
	$specs = shortcode_atts( array(
		'style'		=> ''
	), $atts );
	return '<ul class="tabs ' . esc_attr($specs['style'] ) . '" data-tab>' . do_shortcode ( $content ) . '</ul>';
}

add_shortcode ('tabs', 'oyova_foundation_tabs' );

function oyova_foundation_tabs_title ( $atts, $content = null ) {
	static $i = 0;
	if ( $i == 0 ) {
		$class = 'active';
	} else {
		$class = NULL;
	}
	$i++;
	$value = '<li class="tab-title ' . $class . '"><a href="#tabpanel' . $i . '">' .
	$content . '</a></li>';

	return $value;
}

add_shortcode ('tab-title', 'oyova_foundation_tabs_title' );

function oyova_foundation_tabs_content( $atts, $content = null ) {
	return '<div class="tabs-content">' . do_shortcode ( $content ) . '</div>';
}

add_shortcode ('tab-content', 'oyova_foundation_tabs_content' );

function oyova_foundation_tabs_panel ($atts, $content = null ) {
	static $i = 0;
	if ( $i == 0 ) {
		$class = 'active';
	} else {
		$class = NULL;
	}
	$i++;
	return '<section role="tabpanel" aria-hidden="false" class="content ' . $class .'" id="tabpanel' . $i . '">' . $content . '</section>';
}

add_shortcode ('tab-panel', 'oyova_foundation_tabs_panel' );

// accordions and associated
function oyova_foundation_accordion( $atts, $content = null ) {
	return '<dl class="accordion" data-accordion>' . do_shortcode ( $content ) . '</dl>';
}

add_shortcode ('accordion', 'oyova_foundation_accordion' );

function oyova_foundation_tabs_accordion_item ( $atts, $content = null ) {
	$specs = shortcode_atts( array(
		'title'		=> ''
		), $atts );
	static $i = 0;
/*	if ( $i == 0 ) {
		$class = 'active';
	} else {
		$class = NULL;
	}*/
	$i++;
	$value = '<dd class="accordion-navigation"><a href="#panel' . $i . '">' . esc_attr($specs['title'] ) . '</a><div id="panel' . $i . '" class="content">' . $content . '</div></dd>';

	return $value;
}

add_shortcode ('accordion-item', 'oyova_foundation_tabs_accordion_item' );

function oyova_foundation_modal ( $atts, $content = null ) {
	$specs = shortcode_atts( array(
		'title' => '',
		'class' => '',
		'id'	=> 'foundationModal',
		), $atts );
	return '<a class="' . esc_attr ($specs['class'] ) . '" href="#" data-reveal-id="' . esc_attr($specs['id']) . '">' . esc_attr ($specs['title']). '</a><div id="' . esc_attr ($specs['id']) . '" class="reveal-modal" data-reveal>'
		. do_shortcode ($content) . '<a class="close-reveal-modal">&#215;</a></div>';
}

add_shortcode ( 'modal', 'oyova_foundation_modal' );



//disables wp texturize on registered shortcodes
function oyova_shortcode_exclude( $shortcodes ) {
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

add_filter ('no_texturize_shortcodes', 'oyova_shortcode_exclude' );

// remove and re-prioritize wpautop to prevent auto formatting inside shortcodes
// shortcode_unautop is a core function

remove_filter( 'the_content', 'wpautop' );
add_filter ( 'the_content', 'wpautop', 99 );
add_filter ('the_content', 'shortcode_unautop', 100 );