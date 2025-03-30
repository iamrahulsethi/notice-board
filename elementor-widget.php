<?php
if (!defined('ABSPATH')) exit;

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
