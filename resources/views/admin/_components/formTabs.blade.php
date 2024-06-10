<script>
    $('.nav-tabs .nav-item').on('shown.bs.tab', function (e) {
        const targetId = $(e.target).attr('href');
        $(targetId).addClass('active in show').siblings().removeClass('active in show');
        updateGlider();
    });

    $(window).resize(function() {
        updateGlider();
    });

    function updateGlider() {
        const activeTab = $('.nav-tabs .nav-link.active');
        const parentElement = activeTab.parent();

        const glider = $('.glider');
        const offset = activeTab.position().left - 12;
        const width = parentElement.outerWidth();

        glider.css({
            'transform': 'translateX(' + offset + 'px)',
            'width': width + 'px'
        });
    }
</script>
