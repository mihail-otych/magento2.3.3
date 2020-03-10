define([
    'ko',
    'uiComponent',
    'mage/url',
    'mage/storage',
], function (ko, Component, urlBuilder,storage) {
    'use strict';
    return Component.extend({

        defaults: {
            template: 'Samary_HelloApi/hello',
        },

        productList: ko.observableArray([]),

        getProduct: function () {
            var self = this;
            var serviceUrl = urlBuilder.build('hello-api/index/product');
            return storage.post(
                serviceUrl,
                ''
            ).done(
                function (response) {
                    if (response.success) {
                        Object.values(response.messages).forEach(val => {
                            self.productList.push(val);
                        });
                    }

                }
            ).fail(
                function (response) {
                    alert(response);
                }
            );
        },

    });
});