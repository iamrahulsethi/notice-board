jQuery(document).ready(function ($) {
    function startScrolling() {
        let container = $('.nb-notice-container');
        let items = $('.nb-notice-item');
        let totalHeight = 0;

        items.each(function () {
            totalHeight += $(this).outerHeight(true);
        });

        container.append(items.clone()); // Clone for smooth looping

        function scrollNotices() {
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

        scrollNotices();
    }

    startScrolling();
});
