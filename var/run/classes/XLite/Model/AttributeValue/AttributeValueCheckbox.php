<?php

namespace XLite\Model\AttributeValue;

/**
 * Attribute value (checkbox)
 *
 * @Entity (repositoryClass="\XLite\Model\Repo\AttributeValue\AttributeValueCheckbox")
 * @Table  (name="attribute_values_checkbox",
 *      indexes={
 *          @Index (name="product_id", columns={"product_id"}),
 *          @Index (name="attribute_id", columns={"attribute_id"}),
 *          @Index (name="value", columns={"value"})
 *      }
 * )
 */
class AttributeValueCheckbox extends \XLite\Module\XC\ProductVariants\Model\AttributeValue\AttributeValueCheckbox
{
}