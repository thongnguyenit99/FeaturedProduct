<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Team1\FeaturedCategory\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package Team1\FeaturedCategory\Helper
 */
class Data extends AbstractHelper
{
    const XML_PATH_FEATUREDCATEGORY = 'featuredcategory/';

    /**
     * @param $field
     * @param null $storeId
     * @return values config
     */
    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    /**
     * @param $code
     * @param null $storeId
     * @return values
     */
    public function getGeneralConfig($code, $storeId = null)
    {

        return $this->getConfigValue(self::XML_PATH_FEATUREDCATEGORY . 'general/' . $code, $storeId);
    }

}
