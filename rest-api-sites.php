<?php
/*
* Plugin Name: WP REST API Site Listing
* Plugin URI: https://github.com/misfist/wp-multisite-rest-api.git
* Description: Add endpoint for list of sites using JSON Rest API v2.
* Version: 0.1
* Author: Pea
* Author URI: http://misfist.com
* License: GPLv3
* */

define( 'REST_API_NAMESPACE', 'rest-sites-list/v2' );

add_action( 'rest_api_init', function () {

    // Endpoint for list of sites
    register_rest_route( REST_API_NAMESPACE, '/sites', array(
        'methods' => WP_REST_Server::ALLMETHODS,
        'callback' => 'rest_api_list_sites',
    ) );

} );

function rest_api_list_sites() {
    $sites = wp_get_sites();

    for( $i = 0, $size = count( $sites ); $i < $size; $i++ ) {

        $blog_details = get_blog_details( $sites[$i]['blog_id'] );
        $sites[$i]['site_name'] = $blog_details->blogname;
        $sites[$i]['site_url'] = $blog_details->siteurl;
        $sites[$i]['rest_api_link'] = $blog_details->siteurl . '/wp-json/wp/v2/';

    }
    
    return $sites;
}

?>