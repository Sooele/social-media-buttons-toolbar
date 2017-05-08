<?php

/**
 * Prevent Direct Access
 *
 * @since 0.1
 */
defined('ABSPATH') or die("Restricted access!");

/**
 * Register text domain
 *
 * @since 2.0
 */
function smbtoolbar_textdomain() {
    load_plugin_textdomain( SMEDIABT_TEXT, false, SMEDIABT_DIR . '/languages/' );
}
add_action( 'init', 'smbtoolbar_textdomain' );

/**
 * Print direct link to plugin admin page
 *
 * Fetches array of links generated by WP Plugin admin page ( Deactivate | Edit )
 * and inserts a link to the plugin admin page
 *
 * @since  2.0
 * @param  array $links Array of links generated by WP in Plugin Admin page.
 * @return array        Array of links to be output on Plugin Admin page.
 */
function smbtoolbar_settings_link( $links ) {
    $page = '<a href="' . admin_url( 'options-general.php?page=social-media-buttons-toolbar.php' ) .'">' . __( 'Settings', SMEDIABT_TEXT ) . '</a>';
    array_unshift( $links, $page );
    return $links;
}
add_filter( 'plugin_action_links_'.SMEDIABT_BASE, 'smbtoolbar_settings_link' );

/**
 * Print additional links to plugin meta row
 *
 * @since 4.2
 */
function smbtoolbar_plugin_row_meta( $links, $file ) {

    if ( strpos( $file, 'social-media-buttons-toolbar.php' ) !== false ) {

        $new_links = array(
                           'donate' => '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8A88KC7TFF6CS" target="_blank"><span class="dashicons dashicons-heart"></span> ' . __( 'Donate', SMEDIABT_TEXT ) . '</a>'
                           );
        $links = array_merge( $links, $new_links );
    }

    return $links;
}
add_filter( 'plugin_row_meta', 'smbtoolbar_plugin_row_meta', 10, 2 );

/**
 * Register plugin's submenu in the "Settings" Admin Menu
 *
 * @since 4.2
 */
function smbtoolbar_register_submenu_page() {
    add_options_page( __( 'Social Media Follow Buttons Bar', SMEDIABT_TEXT ), __( 'Social Media Follow Buttons', SMEDIABT_TEXT ), 'manage_options', 'social-media-buttons-toolbar', 'smbtoolbar_render_submenu_page' );
}
add_action( 'admin_menu', 'smbtoolbar_register_submenu_page' );

/**
 * Register settings
 *
 * @since 4.2
 */
function smbtoolbar_register_settings() {
    register_setting( 'smbtoolbar_settings_group', 'smbtoolbar_settings' );
    register_setting( 'smbtoolbar_settings_group', 'smbtoolbar_service_info' );
}
add_action( 'admin_init', 'smbtoolbar_register_settings' );
