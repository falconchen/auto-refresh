<?php
/*
Plugin Name: Auto Refresh Plugin
Plugin URI: https://cellmean.com
Description: A simple WordPress plugin that allows users to set auto-refresh interval for a page.
Version: 1.0
Author: Falcon
Author URI: https://cellmean.com
*/

// Add a custom settings page to the admin menu
add_action('admin_menu', 'auto_refresh_settings_page');
function auto_refresh_settings_page() {
    add_options_page(
        'Auto Refresh Settings',
        'Auto Refresh',
        'manage_options',
        'auto-refresh-settings',
        'auto_refresh_settings_callback'
    );
}

// Register and add settings
add_action('admin_init', 'auto_refresh_settings');
function auto_refresh_settings() {
    register_setting('auto_refresh_options', 'auto_refresh_seconds', 'intval');
    add_settings_section(
        'auto_refresh_section',
        'Auto Refresh Settings',
        'auto_refresh_section_callback',
        'auto-refresh-settings'
    );
    add_settings_field(
        'auto_refresh_seconds',
        'Auto Refresh Interval (in seconds)',
        'auto_refresh_seconds_callback',
        'auto-refresh-settings',
        'auto_refresh_section'
    );
}

// Settings section callback function
function auto_refresh_section_callback() {
    echo 'Set the auto-refresh interval for pages.';
}

// Settings field callback function
function auto_refresh_seconds_callback() {
    $value = get_option('auto_refresh_seconds', 30);
    echo '<input type="number" name="auto_refresh_seconds" id="auto_refresh_seconds" value="' . esc_attr($value) . '" />';
}

// Settings page callback function
function auto_refresh_settings_callback() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <p>add query var <code>refresh=no</code> to url to stop auto refresh.<br/>
        Example:<code>https://www.mpweekly.com/culture/?refresh=no</code></p>
        <form action="options.php" method="post">
            <?php
            settings_fields('auto_refresh_options');
            do_settings_sections('auto-refresh-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}


// Auto-refresh meta tag
add_action('wp_head', 'auto_refresh_meta_tag');
function auto_refresh_meta_tag() {
    $auto_refresh_seconds = get_option('auto_refresh_seconds', 30);

    // Check if the request parameter contains "refresh=no"
    if (isset($_GET['refresh']) && $_GET['refresh'] === 'no') {
        return; // Do not add the meta tag for auto-refresh
    }

    echo '<meta http-equiv="refresh" content="' . esc_attr($auto_refresh_seconds) . '" />'.PHP_EOL;
}