<?php

namespace XLite\Model;

/**
 * Address model
 *
 * @Entity (repositoryClass="\XLite\Model\Repo\Address")
 * @Table  (name="profile_addresses",
 *      indexes={
 *          @Index (name="is_billing", columns={"is_billing"}),
 *          @Index (name="is_shipping", columns={"is_shipping"})
 *      }
 * )
 * 
 */
class Address extends \XLite\Module\CDev\Paypal\Model\Address
{
}