jQuery(document).ready(function ($) {
    let container = $('.nb-notice-container');
    let items = $('.nb-notice-item');
    let totalHeight = 0;
    let scrolling = true;

    items.each(function () {
        totalHeight += $(this).outerHeight(true);
    });

    container.append(items.clone()); // Clone for smooth looping

    function scrollNotices() {
        if (scrolling) {
            container.animate(
                { scrollTop: totalHeight },
                3000,
                'linear',
                function () {
                    container.scrollTop(0);
                    scrollNotices();
                }
            );
        }
    }

    // Start scrolling
    scrollNotices();

    // Stop scrolling on hover
    container.hover(
        function () {
            scrolling = false;
            container.stop();
        },
        function () {
            scrolling = true;
            scrollNotices();
        }
    );
});
