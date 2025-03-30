<?php
if (!defined('ABSPATH')) exit;

function nb_sanitize_text($input) {
    return sanitize_text_field($input);
}
