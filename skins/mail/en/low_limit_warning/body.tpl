{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Low limit warning email body (to admin)
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<p>
  {getNotificationText():h}
</p>
<p>
  {t(#SKU#)}: {product.sku:h}<br />
  {t(#Product name#)}: {product.name:h}<br />
  <br />
  {t(#In stock#)}: {t(#X items#,_ARRAY_(#count#^product.amount))}
</p>
<p>
  {t(#Click the link to increase product amount#)}: {product.adminURL}
</p>
