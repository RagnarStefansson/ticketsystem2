/**
 * Created by J.Hauck on 08.06.2017.
 */
jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});