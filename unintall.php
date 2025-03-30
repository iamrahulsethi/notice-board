<?php
if (!defined('WP_UNINSTALL_PLUGIN')) exit;

// Remove custom post type data
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_type = 'nb_notice'");
$wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE post_id NOT IN (SELECT ID FROM {$wpdb->posts})");
$wpdb->query("DELETE FROM {$wpdb->term_relationships} WHERE object_id NOT IN (SELECT ID FROM {$wpdb->posts})");
