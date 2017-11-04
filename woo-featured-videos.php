<?php
/*
	Plugin Name: WooCommerce Featured Videos
	Plugin URI: https://wordpress.org/plugins/woo-featured-videos/
	Description: It allows to replace the Image with Youtube videos easily
	Version: 1.0.0
	Author: Pluginbazar
	Author URI: https://www.pluginbazar.net/
	License: GPLv2 or later
	License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

	add_action( 'woocommerce_product_data_tabs', 'wfv_woocommerce_product_data_tabs' );
	add_action( 'woocommerce_product_data_panels', 'wfv_woocommerce_product_data_panels' );
	add_action( 'woocommerce_admin_process_product_object', 'wfv_woocommerce_admin_process_product_object' );
	add_action( 'woocommerce_product_thumbnails', 'wfv_woocommerce_product_thumbnails' );
	add_filter( 'woocommerce_single_product_image_thumbnail_html', 'wfv_woocommerce_single_product_image_html', 10, 1 );
	
	function wfv_woocommerce_single_product_image_html( $html ){ return ""; }
	
	function wfv_woocommerce_product_thumbnails( ){
		
		$featured_videos = get_post_meta( get_the_ID(), 'featured_videos', true );
		$featured_videos = empty( $featured_videos ) ? 'I7i1_2DsRho' : $featured_videos;
		
		echo "<div style='width: 100%;margin-top: 50px;'><iframe src='https://www.youtube.com/embed/$featured_videos' frameborder='0' allowfullscreen='' scrolling='no'></iframe></div>";
	}
	
	function wfv_woocommerce_product_data_tabs( $tabs ){
		
		$tabs['wfv'] = array(
			'label' 	=> __( 'Featured Videos', 'td' ),
			'priority' 	=> 80,
			'target' 	=> 'wfv_featured_videos',
			'class'		=> array(),
		);
		return $tabs;
	}
	
	function wfv_woocommerce_product_data_panels( $OPTIONS_DATA = array(), $HTML = "" ){
		
		echo "<div id='wfv_featured_videos' class='panel woocommerce_options_panel'>";
		echo "<div class='options_group'>";
	
		woocommerce_wp_text_input( array(
			'id'          => 'featured_videos',
			'label'       => __( 'Youtube Video ID', 'woocommerce' ),
			'placeholder' => '',
			'description' => __( 'Enter the youtube video ID', 'woocommerce' ),
			'type'   => 'text',
			'desc_tip'    => true,
		) );
		
		echo "</div>";
		echo "</div>";
	}
	
	function wfv_woocommerce_admin_process_product_object( $product ){
		
		$featured_videos 	= isset( $_POST['featured_videos'] ) ? $_POST['featured_videos'] : '';
		update_post_meta( $product->id, 'featured_videos', $featured_videos );
	}