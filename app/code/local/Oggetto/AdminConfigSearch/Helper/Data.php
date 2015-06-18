<?php
/**
 * Oggetto Admin Config Search extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the Oggetto Admin Config Search module to newer versions in the future.
 * If you wish to customize the Oggetto Search module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_AdminConfigSearch
 * @copyright  Copyright (C) 2015 Oggetto Web (http://oggettoweb.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Helper Data
 *
 * @category   Oggetto
 * @package    Oggetto_AdminConfigSearch
 * @subpackage Helper
 * @author     Vladislav Slesarenko <vslesarenko@oggettoweb.com>
 */
class Oggetto_AdminConfigSearch_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Get JSON encoded system config array
     *
     * @return string
     */
    public function getJsonEncodedSystemConfigArray()
    {
        /** @var Oggetto_AdminConfigSearch_Model_Config_Fetcher $fetcher */
        $fetcher = Mage::getModel('oggetto_adminconfigsearch/config_fetcher');

        $config = $fetcher->getAllConfigFields();

        /** @var Mage_Core_Helper_Data $helper */
        $helper = Mage::helper('core');

        return $this->_addSlashes($helper->jsonEncode($config));
    }

    /**
     * Set switched config value
     *
     * @param string $path Path to config value
     *
     * @return mixed
     */
    public function switchConfigValue($path)
    {
        $value = $this->switchValue($this->getConfigFieldValue($path));

        /** @var Mage_Core_Model_Config $coreConfig */
        $coreConfig = Mage::getModel('core/config');

        $coreConfig->saveConfig($path, $value);
        return $value;
    }

    /**
     * Get config field value
     *
     * @param string $path Path to field
     *
     * @return mixed
     */
    public function getConfigFieldValue($path)
    {
        return Mage::getStoreConfig($path);
    }

    /**
     * Switch value
     *
     * @param mixed $value Value
     *
     * @return int
     */
    public function switchValue($value)
    {
        if ($value == 1) {
            return 0;
        }
        return 1;
    }


    /**
     * Add slashes
     *
     * @param string $str String
     * @return string
     */
    protected function _addSlashes($str)
    {
        return addslashes($str);
    }
}