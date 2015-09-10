<?php

namespace XLite\Model\AttributeValue;

/**
 * Attribute value (select)
 *
 * @Entity (repositoryClass="\XLite\Model\Repo\AttributeValue\AttributeValueSelect")
 * @Table  (name="attribute_values_select",
 *      indexes={
 *          @Index (name="product_id", columns={"product_id"}),
 *          @Index (name="attribute_id", columns={"attribute_id"}),
 *          @Index (name="attribute_option_id", columns={"attribute_option_id"})
 *      }
 * )
 */
class AttributeValueSelect extends \XLite\Module\XC\ProductVariants\Model\AttributeValue\AttributeValueSelect
{
}