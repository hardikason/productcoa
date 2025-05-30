define(['jquery'], function ($) {
    'use strict';

    $(document).ready(function () {
        $('.modal-trigger').on('click', function (e) {
            e.preventDefault();
            const modalId = $(this).data('modal');
            $('#' + modalId).show();
        });

        $('.modal-close').on('click', function () {
            const modalId = $(this).data('modal');
            $('#' + modalId).hide();
        });
    });
});
