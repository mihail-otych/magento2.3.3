/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            "theme": 'Magento_Theme/js/theme'
        }
    },
    paths: {
        "carouselInit":     'Magento_Theme/js/carouselInit',
        "blockCollapse":    'Magento_Theme/js/sidebarCollapse',
        "animateNumber":    'Magento_Theme/js/jquery.animateNumber.min',
        "owlcarousel":      'Magento_Theme/js/owl.carousel.min',
        "ytplayer":         "Magento_Theme/js/jquery.mb.YTPlayer.min",
        "parallax":         "Magento_Theme/js/jquery.rd-parallax"
    },
    shim: {
        "owlcarousel":      ["jquery"],
        "animateNumber":    ["jquery"],
        "parallax":         ["jquery"],
        "ytplayer":         ["jquery"]
    },
    deps: [
        "jquery",
        "jquery/jquery.mobile.custom",
        "mage/common",
        "mage/dataPost",
        "mage/bootstrap"
    ]
};