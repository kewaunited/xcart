{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Credit card form
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="cc-form-container">
    <div class="header-line"></div>
    <div class="content">
        <div class="header">
            <div class="lock"></div>
            <h2>{t(#Secure credit card payment#)}</h2>
        </div>

        <div class="cc-form">
            <div class="cardType">
                <div class="title">{t(#Card type#)}:</div>
                <div class="value">
                    <select id="card_type">
                        <option disabled selected>{t(#Chose credit card type#)}</option>
                        <option value="VISA">Visa</option>
                        <option value="MC">MasterCard</option>
                        <option value="JCB">JCB</option>
                        <option value="ER">Diners Club enRoute</option>
                        <option value="DICL">Diners Club</option>
                        <option value="DC">Discover</option>
                        <option value="AMEX">American Express</option>
                    </select>
                    <div class="btn-group">
                        <a class="dropdown-toggle icon blank" data-toggle="dropdown" href="#">
                            <span class="card mc"></span>{t(#Choose card type#)}
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript: setCardType('VISA');">Visa</a></li>
                            <li><a href="javascript: setCardType('MC');">MasterCard</a></li>
                            <li><a href="javascript: setCardType('JCB');">JCB</a></li>
                            <li><a href="javascript: setCardType('ER');">Diners Club enRoute</a></li>
                            <li><a href="javascript: setCardType('DICL');">Diners Club</a></li>
                            <li><a href="javascript: setCardType('DC');">Discover</a></li>
                            <li><a href="javascript: setCardType('AMEX');">American Express</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="cardNumber">
                <div class="title">{t(#Card number#)}:</div>
                <div class="value">
                    <input size="25" id="cc_number" class="validate[required,maxSize[255]]" placeholder="XXXX-XXXX-XXXX-XXXX" type="text" autocomplete="off">
                </div>
            </div>

            <div class="cardExpire">
                <div class="title lite-hide">{t(#Expiration date#)}:</div>
                <div class="value">
                    <div class="top-line">
                        <div class="top-text lite-hide">{t(#MONTH#)} / {t(#YEAR#)}</div>
                    </div>
                    <div class="bottom-line">
                        <div class="left-text lite-hide">{t(#VALID THRU#)}</div>
                        <div class="left-text lite-hide default-hide mobile-show">
                            <span class="valid-thru">{t(#VALID THRU#)}</span>
                            <br>
                            <span class="month-year">{t(#MONTH#)} / {t(#YEAR#)}</span>
                        </div>
                        <div class="month-container">
                            <select id="cc_expire_month" class="validate[required]">
                                <option value="01" selected="selected">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <div class="bottom-text-month default-hide">{t(#MONTH#)}</div>
                        </div>
                        <div class="year-container">
                            <select id="cc_expire_year" class="validate[required]">
                                <option FOREACH="getExpiredYears(),year" value="{year}">{year}</option>
                            </select>
                            <div class="bottom-text-month default-hide">{t(#YEAR#)}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cardName">
                <div class="title">{t(#Cardholder name#)}:</div>
                <div class="value">
                    <input size="40" id="cc_name" class="validate[required]" placeholder="{t(#Cardholder name#)}" type="text" autocomplete="off">
                </div>
            </div>

            <div class="cardCVV2 required">
                <div class="title">{t(#Security code#)}:</div>
                <div class="value">
                    <input size="5" maxlength="4" id="cc_cvv2" type="text" autocomplete="off">
                    <div class="right-text">
                        <span class="default-text">{t(#Credit card security code (if present)#)}</span>
                        <span class="VISA">{t(#Last three numbers on the back side of your card#)}</span>
                        <span class="MC">{t(#Last three numbers on the back side of your card#)}</span>
                        <span class="JCB">{t(#Last three numbers on the back side of your card#)}</span>
                        <span class="AMEX">{t(#Four-digit number on the front side of your card#)}</span>
                    </div>
                </div>
                <div class="icon-container">
                    <div class="icon mc"></div>
                </div>
            </div>

        </div>

    </div>
</div>