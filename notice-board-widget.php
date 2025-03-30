<?php
/*
Plugin Name: Notice Board Widget
Description: A WordPress plugin for displaying notices with vertical scrolling, categories, and Elementor compatibility.
Version: 1.2
Author: Your Name
*/

if (!defined('ABSPATH')) exit; // Prevent direct access

// Register custom post type
function nb_register_notice_post_type() {
    register_post_type('nb_notice', [
        'labels'      => [
            'name'          => __('Notices', 'notice-board'),
            'singular_name' => __('Notice', 'notice-board')
        ],
        'public'      => true,
        'has_archive' => false,
        'supports'    => ['title', 'editor', 'custom-fields'],
        'menu_icon'   => 'dashicons-megaphone',
    ]);
}
add_action('init', 'nb_register_notice_post_type');

// Register taxonomy for categories
function nb_register_notice_category() {
    register_taxonomy('nb_notice_category', 'nb_notice', [
        'label'        => __('Categories', 'notice-board'),
        'hierarchical' => true,
        'show_admin_column' => true,
    ]);
}
add_action('init', 'nb_register_notice_category');

// Shortcode for notice board
function nb_notice_board_shortcode() {
    ob_start();
    $query = new WP_Query(['post_type' => 'nb_notice', 'posts_per_page' => 10]);
    echo '<div class="nb-notice-board" style="max-width: 400px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); background: #ffffff; overflow: hidden;">';
    echo '<div class="nb-header" style="background: #0073aa; color: #ffffff; text-align: center; padding: 10px; font-size: 20px; font-weight: bold;">Notice Board</div>';
    echo '<div class="nb-notice-container" style="height: 300px; overflow: hidden; position: relative;">';
    while ($query->have_posts()) {
        $query->the_post();
        $categories = get_the_terms(get_the_ID(), 'nb_notice_category');
        $category_name = !empty($categories) ? esc_html($categories[0]->name) : 'Uncategorized';
        echo '<div class="nb-notice-item" style="background: #f9f9f9; margin: 10px; padding: 15px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); transition: background 0.3s ease;">';
        echo '<span class="nb-category" style="color: #0073aa; font-size: 14px; display: flex; align-items: center;"><i class="dashicons dashicons-category"></i> ' . $category_name . '</span>';
        echo '<h3 class="nb-title" style="font-size: 18px; font-weight: bold; margin-top: 5px;"><a href="' . get_permalink() . '" style="text-decoration: none; color: black;">' . get_the_title() . '</a></h3>';
        echo '<span class="nb-date" style="font-size: 12px; color: #555; display: flex; align-items: center;"><i class="dashicons dashicons-calendar"></i> ' . get_the_date() . ' <i class="dashicons dashicons-clock"></i> ' . get_the_time() . '</span>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('notice_board', 'nb_notice_board_shortcode');

// Register Elementor Widget
function nb_register_elementor_widget() {
    if (!did_action('elementor/loaded')) return;
    require_once(__DIR__ . '/elementor-widget.php');
    \Elementor\Plugin::instance()->widgets_manager->register(new Notice_Board_Widget());
}
add_action('elementor/widgets/register', 'nb_register_elementor_widget');
