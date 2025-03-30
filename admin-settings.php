<?php
if (!defined('ABSPATH')) exit;

// Add Menu in WP Admin
function nb_admin_menu() {
    add_options_page('Notice Board Settings', 'Notice Board', 'manage_options', 'nb-settings', 'nb_settings_page');
}
add_action('admin_menu', 'nb_admin_menu');

// Display Settings Page
function nb_settings_page() {
    ?>
    <div class="wrap">
        <h2>Notice Board Settings</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('nb-settings-group');
            do_settings_sections('nb-settings-group');
            ?>
            <table class="form-table">
                <tr>
                    <th scope="row">Heading Background Color:</th>
                    <td><input type="text" name="nb_heading_color" value="<?php echo get_option('nb_heading_color', '#0073aa'); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row">Font Size:</th>
                    <td><input type="number" name="nb_font_size" value="<?php echo get_option('nb_font_size', '18'); ?>" class="small-text"> px</td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Register Settings
function nb_register_settings() {
    register_setting('nb-settings-group', 'nb_heading_color');
    register_setting('nb-settings-group', 'nb_font_size');
}
add_action('admin_init', 'nb_register_settings');
