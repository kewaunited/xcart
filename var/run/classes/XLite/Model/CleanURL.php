<?php

namespace XLite\Model;

/**
 * CleanURL
 *
 * @Entity (repositoryClass="\XLite\Model\Repo\CleanURL")
 * @Table (name="clean_urls",
 *      indexes={
 *          @Index (name="cleanURL", columns={"cleanURL"}),
 *      }
 * )
 */
class CleanURL extends \XLite\Module\XC\News\Model\CleanURL
{
}