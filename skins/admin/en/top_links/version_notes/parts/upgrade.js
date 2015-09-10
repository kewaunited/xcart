/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Upgrade note controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

core.microhandlers.add(
  'upgrade-top-box',
  '.upgrade-box',
  function() {
    var base = jQuery(this);

    base.find('a.close').click(
      function() {
        if (base.hasClass('opened') || base.hasClass('post-opened')) {
          base.removeClass('opened').removeClass('post-opened').addClass('closed');
          jQuery('body').removeClass('upgrade-box-visible').addClass('upgrade-box-hidden');
          setTimeout(
            function() {
              jQuery.ajax({
                url: xliteConfig.script + "?target=main&action=set_notifications_as_read&menuType=toplinksMenuReadHash"
              }).done(function() {
                base.addClass('post-closed').removeClass('closed');
              });
            },
            1100
          );

        } else {
          base.removeClass('closed').removeClass('post-closed').addClass('opened');
          jQuery('body').removeClass('upgrade-box-hidden').addClass('upgrade-box-visible');
          setTimeout(
            function() {
              base.addClass('post-opened').removeClass('opened');
            },
            1100
          );
        }

        return false;
      }
    );

    base.find('a.warning').click(
      function() {
        if (base.hasClass('closed') || base.hasClass('post-closed')) {
          base.find('.close').click();
        }

        return false;
      }
    );

  }
);

