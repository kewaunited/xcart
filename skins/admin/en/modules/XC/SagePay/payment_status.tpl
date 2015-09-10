{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Payment method status
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="payment_status.after.SagePay_form_protocol", weight="100")
 *}
{if:!paymentMethod.isConfigured()}
{t(#Don't have account yet? Sign up for SagePay now!#):h}
{end:}