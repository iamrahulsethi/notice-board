<?php
if (!defined('ABSPATH')) {
    exit;
}

$notice_id = get_the_ID();
$title = get_the_title();
$permalink = get_permalink();
$date = get_the_date();
$time = get_the_time();
$categories = get_the_terms($notice_id, 'nb_notice_category');
$category_name = !empty($categories) ? esc_html($categories[0]->name) : 'Uncategorized';
?>

<div class="nb-notice-item">
    <a href="<?php echo esc_url($permalink); ?>" class="nb-notice-link">
        <div class="nb-notice-content">
            <span class="nb-category"><i class="dashicons dashicons-category"></i> <?php echo $category_name; ?></span>
            <h3 class="nb-title"><?php echo esc_html($title); ?></h3>
            <span class="nb-date">
                <i class="dashicons dashicons-calendar"></i> <?php echo esc_html($date); ?>
                <i class="dashicons dashicons-clock"></i> <?php echo esc_html($time); ?>
            </span>
        </div>
    </a>
</div>
