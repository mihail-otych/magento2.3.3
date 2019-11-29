define([
    'jquery'
], function ($) {
    'use strict';

    $.widget('Zemez.featuredProductGallery', {

        options: {},

        _create: function() {
            var element = $(this.element),
                main_href = element.closest('a').attr('href');
            element.closest('a').contents().unwrap();
            element.on('fotorama:ready', function (e, fotorama) {
                var fotoramaWrap = element.find('.fotorama__wrap');
                if (!fotoramaWrap.children('.product-item-photo-fix').length) {
                    fotoramaWrap.append("<a class='product-item-photo product-item-photo-fix' href='"+ main_href +"'></a>");
                }
            });
        },
    });

    return $.Zemez.featuredProductGallery;
});