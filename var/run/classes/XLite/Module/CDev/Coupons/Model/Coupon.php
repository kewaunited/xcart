<?php

namespace XLite\Module\CDev\Coupons\Model;

/**
 * Coupon
 *
 * @Entity (repositoryClass="\XLite\Module\CDev\Coupons\Model\Repo\Coupon")
 * @Table  (name="coupons",
 *      indexes={
 *          @Index (name="ce", columns={"code", "enabled"})
 *      }
 * )
 */
class Coupon extends \XLite\Module\XC\FreeShipping\Model\Coupon
{
}