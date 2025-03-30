<?php
/*
Plugin Name: Notice Board
Description: A WordPress plugin for displaying notices with vertical scrolling, categories, and Elementor compatibility.
Version: 1.2
Author: Flick Idea Private Limited
*/

// Prevent direct access
if (!defined('ABSPATH')) exit;

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
    echo '<div class="nb-notice-board">';
    echo '<div class="nb-header">Notice Board</div>';
    echo '<div class="nb-notice-container">';
    while ($query->have_posts()) {
        $query->the_post();
        $categories = get_the_terms(get_the_ID(), 'nb_notice_category');
        $category_name = !empty($categories) ? esc_html($categories[0]->name) : 'Uncategorized';
        echo '<div class="nb-notice-item">';
        echo '<span class="nb-category"><i class="dashicons dashicons-category"></i> ' . $category_name . '</span>';
        echo '<h3 class="nb-title"><a href="' . get_permalink() . '" style="text-decoration: none; color: inherit;">' . get_the_title() . '</a></h3>';
        echo '<span class="nb-date"><i class="dashicons dashicons-calendar"></i> ' . get_the_date() . ' <i class="dashicons dashicons-clock"></i> ' . get_the_time() . '</span>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('notice_board', 'nb_notice_board_shortcode');

// Enqueue remote styles and scripts via CDN
function nb_enqueue_scripts() {
    wp_enqueue_style(
        'nb-style',
        'https://cdn.jsdelivr.net/gh/iamrahulsethi/notice-board/assets/style.css',
        [],
        '1.2',
        'all'
    );

    wp_enqueue_script(
        'nb-script',
        'https://cdn.jsdelivr.net/gh/iamrahulsethi/notice-board/assets/script.js',
        ['jquery'],
        '1.2',
        true
    );
}
add_action('wp_enqueue_scripts', 'nb_enqueue_scripts');

// Register Elementor widget
function nb_register_elementor_widget() {
    if (!did_action('elementor/loaded')) {
        return;
    }
    require_once(__DIR__ . '/elementor-widget.php');
    \Elementor\Plugin::instance()->widgets_manager->register(new Notice_Board_Widget());
}
add_action('elementor/widgets/register', 'nb_register_elementor_widget');

// Elementor Widget Class
if (class_exists('\Elementor\Widget_Base')) {
    class Notice_Board_Widget extends \Elementor\Widget_Base {
        public function get_name() {
            return 'notice_board';
        }
        public function get_title() {
            return __('Notice Board', 'notice-board');
        }
        public function get_icon() {
            return 'eicon-post-list';
        }
        public function get_categories() {
            return ['general'];
        }
        protected function render() {
            echo do_shortcode('[notice_board]');
        }
    }
}
