<?php

/**
 * Prevent Direct Access
 */
defined( 'ABSPATH' ) or die( "Restricted access!" );

/**
 * Register text domain
 */
function spacexchimp_p005_textdomain() {
    load_plugin_textdomain( SPACEXCHIMP_P005_TEXT, false, SPACEXCHIMP_P005_DIR . '/languages/' );
}
add_action( 'init', 'spacexchimp_p005_textdomain' );

/**
 * Print direct link to plugin admin page
 *
 * Fetches array of links generated by WP Plugin admin page ( Deactivate | Edit )
 * and inserts a link to the plugin admin page
 */
function spacexchimp_p005_settings_link( $links ) {
    $page = '<a href="' . admin_url( 'admin.php?page=spacexchimp/' . SPACEXCHIMP_P005_SLUG ) .'">' . __( 'Settings', SPACEXCHIMP_P005_TEXT ) . '</a>';
    array_unshift( $links, $page );
    return $links;
}
add_filter( 'plugin_action_links_' . SPACEXCHIMP_P005_BASE, 'spacexchimp_p005_settings_link' );

/**
 * Print additional links to plugin meta row
 */
function spacexchimp_p005_plugin_row_meta( $links, $file ) {

    if ( strpos( $file, SPACEXCHIMP_P005_SLUG . '.php' ) !== false ) {

        $new_links = array(
                           'donate' => '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8A88KC7TFF6CS" target="_blank"><span class="dashicons dashicons-heart"></span> ' . __( 'Donate', SPACEXCHIMP_P005_TEXT ) . '</a>'
                           );
        $links = array_merge( $links, $new_links );
    }

    return $links;
}
add_filter( 'plugin_row_meta', 'spacexchimp_p005_plugin_row_meta', 10, 2 );

/**
 * Register brand menu item in the Admin Menu
 */
function spacexchimp_p005_register_admin_menu() {

    // Return if the brand menu item is already existed
    if ( !empty ( $GLOBALS['admin_page_hooks']['spacexchimp'] ) ) return;

    $page_title = 'Space X-Chimp';
    $menu_title = 'Space X-Chimp';
    $capability = 'manage_options';
    $menu_slug  = 'spacexchimp';
    $function   = null;
    $icon_url   = 'dashicons-star-filled';
    $position   = 66;

    add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
}
add_action( 'admin_menu', 'spacexchimp_p005_register_admin_menu' );

/**
 * Register plugin's submenu item in the brand menu item
 */
function spacexchimp_p005_register_submenu_page() {

    $parent_slug = 'spacexchimp';
    $page_title  = SPACEXCHIMP_P005_NAME;
    $menu_title  = __( 'Social Media Follow Buttons', SPACEXCHIMP_P005_TEXT );
    $capability  = 'manage_options';
    $menu_slug   = 'spacexchimp/' . SPACEXCHIMP_P005_SLUG;
    $function    = 'spacexchimp_p005_render_submenu_page';

    add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);
}
add_action( 'admin_menu', 'spacexchimp_p005_register_submenu_page' );

/**
 * Register settings
 */
function spacexchimp_p005_register_settings() {
    register_setting( SPACEXCHIMP_P005_SETTINGS . '_settings_group', SPACEXCHIMP_P005_SETTINGS . '_settings' );
    register_setting( SPACEXCHIMP_P005_SETTINGS . '_settings_group_si', SPACEXCHIMP_P005_SETTINGS . '_service_info' );
}
add_action( 'admin_init', 'spacexchimp_p005_register_settings' );
