/**
 * Copyright © 2015. All rights reserved.
 */

define([
    'jquery',
    'featuredOwlCarousel'
], function($){
    "use strict";

    $.widget('Zemez.featuredCarousel', {
        options: {
            margin: 0,
            nav:true,
            navText: [],
            dots: false,
            autoplay: false,
            responsive : {
                0 : {
                    items: 2
                },
                640 : {
                    items: 3
                },
                1024 : {
                    items: 4
                }
            },
            inSidebar: false,
            touchDrag: true,
            mouseDrag: false,
            sidebarOptions: {
                0 : { items: 1},
                640 : { items: 1},
                1024 : { items: 1}
            },
            prevCssClass: '',
            nextCssClass: '',
            defaultPrevCssClass: '',
            defaultNextCssClass: ''
        },

        _create: function() {
            var self = this;
            this.options.navigation = Boolean(this.options.navigation);
            this.options.pagination = Boolean(this.options.pagination);

            var onInitialized = {
                onInitialized: function () {
                    $('.owl-prev', self.element).addClass(this.options.defaultPrevCssClass+' '+this.options.prevCssClass);
                    $('.owl-next', self.element).addClass(this.options.defaultNextCssClass+' '+this.options.nextCssClass);
                    $(self.element).parent('.is-carousel').animate({ opacity: 1}, 500);
                }
            };
            if(this.options.inSidebar) {
                this.options.responsive = $.extend(this.options.responsive, this.options.sidebarOptions)
            }
            $(this.element).parent('.is-carousel').css({opacity: 0});
            this.element.owlCarousel($.extend(this.options, onInitialized));
        },
        
    });

    return $.Zemez.featuredCarousel;

});
