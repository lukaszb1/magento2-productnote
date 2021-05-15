define([
    'jquery',
    'jquery/validate',
    'mage/translate'
], function ($) {
    'use strict';

    $.validator.addMethod(
        'alphanumeric-extended', function (value) {
            return /^[ A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ0-9\-\?\,\.]+$/i.test(value);
        }, $.mage.__('Please use only letters, numbers or spaces only in this field.'));
});
