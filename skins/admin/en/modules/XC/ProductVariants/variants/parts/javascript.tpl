{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Inline JS code for Product Variants page
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<script type="text/javascript">
//<![CDATA[
var variantMessages = [];
variantMessages['limit-error'] = '{getLimitErrorMessage()}';
variantMessages['limit-warning'] = '{getLimitWarningMessage()}';
variantMessages['limit-confirmation'] = '{getLimitConfirmationMessage()}';
var maxVariantsWarning = {getVariantsNumberSoftLimit()};
var maxVariantsError = {getVariantsNumberHardLimit()};
//]]>
</script>
