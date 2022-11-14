<?php
/**
 * Plugin Name: WPS Product Search Field SKU
 * Plugin URI: https://www.netpad.gr
 * Description: WPS Product Search Field SKU
 * Version: 1.0.0
 * Author: George Tsiokos
 * Author URI: https://www.netpad.gr
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class WPS_Search_Sku {
	public static function init() {
		add_filter ( 'woocommerce_product_search_indexer_filter_content', array( __CLASS__, 'woocommerce_product_search_indexer_filter_content'), 10, 3 );
	}

	public static function woocommerce_product_search_indexer_filter_content( $content, $context, $post_id ) {
		if ( $context === 'post_content' ) {
			$product = wc_get_product( $post_id );
			if ( $product ) {
				$product_sku = $product->get_sku();
				$character_search = substr( $product_sku, 2, 1 );
				if ( $character_search == ' ' ) {
					$alternative_sku = str_replace( ' ', '', $product_sku );
				}
				if ( $character_search == '-' ) {
					$alternative_sku = str_replace( '-', '', $product_sku );
				}
				if ( $character_search == '_' ) {
					$alternative_sku = str_replace( '_', '', $product_sku );
				}
				if ( empty( $character_search ) ) {
					$alternative_sku = substr_replace( $product_sku, ' ', 2, 0 );
				}
			}
			$content .= ' ' . $alternative_sku;
		}
		return $content;
	}
} WPS_Search_Sku::init();