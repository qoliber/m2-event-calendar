define([
    'Magento_Ui/js/form/element/abstract',
    'mage/template'
], function (CheckboxElement) {
    'use strict';

    return CheckboxElement.extend({
        defaults: {
            elementTmpl: 'Qoliber_EventCalendar/form/element/input'
        },

        /**
         * @returns {Element}
         */
        initialize: function () {
            return this._super()
                .initStateConfig();
        },

        /**
         * @returns {Element}
         */
        initStateConfig: function () {
            let attributes;

            if (this.source) {
                attributes = this.source.get(this.parentScope);

                if (attributes['customer_id'] && attributes['customer_id'] !== 0) {
                    this.selectedCustomer = attributes['customer_id'] + ' - ' + attributes['email'];
                } else {
                    this.selectedCustomer = null;
                }
            }

            return this;
        }
    });
});
