define([
    'jquery',
    'mage/template',
    'text!Pivotal_TradeIn/template/product/items.html',
    'text!Pivotal_TradeIn/template/trade-in-cart/items.html',
    'mage/url',
    'Magento_Catalog/js/price-utils',
    'jquery/jquery.cookie',
    'accordion',
    'jquery-ui-modules/widget',
    'mage/validation'
], function ($,
    mageTemplate,
    step1ProductSearchTemplate,
    tradeInCartItemsTemplate,
    urlBuilder,
    priceUtils
) {
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
            step1ProductSearchItems: '[data-role="product-search-items"]',
            step2EditItem:'.trade-cart-edit-data-item',
            step2ItemRemove:'.trade-cart-remove-data-item',
            step2AddAnotherItem:'.trade-in-quote-add-another-item',
            step2GrandTotal:'.trade-in-quote-grandtotal',
            step2ItemQty:'.input-group-item-qty',
            step2IncreaseQty:'.item-qty-increase',
            step2DecreaseQty:'.item-qty-decrease',
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
                events = {};

            // Initialize Step1 Get In Touch
            self._initializTradeInForm();

            /**
             * Step1 Get In Touch, form validation on click "Get my quote" button 
             * 
             * @param {jQuery.Event} event
             */
            events['click ' + this.options.getQuoteButton] =  function (event) {
                self._step1FormValidate($(event.target));
            };
            
            /**
             * Step1 Get In Touch, product search by add item button
             * 
             * @param {jQuery.Event} event
             */
            events['click ' + this.options.step1AddItemButton] =  function (event) {
                self._step1ProductSeachByAddItemBtn($(event.target));
            };

            /**
             * Step1 Get In Touch, add product item from search result
             * 
             * @param {jQuery.Event} event
             */
            events['click ' + this.options.step1ProductSearchResultProductName] =  function (event) {
                event.preventDefault();
                self._step1AddproductItem($(event.target));
            };

            /**
             * Step1 Get In Touch, "Add more" button click event 
             * 
             * @param {jQuery.Event} event
             */
            events['click ' + this.options.step1AddMoreBtn] =  function (event) {
                event.preventDefault();
                self._step1AddMoreBtn($(event.target));
            };

            /**
             * Step1 Get In Touch, Remove item on click close symbol 
             * 
             * @param {jQuery.Event} event
             */
            events['click ' + this.options.step1ItemRemove] =  function (event) {
                event.preventDefault();
                self._step1RemoveItem($(event.target));
            };

            /**
             * Step1 Get In Touch, Edit item on click edit symbol 
             * 
             * @param {jQuery.Event} event
             */
            events['click ' + this.options.step1EditItem] =  function (event) {
                event.preventDefault();
                self._step1EditItem($(event.target));
            };

            /**
             * Step2 Get quote, Remove item on click delete action 
             * 
             * @param {jQuery.Event} event
             */
            events['click ' + this.options.step2ItemRemove] =  function (event) {
                event.preventDefault();
                self._step2RemoveItem($(event.target));
            };

            /**
             * Step2 Get quote, Edit item on click edit symbol 
             * 
             * @param {jQuery.Event} event
             */
            events['click ' + this.options.step2EditItem] =  function (event) {
                event.preventDefault();
                self._step2EditItem($(event.target));
            };

            /**
             * Step2 Get quote, On click Add another item, open step1 and scroll to search input 
             * 
             * @param {jQuery.Event} event
             */
            events['click ' + this.options.step2AddAnotherItem] =  function (event) {
                event.preventDefault();
                self._step2AddAnotherItem($(event.target));
            };

            /**
             * Step2 Get quote, qty increment
             *
             * @param {jQuery.Event} event
             */
            events['click ' + this.options.step2IncreaseQty] =  function (event) {
                event.preventDefault();
                self._step2IncreaseQty($(event.target));
            };

            /**
             * Step2 Get quote, qty decrement
             *
             * @param {jQuery.Event} event
             */
            events['click ' + this.options.step2DecreaseQty] =  function (event) {
                event.preventDefault();
                self._step2DecreaseQty($(event.target));
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
            $(this.options.tradeInFormSteps).accordion("activate",0);
            // Check data are store in cookie
            var tradeInFormData = $.cookie('tradeInFormData');
            if (tradeInFormData != null) {
                tradeInFormData = JSON.parse(tradeInFormData);
                // Initialize form data for step1
                this._step1InitializeFormData(tradeInFormData);
                // Initialize items data for step1
                this._step1InitializeItemsData(tradeInFormData.itemsData);
                // Show item search section if Item not exist in cookie
                this._step1ShowItemSearchSection();
            }
        },

        /**
         * Step1 Get In Touch, Get form data from the cookie
         *
         * @param {Object} tradeInFormData
         * @private
         */
        _step1InitializeFormData: function (tradeInFormData) {
            this.element.find("#trade-in-firstname").val(tradeInFormData.firstname);
            this.element.find("#trade-in-lastname").val(tradeInFormData.lastname);
            this.element.find("#trade-in-email").val(tradeInFormData.email);
            this.element.find("#trade-in-phonenumber").val(tradeInFormData.phonenumber);
        },

        /**
         * Step1 Get In Touch, Get items data from the cookie
         *
         * @param {Object} tradeInItemsData
         * @private
         */
        _step1InitializeItemsData: function (tradeInItemsData) {
            $("#product_search").val('');
            // Hide search element
            $(".product-search-element").hide();
            // Show Add More button
            $(".add-more-btn").show();

            $.each(tradeInItemsData.cartItemsData, function (index, element) {
                var html;
                html = mageTemplate(step1ProductSearchTemplate)({
                    data: {
                        product_id: element.product_id,
                        productName: element.productName,
                        condition_id: element.item_condition_id,
                        condition: $.trim(element.item_condition),
                        item_qty: parseInt(element.item_qty),
                        note:element.item_note,
                        itemid:element.itemId
                    }
                });
                $('[data-role="product-search-items"]').append(html);
            });
        },

        /**
         * Check any items added or not
         * If product items are not added,
         * Show item search section
         * Hide Add more button
         */
         _step1ShowItemSearchSection : function() {
            var productItems = this.element.find(".product-search-item-data").length;
            if(productItems == 0) {
                this.element.find(this.options.step1ProductSearchElement).show();
                this.element.find(this.options.step1AddMoreBtn).hide();
                this.element.find(this.options.step1ProductCondition).prop("selectedIndex", 0);
            }
        },

        /**
         * Hide item search section
         * Show Add more button
         */
        _step1HideItemSearchSection : function() {
            this.element.find(this.options.step1productSearch).val('');
            // Hide search element
            this.element.find(this.options.step1ProductSearchElement).hide();
            // Show Add More button
            this.element.find(this.options.step1AddMoreBtn).show();
        },

        /**
         * Step1 Get In Touch, form validation  
         *
         * @param {HTMLElement} elem
         * @private
         */
        _step1FormValidate: function (elem) {
            var formStep = this.options.tradeInFormSteps,
                isProductExist = this._step1CheckProductExist();
            if ($(this.options.tradeInForm).valid() && isProductExist == true) {
                $(formStep).accordion("activate",1);
                var cartItems = [];
                this.element.find(this.options.step1ProductSearchItems+' .product-search-item-data').each(function(i, item) {
                    var _cartItem = {
                        "itemId":$(this).attr('data-itemid'),
                        "productName":$(this).attr('data-productname'),
                        "product_id":$(this).attr('data-product_id'),
                        "item_note":$(this).find('p.item-condition').text(),
                        "item_condition_id":$(this).attr('data-condition_id'),
                        "item_condition":$(this).attr('data-condition'),
                        "item_qty":$(this).attr('data-item_qty'),
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
         * @private
         */
        _step1ProductSeachByAddItemBtn: function (elem) {
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
                            self._step1AddItemNotExistInStore(search_text,condition_id,condition);
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
         * @private
         */
        _step1AddproductItem: function(elem) {
            this._step1SetProductItemTemplate({
                product_id: elem.data('entity_id'),
                productName: elem.text(),
                condition_id: elem.data('condition_id'),
                condition: elem.data('condition'),
                item_qty: 1,
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
        _step1AddItemNotExistInStore: function(search_text,condition_id,condition) {
            this._step1SetProductItemTemplate({
                product_id: "",
                productName: search_text,
                condition_id: condition_id,
                condition: $.trim(condition),
                item_qty: 1,
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
            var productSearchItemTemplateHtml = mageTemplate(step1ProductSearchTemplate)({
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

            // Hide Search Item section
            this._step1HideItemSearchSection();

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
         * @private
         */
        _step1AddMoreBtn: function(elem) {
            this.element.find(this.options.step1ProductSearchElement).show();
            this.element.find(this.options.step1AddMoreBtn).hide();
            this.element.find(this.options.step1ProductCondition).prop("selectedIndex", 0);
        },

        /**
         * Step1 Get In Touch, Remove item from items on click close symbol 
         *
         * @param {Object} elem
         * @private
         */
        _step1RemoveItem: function (elem) {
            // Check data are store in cookie
            var tradeInFormData = $.cookie('tradeInFormData');
            if (tradeInFormData != null) {
                var itemId = elem.closest(".product-search-item-data").attr('data-itemid');
                tradeInFormData = JSON.parse(tradeInFormData);
                // Remove trade item from cookie
                this._removeItemFromCookie(itemId, tradeInFormData);
            }
            elem.closest(".product-search-item-data").remove();

            // Show item search section
            this._step1ShowItemSearchSection();
        },

        /**
         * Step1 Get In Touch, Edit item from items on click close symbol 
         *
         * @param {Object} elem
         * @private
         */
         _step1EditItem: function (elem) {
            var condition_id = elem.closest(".product-search-item-data").find('span.item-condition').data('condition_id'),
            productName = elem.closest(".product-search-item-data").find('.item-title').text(),
            itemId = elem.closest(".product-search-item-data").data('itemid');
             
            this.element.find(this.options.step1ProductCondition).val(condition_id);
            this.element.find(this.options.step1productSearch).val(productName);
            this.element.find(this.options.step1ProductSearchElement).show();
            this.element.find(this.options.step1AddMoreBtn).hide();
            this.element.find(this.options.step1AddItemButton).attr('data-itemid',itemId);
        },

        /**
         * Step2 Trade-In Get Quote, On click Add another item open step1
         *
         * @private
         */
        _step1FocusProductSearch: function(){
            // Activate first step
            this.element.find(this.options.tradeInFormSteps).accordion("activate",0);
            // Scroll to product search input
            $('html, body').animate({
                scrollTop: this.element.find(this.options.step1ProductSearchElement).offset().top - 25
            }, 2000, function() {
                $("#product_search").focus();
            });
        },

        /**
         * Step2 Trade-In Get Quote, Get cart items with condition price and product image too 
         *
         * @param {Object} cartItems
         * @private
         */
        _step2GetCartItems: function (cartItems) {
            var tradeInCartUrl = urlBuilder.build('trade-in/index/tradeincart'),
                self = this;
            
            $.ajax({
                url : tradeInCartUrl,
                data: {
                    'cartItems':cartItems,
                },
                type : 'post',
                showLoader: true,
                success : function(data) {
                    var tradeInCartItems = mageTemplate(tradeInCartItemsTemplate)({
                        data: data
                    });
                    $('.trade-in-quote-items').html(tradeInCartItems);
                    var tradeInFormData = {
                        "firstname": $("#trade-in-firstname").val(),
                        "lastname": $("#trade-in-lastname").val(),
                        "email": $("#trade-in-email").val(),
                        "phonenumber": $("#trade-in-phonenumber").val(),
                        "itemsData":data
                    }
                    self._saveItemsDataInCookie(tradeInFormData);
                }
            });
        },

        /**
         * Save items data in cookie
         *
         * @param {Object} tradeInFormData
         * @private
         */
        _saveItemsDataInCookie : function (tradeInFormData) {
            var date = new Date();
            var minutes = 5;
            date.setTime(date.getTime() + (minutes * 60 * 1000));
            $.cookie('tradeInFormData', JSON.stringify(tradeInFormData), {expires: date}); // Set Cookie Expiry Time
        },

        /**
         * Remove item from cookie
         *
         * @param {initeger} itemId
         * @param {Object} tradeInFormData
         * @private
         */
        _removeItemFromCookie : function (itemId, tradeInFormData) {
            itemId = String(itemId);
            // Remove item from tradeInFormData cart items object
            var index = tradeInFormData.itemsData.cartItemsData.findIndex(item => item.itemId === itemId);
            if (index !== -1) {
                tradeInFormData.itemsData.cartItemsData.splice(index,1);
            }
            this._saveItemsDataInCookie(tradeInFormData);
        },

        /**
         * Step2 Trade-In Get Quote, Remove item from Get quote step on click delete action 
         *
         * @param {Object} elem
         * @private
         */
        _step2RemoveItem: function (elem) {
            var item_id = elem.closest(".item-actions").data("itemid");
            // Check data are store in cookie
            var tradeInFormData = $.cookie('tradeInFormData');
            if (tradeInFormData != null) {
                tradeInFormData = JSON.parse(tradeInFormData);
                // Remove trade item from cookie
                this._removeItemFromCookie(item_id, tradeInFormData);
            }
            
            // Remove item from table in trade quote step
            elem.closest("tbody").find('tr').each(function(){
                var current_itemId = $(this).data("itemid");
                if(current_itemId == item_id) {
                    $(this).remove();
                }
            });

            // Item remove from step1 search product section
            this.element.find(this.options.step1ProductSearchItems+' .product-search-item-data').each(function(i, item) {
                var current_itemId = $(this).data('itemid');
                if(current_itemId == item_id) {
                    $(this).remove();
                }
            });
            
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
                // Activate first step if all items removed
                this.element.find(this.options.tradeInFormSteps).accordion("activate",0);
            }
            // Count grandTotal
            this._step2CountGrandTotal();
        },

        /**
         * Step2 Trade-In Get Quote, On click Add another item open step1
         *
         * @param {Object} elem
         * @private
         */
        _step2AddAnotherItem: function (elem) {
            this.element.find(this.options.step1ProductSearchElement).show();
            this.element.find(this.options.step1AddMoreBtn).hide();
            this.element.find(this.options.step1ProductCondition).prop("selectedIndex", 0);
            this._step1FocusProductSearch();
        },

        /**
         * Step2 Trade-In Get Quote, count grandtotal
         *
         * @private
         */
        _step2CountGrandTotal: function () {
            var subtotalwithoutcurrencysymbol = null,
                grandTotal = 0;
            this.element.find(".trade-in-cart-table tbody tr.item-info").each(function(){
                subtotalwithoutcurrencysymbol = $(this).attr("data-subtotalwithoutcurrencysymbol");
                grandTotal = grandTotal + parseFloat(subtotalwithoutcurrencysymbol);
            });

            // grandTotal = this._getFormattedPrice(grandTotal);
            this.element.find(this.options.step2GrandTotal).text(this._getFormattedPrice(grandTotal));
            // Check data are store in cookie
            var tradeInFormData = $.cookie('tradeInFormData');
            if (tradeInFormData != null) {
                tradeInFormData = JSON.parse(tradeInFormData);
                tradeInFormData.grandTotal = grandTotal;
                tradeInFormData.grandTotalWithCurrency = this._getFormattedPrice(grandTotal);
                this._saveItemsDataInCookie(tradeInFormData);
            }
        },

        /**
         * Step2 Trade-In Get Quote, Edit item from items on click edit symbol
         *
         * @param {Object} elem
         * @private
         */
        _step2EditItem: function (elem) {
            var condition_id = elem.closest(".item-actions").data('item_condition_id'),
            productName = elem.closest(".item-actions").data('productname'),
            itemId = elem.closest(".item-actions").data('itemid');
            
            this.element.find(this.options.step1ProductCondition).val(condition_id);
            this.element.find(this.options.step1productSearch).val(productName);
            this.element.find(this.options.step1ProductSearchElement).show();
            this.element.find(this.options.step1AddMoreBtn).hide();
            this.element.find(this.options.step1AddItemButton).attr('data-itemid',itemId);

            this._step1FocusProductSearch();
        },

        /**
         * Step2 Trade-In Get Quote, item qty increment
         *
         * @param {Object} elem
         * @private
         */
        _step2IncreaseQty: function (elem) {
            var itemQty = elem.closest(".input-group-qty").find(this.options.step2ItemQty).val(),
                maxQty = elem.closest(".input-group-qty").find(this.options.step2ItemQty).attr('maxlength'),
                product_tradein_price = elem.closest("tr.item-info").data('product_tradein_price');

            maxQty = parseInt(maxQty);

            if (itemQty < maxQty) {
                itemQty++;
                elem.closest(".input-group-qty").find(this.options.step2ItemQty).val(itemQty);
                if(product_tradein_price > 0) {
                    this._step2UpdateItemOnQtyChanged(elem, product_tradein_price,itemQty);
                }
                // Update Item qty in cookie
                var tradeInFormData = $.cookie('tradeInFormData');
                if (tradeInFormData != null) {
                    tradeInFormData = JSON.parse(tradeInFormData);
                    var itemid = elem.closest("tr.item-info").attr('data-itemid');
                    this._step2UpdateItemQtyInCookie(
                        tradeInFormData,
                        itemid,
                        itemQty
                    );
                }
            }
        },

        /**
         * Step2 Trade-In Get Quote, item qty decrement
         *
         * @param {Object} elem
         * @private
         */
        _step2DecreaseQty: function (elem) {
            var itemQty = elem.closest(".input-group-qty").find(this.options.step2ItemQty).val(),
                product_tradein_price = elem.closest("tr.item-info").data('product_tradein_price');

            if (itemQty > 1) {
                itemQty--;
                elem.closest(".input-group-qty").find(this.options.step2ItemQty).val(itemQty);
                if(product_tradein_price > 0) {
                    this._step2UpdateItemOnQtyChanged(elem, product_tradein_price,itemQty);
                }
                // Update Item qty in cookie
                var tradeInFormData = $.cookie('tradeInFormData');
                if (tradeInFormData != null) {
                    tradeInFormData = JSON.parse(tradeInFormData);
                    var itemid = elem.closest("tr.item-info").attr('data-itemid');
                    this._step2UpdateItemQtyInCookie(
                        tradeInFormData,
                        itemid,
                        itemQty
                    );
                }
            }
        },

        /**
         * Step2 Trade-In Get Quote
         * If product is exist in store
         * Item subtotal and grandtotal update
         * When item qty increment or decrement
         *
         * @param {Object} elem
         * @param {Float} product_tradein_price
         * @param {Integer} itemQty
         * @private
         */
        _step2UpdateItemOnQtyChanged: function (elem, product_tradein_price, itemQty) {
            var itemid = elem.closest("tr.item-info").attr('data-itemid');
            var itemSubtotal = parseFloat(product_tradein_price) * parseInt(itemQty);
            // Convert into 4 digit decimal number
            itemSubtotal = itemSubtotal.toFixed(4);
            // Get subtotal with currency symbol
            var itemSubtotalWithCurrency = this._getFormattedPrice(itemSubtotal);
            var subtotalWithoutCurrencySymbol = itemSubtotal;

            // Update item subtotal
            elem.closest("tbody").find('tr').each(function(){
                var current_itemId = $(this).data("itemid");
                if(current_itemId == itemid) {
                    $(this).attr({
                        "data-qty": parseInt(itemQty),
                        "data-subtotal": itemSubtotalWithCurrency,
                        "data-subtotalWithoutCurrencySymbol": subtotalWithoutCurrencySymbol,
                    });
                    if ($(this).hasClass('item-info')) {
                        $(this).find('.item-subtotal').text(itemSubtotalWithCurrency);
                    }
                }
            });

            // Update grandtotal
            this._step2CountGrandTotal();
            // Check data are store in cookie
            var tradeInFormData = $.cookie('tradeInFormData');
            if (tradeInFormData != null) {
                tradeInFormData = JSON.parse(tradeInFormData);
                // Update item for existing product
                this._step2UpdateItemSubTotalInCookie(
                    tradeInFormData,
                    itemid,
                    itemSubtotalWithCurrency,
                    subtotalWithoutCurrencySymbol
                );
            }
        },

        /**
         * Update Item Qty and Subtotal
         *
         * @param {Object} tradeInFormData
         * @param {String} itemId
         * @param {String} itemSubtotalWithCurrency
         * @param {Float} subtotalWithoutCurrencySymbol
         * @private
         */
        _step2UpdateItemSubTotalInCookie: function (
            tradeInFormData,
            itemId,
            itemSubtotalWithCurrency,
            subtotalWithoutCurrencySymbol
        ) {
            var objIndex = null;
            //Find index of specific object using findIndex method.
            objIndex = tradeInFormData.itemsData.cartItemsData.findIndex((obj => obj.itemId == itemId));

            tradeInFormData.itemsData.cartItemsData[objIndex].itemId = itemId;
            tradeInFormData.itemsData.cartItemsData[objIndex].subtotal = itemSubtotalWithCurrency;
            tradeInFormData.itemsData.cartItemsData[objIndex].subtotalWithoutCurrencySymbol = subtotalWithoutCurrencySymbol;
            this._saveItemsDataInCookie(tradeInFormData);
        },

        /**
         * Update Item Qty in stored cookie data
         *
         * @param {Object} tradeInFormData
         * @param {String} itemId
         * @param {Number} itemQty
         * @private
         */
        _step2UpdateItemQtyInCookie: function (
            tradeInFormData,
            itemId,
            itemQty
        ) {
            var objIndex = null;
            //Find index of specific object using findIndex method.
            objIndex = tradeInFormData.itemsData.cartItemsData.findIndex((obj => obj.itemId == itemId));
            // Update item qty in cookie data
            tradeInFormData.itemsData.cartItemsData[objIndex].itemId = itemId;
            tradeInFormData.itemsData.cartItemsData[objIndex].item_qty = parseInt(itemQty);
            this._saveItemsDataInCookie(tradeInFormData);
        },

        /**
         * Retrieves item formattedPrice.
         *
         * @param {Float} price - item price
         * @returns {String}
         * @private
         */
        _getFormattedPrice: function (price) {
            var priceFormat = {
                decimalSymbol: '.',
                groupLength: 3,
                groupSymbol: ",",
                integerRequired: false,
                pattern: "$%s",
                precision: 2,
                requiredPrecision: 2
            };
            return priceUtils.formatPrice(price,priceFormat);
        },
    });
    return $.pivotal.tradeInFormWidget;
});