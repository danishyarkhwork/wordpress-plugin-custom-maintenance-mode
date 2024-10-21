<?php
/*
Plugin Name: Custom Maintenance Mode
Plugin URI: https://khaliddanishyar.com
Description: A custom maintenance mode plugin with a customizable message, countdown timer, and email subscription integration.
Version: 1.0
Author: Your Name
Author URI: https://khaliddanishyar.com
License: GPL2
*/

// Hook for activating the plugin
register_activation_hook(__FILE__, 'cmm_activate_plugin');
function cmm_activate_plugin()
{
    add_option('cmm_enabled', false);
}

// Hook for deactivating the plugin
register_deactivation_hook(__FILE__, 'cmm_deactivate_plugin');
function cmm_deactivate_plugin()
{
    delete_option('cmm_enabled');
}

// Enqueue styles and scripts
add_action('wp_enqueue_scripts', 'cmm_enqueue_assets');
function cmm_enqueue_assets()
{
    if (get_option('cmm_enabled') && !current_user_can('administrator')) {
        // Enqueue CSS
        wp_enqueue_style('cmm-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');

        // Enqueue JS
        wp_enqueue_script('cmm-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), null, true);

        // Get the current time and calculate the target time for the countdown
        $countdown_hours = get_option('cmm_timer');
        if ($countdown_hours) {
            $target_time = (time() + $countdown_hours * 3600) * 1000; // Convert hours to milliseconds
        } else {
            $target_time = null;
        }

        // Pass PHP values to the JavaScript file
        wp_localize_script('cmm-script', 'cmm_data', array(
            'countdown_time' => $target_time,
        ));
    }
}




add_action('template_redirect', 'cmm_check_maintenance_mode');
function cmm_check_maintenance_mode()
{
    if (get_option('cmm_enabled') && !current_user_can('manage_options')) {
        // Enqueue styles and scripts for the maintenance page only
        wp_enqueue_style('cmm-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
        wp_enqueue_script('cmm-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), null, true);

        include plugin_dir_path(__FILE__) . 'templates/maintenance.php';
        exit;
    }
}



// Admin menu to configure settings
add_action('admin_menu', 'cmm_create_settings_page');
function cmm_create_settings_page()
{
    add_menu_page(
        'Custom Maintenance Mode',
        'Maintenance Mode',
        'administrator',
        'custom-maintenance-mode',
        'cmm_settings_page_content',
        'dashicons-admin-tools'
    );
    add_action('admin_init', 'cmm_register_settings');
}

// Register plugin settings
function cmm_register_settings()
{
    register_setting('cmm_settings_group', 'cmm_enabled');
    register_setting('cmm_settings_group', 'cmm_message');
    register_setting('cmm_settings_group', 'cmm_timer');
    register_setting('cmm_settings_group', 'cmm_background_image');
    register_setting('cmm_settings_group', 'cmm_subscribe');
}

// Settings page content
function cmm_settings_page_content()
{
?>
    <div class="wrap">
        <h1>Custom Maintenance Mode Settings</h1>
        <form method="post" action="options.php" enctype="multipart/form-data">
            <?php settings_fields('cmm_settings_group'); ?>
            <?php do_settings_sections('cmm_settings_group'); ?>

            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Enable Maintenance Mode</th>
                    <td><input type="checkbox" name="cmm_enabled" value="1" <?php checked(1, get_option('cmm_enabled'), true); ?> /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Custom Message</th>
                    <td><textarea name="cmm_message" rows="5" cols="50"><?php echo esc_textarea(get_option('cmm_message')); ?></textarea></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Countdown Timer (in hours)</th>
                    <td><input type="number" name="cmm_timer" value="<?php echo esc_attr(get_option('cmm_timer')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Background Image</th>
                    <td>
                        <input type="file" name="cmm_background_image" />
                        <?php if ($bg_image = get_option('cmm_background_image')): ?>
                            <img src="<?php echo esc_url($bg_image); ?>" alt="Background Image" style="max-width: 200px;" />
                        <?php endif; ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Subscribe Form Code</th>
                    <td><textarea name="cmm_subscribe" rows="5" cols="50"><?php echo esc_textarea(get_option('cmm_subscribe')); ?></textarea></td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>
<?php
}
?>