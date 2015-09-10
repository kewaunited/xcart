{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * ____file_title____
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<!DOCTYPE html>
<html lang="{currentLanguage.code}" dir="{if:currentLanguage.r2l}rtl{else:}ltr{end:}"
  {foreach:getHTMLAttributes(),k,v} {k}="{v}"{end:}>
<widget class="\XLite\View\Header" />
<body class="{getBodyClass()}">
<list name="body" />
</body>
</html>
