define([
    'jquery',
    'Magento_Catalog/js/price-utils',
    'mage/template',
    'text!Pivotal_TradeIn/template/product/items.html',
    'mage/url',
    'accordion',
    'jquery-ui-modules/widget',
    'mage/validation'
], function ($,priceUtils,mageTemplate,productSearchItemTpl,urlBuilder) {
    'use strict';

    $.widget('pivotal.tradeInFormWidget', {
        options: {
            tradeInFormSteps: '.tradein-form-steps',
            tradeInForm: "#trade-in-form",
            getQuoteButton: '.get-quote-btn',
            step1AddItemButton: '.add-item-btn',
            step1productSearch:'#product_search',
            step1ProductSearchElement:".product-search-element",
            step1ProductSearchUrl:'#product_search_url',
            step1productSearchTemplate:
                '<li class="suggestItem" id="qs-option-<%- data.index %>" role="option">' +
                '<a href="javascripts:;" class="qs-product-name" data-entity_id="<%- data.entity_id %>" data-condition_id="<%- data.condition_id %>" data-condition="<%- data.condition %>">' +
                ' <%- data.name %>' +
                '</a>' +
                '</li>',
            step1ProductSuggestionWrap:'.suggestion-wrapper',
            step1ProductSuggestion: '.suggestion-wrapper .suggestions',
            step1ProductSearchError: '.product-not-found',
            step1ProductSearchResultProductName:'.qs-product-name',
            step1ItemRemove:'.remove-data-item',
            step1AddMoreBtn:'.add-more-btn',
            step1ProductCondition: '.product_conditions',
            step1EditItem:'.edit-data-item',
            step1ProductSearchItems: '[data-role="product-search-items"]'
        },

        /**
         * Create widget
         * @private
         */
        _create: function () {
            this._initContent();
        },

        /**
         * Event binding, will monitor click events.
         * @private
         */
        _initContent: function () {
            var self = this,
                dataItems = [],    
                events = {};

            // Initialize Step1 Get In Touch
            self._initializTradeInForm();

            /**
             * Step1 Get In Touch, form validation on click "Get my quote" button 
             * 
             * @param {jQuery.Event} event
             */
             events['click ' + this.options.getQuoteButton] =  function (event) {
                self._step1FormValidate($(event.target),dataItems);
            };
            
            /**
             * Step1 Get In Touch, product search by add item button
             * 
             * @param {jQuery.Event} event
             */
             events['click ' + this.options.step1AddItemButton] =  function (event) {
                self._step1ProductSeachByAddItemBtn($(event.target),dataItems);
            };

            /**
             * Step1 Get In Touch, add product item from search result
             * 
             * @param {jQuery.Event} event
             */
             events['click ' + this.options.step1ProductSearchResultProductName] =  function (event) {
                event.preventDefault();
                self._step1AddproductItem($(event.target),dataItems);
            };

            /**
             * Step1 Get In Touch, "Add more" button click event 
             * 
             * @param {jQuery.Event} event
             */
             events['click ' + this.options.step1AddMoreBtn] =  function (event) {
                event.preventDefault();
                self._step1AddMoreBtn($(event.target), dataItems);
            };

            /**
             * Step1 Get In Touch, Remove item on click close symbol 
             * 
             * @param {jQuery.Event} event
             */
            events['click ' + this.options.step1ItemRemove] =  function (event) {
                event.preventDefault();
                self._step1RemoveItem($(event.target), dataItems);
            };

            /**
             * Step1 Get In Touch, Edit item on click edit symbol 
             * 
             * @param {jQuery.Event} event
             */
             events['click ' + this.options.step1EditItem] =  function (event) {
                event.preventDefault();
                self._step1EditItem($(event.target), dataItems);
            };
            this._on(events);
        },

        /**
         * Step1 Get In Touch, tradeIn form steps accordion 
         *
         * @private
         */
         _initializTradeInForm: function () {
            this.element.find(this.options.tradeInFormSteps).accordion();
        },

        /**
         * Step1 Get In Touch, form validation  
         *
         * @param {HTMLElement} elem
         * @param {Object} dataItems
         * @private
         */
        _step1FormValidate: function (elem, dataItems) {
            var formStep = this.options.tradeInFormSteps,
                isProductExist = this._step1CheckProductExist();
            if ($(this.options.tradeInForm).valid() && isProductExist == true) {
                // $(formStep).accordion("activate",1);
                var cartItems = [];
                this.element.find(this.options.step1ProductSearchItems+' .product-search-item-data').each(function(i, item) {
                    var _cartItem = {
                        "itemId":$(this).data('itemid'),
                        "productName":$(this).data('productname'),
                        "product_id":$(this).data('productid'),
                        "item_note":$(this).find('p.item-condition').text(),
                        "item_condition_id":$(this).data('condition_id'),
                        "item_condition":$(this).data('condition'),
                    };
                    cartItems.push(_cartItem);
                });
                this._step2GetCartItems(cartItems);
            }
        },

        /**
         * Step1 Get In Touch, Check product exist or not on click get quote button  
         *
         * @private
         */
        _step1CheckProductExist: function() {
            var productItems = this.element.find(".product-search-item-data").length;
            this.element.find(this.options.step1ProductSearchError).html("");
            if (productItems == 0 ) {
                this.element.find(this.options.step1ProductSearchError).html('<span>Please add product</span>');
                return false
            } else {
                return true;
            }
        },

        /**
         * Step1 Get In Touch, product search by "Add item" button click   
         *
         * @param {HTMLElement} elem
         * @param {Object} dataItems
         * @private
         */
         _step1ProductSeachByAddItemBtn: function (elem, dataItems) {
            var self = this,
                search_text = this.element.find(this.options.step1productSearch).val(),
                url = this.element.find(this.options.step1ProductSearchUrl).val(),
                productSearchResultTemplate = this.options.step1productSearchTemplate,
                productDropdown = $('<ul class="suggestions" role="listbox"></ul>'),            
                step1ProductSuggestionWrap = this.options.step1ProductSuggestionWrap,
                step1ProductSearchError = this.options.step1ProductSearchError,
                isConditionSelected = false,
                isProductSearch = false;
                // Check product condition is selected or not
                isConditionSelected = self._step1IsSelectedProductCondition();
                // Check product search length greater than 0
                isProductSearch = self._step1IsProductSearch(search_text);
                
            if((isProductSearch == true) && (isConditionSelected == true)) {
                var condition_id = this.element.find(this.options.step1ProductCondition).val();
                var condition = this.element.find(this.options.step1ProductCondition+' option:selected').text();
                $.ajax({
                    url : url,
                    data: {
                        'search_text':search_text,
                        'condition_id': condition_id,
                        'condition':condition
                    },
                    type : 'post',
                    showLoader: true,
                    success : function(data) {
                        if (data.productCount > 0) {
                            $.each(data.products, function (index, element) {
                                var html;
                                element.index = index;
                                html = mageTemplate(productSearchResultTemplate)({
                                    data: element
                                });
                                productDropdown.append(html);
                            });
                            self.element.find(step1ProductSuggestionWrap).html(productDropdown);
                            self.element.find(step1ProductSearchError).html("");
                        } else {
                            // self.element.find(step1ProductSearchError).html('<span>Sorry, Not found any product for entered name</span>');
                            // self.element.find(step1ProductSuggestionWrap).html("");
                            self._step1AddItemWhichIsNotExist(search_text,condition_id,condition);
                        }
                    }
                });                     
            }
        },

        /**
         * Step1 Get In Touch, Check product search text length    
         *
         * @param {String} search_text
         * @private
         */
        _step1IsProductSearch: function(search_text){
            if(search_text.length > 0){
                this.element.find(this.options.step1ProductSearchError).html("");
                return true;
            } else {
                this.element.find(this.options.step1ProductSearchError).html('<span>Please enter product name</span>');
                this.element.find(this.options.step1ProductSuggestionWrap).html('');
                return false;
            }
        },

        /**
         * Step1 Get In Touch, Check condition is selected or not from the dropdown   
         *
         * @private
         */
        _step1IsSelectedProductCondition: function(){
            var condition = this.element.find(this.options.step1ProductCondition).val();
            if(condition !=="") {
                this.element.find(this.options.step1ProductCondition).next(".condition-error").html("");
                return true;
            } else {
                this.element.find(this.options.step1ProductCondition).next(".condition-error").html('<span>Please select any condition </span>');
                return false;
            }
        },

        /**
         * Step1 Get In Touch, Add product item from search result 
         *
         * @param {HTMLElement} elem
         * @param {Object} dataItems
         * @private
         */
         _step1AddproductItem: function(elem) {
            this._step1SetProductItemTemplate({
                productId: elem.data('entity_id'),
                productName: elem.text(),
                condition_id: elem.data('condition_id'),
                condition: elem.data('condition'),
                note:null,
            });
            this.element.find(this.options.step1ProductSuggestion+" li").remove();
        },

        /**
         * Step1 Get In Touch, Add product item which is not exist on store
         *
         * @param {String} search_text
         * @param {String} condition_id
         * @param {String} condition
         * @private
         */
        _step1AddItemWhichIsNotExist: function(search_text,condition_id,condition) {
            this._step1SetProductItemTemplate({
                productId: "",
                productName: search_text,
                condition_id: condition_id,
                condition: $.trim(condition),
                note:"We currently are unable to quote online for this store, however a member of our team will be touch in with a quote as soon as possible"
            });
        },

        /**
         * Step1 Get In Touch, set template for add items
         *
         * @param {Object} data
         * @private
         */
         _step1SetProductItemTemplate: function (data) {
            var productSearchItemTemplateHtml = mageTemplate(productSearchItemTpl)({
                data: data
            });
            // Step1 Get In Touch, When item edit 
            var itemId = this.element.find(this.options.step1AddItemButton).attr('data-itemId');
            if(itemId) {
                this.element.find(this.options.step1ProductSearchItems+' .product-search-item-data').each(function(i, item) {
                    if($(this).attr('data-itemId') == itemId ) {
                        $(this).remove();
                    }
                });
            }

            this.element.find(this.options.step1ProductSearchItems).append(productSearchItemTemplateHtml);
            this.element.find(this.options.step1productSearch).val('');
            // Hide search element
            this.element.find(this.options.step1ProductSearchElement).hide();
            // Show Add More button
            this.element.find(this.options.step1AddMoreBtn).show();

            // Add item id to each product
            this.element.find(this.options.step1ProductSearchItems+' .product-search-item-data').each(function(i, item) {
                $(this).attr('data-itemId',i);
            });
            this.element.find(this.options.step1AddItemButton).removeAttr('data-itemId');
        },

        /**
         * Step1 Get In Touch, "Add more button" click event 
         *
         * @param {HTMLElement} elem
         * @param {Object} dataItems
         * @private
         */
         _step1AddMoreBtn: function(elem, dataItems) {
            this.element.find(this.options.step1ProductSearchElement).show();
            this.element.find(this.options.step1AddMoreBtn).hide();
            this.element.find(this.options.step1ProductCondition).prop("selectedIndex", 0);
        },

        /**
         * Step1 Get In Touch, Remove item from items on click close symbol 
         *
         * @param {Object} elem
         * @param {Object} dataItems
         * @private
         */
         _step1RemoveItem: function (elem, dataItems) {
            elem.closest(".product-search-item-data").remove();

            /**
             * Check any items added or not
             * If product items are not added then hide Add more button
             * and show search input
             */
            var productItems = this.element.find(".product-search-item-data").length;
            if(productItems == 0) {
                this.element.find(this.options.step1ProductSearchElement).show();
                this.element.find(this.options.step1AddMoreBtn).hide();
                this.element.find(this.options.step1ProductCondition).prop("selectedIndex", 0);
            }
        },

        /**
         * Step1 Get In Touch, Edit item from items on click close symbol 
         *
         * @param {Object} elem
         * @param {Object} dataItems
         * @private
         */
         _step1EditItem: function (elem, dataItems) {
             var condition_id = elem.closest(".product-search-item-data").find('span.item-condition').data('condition_id'),
             productName = elem.closest(".product-search-item-data").find('.item-title').text(),
             itemId = elem.closest(".product-search-item-data").data('itemId');
             console.log(itemId);
             
            this.element.find(this.options.step1ProductCondition).val(condition_id);
            this.element.find(this.options.step1productSearch).val(productName);
            this.element.find(this.options.step1ProductSearchElement).show();
            this.element.find(this.options.step1AddMoreBtn).hide();
            this.element.find(this.options.step1AddItemButton).attr('data-itemId',itemId);
            // elem.closest(".product-search-item-data").remove();
            
            // console.log(productName);
            // console.log(condition_id);
            /**
             * Check any items added or not
             * If product items are not added then hide Add more button
             * and show search input
             */
            // var productItems = this.element.find(".product-search-item-data").length;
            // if(productItems == 0) {
            //     this.element.find(this.options.step1ProductSearchElement).show();
            //     this.element.find(this.options.step1AddMoreBtn).hide();
            //     this.element.find(this.options.step1ProductCondition).prop("selectedIndex", 0);
            // }
        },

        /**
         * Step2 Trade-In Quote, Get cart items with condition price and product image too 
         *
         * @param {Object} cartItems
         * @private
         */
        _step2GetCartItems: function (cartItems) {
            console.log(cartItems);
            var tradeInCartUrl = urlBuilder.build('trade-in/index/tradeincart');
            console.log(tradeInCartUrl);
            // $.ajax({
            //     url : url,
            //     data: {
            //         'cartItems':cartItems,
            //     },
            //     type : 'post',
            //     showLoader: true,
            //     success : function(data) {
            //         if (data.productCount > 0) {
            //             $.each(data.products, function (index, element) {
            //                 var html;
            //                 element.index = index;
            //                 html = mageTemplate(productSearchResultTemplate)({
            //                     data: element
            //                 });
            //                 productDropdown.append(html);
            //             });
            //             self.element.find(step1ProductSuggestionWrap).html(productDropdown);
            //             self.element.find(step1ProductSearchError).html("");
            //         } else {
            //             // self.element.find(step1ProductSearchError).html('<span>Sorry, Not found any product for entered name</span>');
            //             // self.element.find(step1ProductSuggestionWrap).html("");
            //             self._step1AddItemWhichIsNotExist(search_text,condition_id,condition);
            //         }
            //     }
            // });
        },
    });
    return $.pivotal.tradeInFormWidget;
});_