/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Credit card form
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

var ccTypes = {
    'VISA'    : /^4[0-9]{0,18}$/,
    'MC'      : /^5$|^5[1-5][0-9]{0,14}$/,
    'AMEX'    : /^3$|^3[47][0-9]{0,13}$/,
    'JCB'     : /^2[1]?$|^21[3]?$|^1[8]?$|^18[0]?$|^(?:2131|1800)[0-9]{0,11}$|^3[5]?$|^35[0-9]{0,14}$/,
    'DICL'    : /^3$|^3[068]$|^3(?:0[0-5]|[68][0-9])[0-9]{0,11}$/,
    'CB'      : /^39/,
    'DC'      : /^6$|^6[05]$|^601[1]?$|^65[0-9][0-9]?$|^6(?:011|5[0-9]{2})[0-9]{0,12}$/,
    'BC'      : /^56[01]/,
    'SW'      : /^(5018|5020|5038|6304|6759|6761|6763|4903|4905|4911|4936|564182|633110|6333|6759)/,
    'SOLO'    : /^(6334|6767)/,
    'DELTA'   : /^401171/,
    'UKE'     : /^(417500|4917|4913|4508|4844)/,
    'LASER'   : /^6[37]/,
    'DANKORT' : /^4571/,
    'ER'      : /^2[01]/,
    'CUP'     : /^622[1-9]/
};

var ccTypeSprites = {
    'VISA'    : 'visa',
    'MC'      : 'mc',
    'AMEX'    : 'amex',
    'DICL'    : 'dicl',
    'DC'      : 'dc',
    'JCB'     : 'jcb',
    'BC'      : 'bc',
    'SW'      : 'sw',
    'SOLO'    : 'sw',
    'DELTA'   : 'visa',
    'CUP'     : 'cup',
}

/**
 * JS functions
 */

function trim(str) {
    return str.replace(/^[ ]+/, '').replace(/[ ]+$/, '');
}

function setCardType(type) {

    $('.cardType .icon').attr('class', 'dropdown-toggle icon');
    $('.cardType .icon .card').attr('class', 'card');
    $('.cardCVV2 .icon').attr('class', 'icon blank');
    $('.cardCVV2 .right-text').attr('class', 'right-text').find('.default-text').show().siblings().hide();

    $('#card_type').val('');

    $('.cardCVV2').show();
    if (typeof type == 'undefined') {
        accountNumber = $('#cc_number').val().replace(/[^0-9]/g, '');

        if ('' == accountNumber) {
            $('.cardType .icon').addClass('blank');
            $('.cardCVV2 .right-text').addClass('blank');
            $('.cardCVV2').hide();
            return;
        }

        for (var t in ccTypes) {
            if (ccTypes[t].test(accountNumber)) {
                type = t;
                break;
            }
        }

    }

    if (typeof type == 'undefined') {
        $('.cardCVV2').hide();
        $('.cardType .icon').addClass('unknown');
        $('.cardCVV2 .right-text').addClass('unknown').find('.default-text').show().siblings().hide();
        return;
    }

    $('#card_type').val(type);

    if (ccTypeSprites[type]) {
        $('.cardType .icon .card').addClass(ccTypeSprites[type]);
        $('.cardCVV2 .icon').removeClass('blank').addClass(ccTypeSprites[type]);
    }

    var textSpan = $('.cardCVV2 .right-text').find('.'+type);
    if (textSpan.length) {
        textSpan.show().siblings().hide();
    } else {
        $('.cardCVV2 .right-text').attr('class', 'right-text').find('.default-text').show().siblings().hide();
    }
}

function cardTypeHandlersSetter() {
    if ($('.cc-form').length) {
        var numberField = $('#cc_number');
        numberField.change(function () { setCardType(); });
        numberField.keyup(function () { setCardType(); });
        setCardType();
    }
}

core.bind('checkout.main.initialize', function(){
    core.bind('checkout.paymentTpl.loaded', function(){
        cardTypeHandlersSetter();
    });
    cardTypeHandlersSetter();
});


