<?php 
/*
Plugin Name: Simple REST Menus
Version: 0.1
Description: Adds endpoints to return menu data for all menus via
the WP V2 REST API
Author: Jason Wilson, EF - CulturalCare Au Pair
*/

/**
 * Get all menus in the collection
 * @return array List of menus with all data
 */
function ef_rest_menus_get_all_menus () {
    $menuTerms = get_terms( array(
        'taxonomy' => 'nav_menu',
        'hide_empty' => false,
    ) );
    foreach ($menuTerms as $term) {
        $newMenu = new stdClass;
        $newMenu->slug = $term->slug;
        $newMenu->items = wp_get_nav_menu_items( $term->slug );
        $menus[] = $newMenu;
    }
    /*foreach (wp_get_nav_menu_items() as $slug => $description) {
        $obj = new stdClass;
        $obj->slug = $slug;
        $obj->description = $description;
        $menus[] = $obj;
    }*/
    return $menus;
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'ef-menus/v1', '/menus', array(
        'methods' => 'GET',
        'callback' => 'ef_rest_menus_get_all_menus',
    ) );
} );