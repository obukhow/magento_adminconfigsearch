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
 * Block test class for search system config fields
 *
 * @category   Oggetto
 * @package    Oggetto_AdminConfigSearch
 * @subpackage Test
 * @author     Vladislav Slesarenko <vslesarenko@oggettoweb.com>
 */
class Oggetto_AdminConfigSearch_Test_Block_Adminhtml_Search extends EcomDev_PHPUnit_Test_Case
{
    /**
     * Block for searching system config fields
     *
     * @var Oggetto_AdminConfigSearch_Block_Adminhtml_Search
     */
    protected $_searchBlock;

    /**
     * Set up initial variables
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_searchBlock = new Oggetto_AdminConfigSearch_Block_Adminhtml_Search;
    }

    /**
     * Return JSON config array for autocomplete from helper if searchCacheIsEmpty
     *
     * @return void
     */
    public function testReturnsJsonConfigArrayForAutocompleteFromHelperIfSearchCacheIsEmpty()
    {
        $this->replaceByMock('singleton', 'core/session', $this->getModelMock('core/session', ['start']));

        $cacheArray = false;
        $configArray = ['label' => 'Test1'];

        $modelCacheMock = $this->getModelMock('oggetto_adminconfigsearch/config_cache_provider', [
            'loadSearchCache', 'saveSearchCache'
        ]);

        $modelCacheMock->expects($this->once())
            ->method('loadSearchCache')
            ->willReturn($cacheArray);

        $modelCacheMock->expects($this->once())
            ->method('saveSearchCache')
            ->with($configArray);

        $this->replaceByMock('model', 'oggetto_adminconfigsearch/config_cache_provider', $modelCacheMock);


        $helperMock = $this->getHelperMock('oggetto_adminconfigsearch', ['getJsonEncodedSystemConfigArray']);

        $helperMock->expects($this->once())
            ->method('getJsonEncodedSystemConfigArray')
            ->willReturn($configArray);

        $this->replaceByMock('helper', 'oggetto_adminconfigsearch', $helperMock);

        $this->assertEquals($configArray, $this->_searchBlock->getConfigArray());
    }

    /**
     * Return config array from search cache
     *
     * @return void
     */
    public function testReturnsConfigArrayFromSearchCache()
    {
        $this->replaceByMock('singleton', 'core/session', $this->getModelMock('core/session', ['start']));

        $cacheArray = ['label' => 'Test'];

        $modelCacheMock = $this->getModelMock('oggetto_adminconfigsearch/config_cache_provider', [
            'loadSearchCache', 'saveSearchCache'
        ]);

        $modelCacheMock->expects($this->once())
            ->method('loadSearchCache')
            ->willReturn($cacheArray);

        $modelCacheMock->expects($this->never())
            ->method('saveSearchCache');

        $this->replaceByMock('model', 'oggetto_adminconfigsearch/config_cache_provider', $modelCacheMock);


        $helperMock = $this->getHelperMock('oggetto_adminconfigsearch', ['getJsonEncodedSystemConfigArray']);

        $helperMock->expects($this->never())
            ->method('getJsonEncodedSystemConfigArray');

        $this->replaceByMock('helper', 'oggetto_adminconfigsearch', $helperMock);

        $this->assertEquals($cacheArray, $this->_searchBlock->getConfigArray());
    }

    /**
     * Return Oggetto ConfigController action URL for config field value switching
     *
     * @return void
     */
    public function testReturnsOggettoConfigControllerActionUrlForConfigFieldValueSwitching()
    {
        $testUrl = 'url';

        $helperAdminhtmlMock = $this->getMockBuilder('adminhtml')->disableOriginalConstructor()
            ->setMethods(['getUrl'])->getMock();

        $helperAdminhtmlMock->expects($this->once())
            ->method('getUrl')
            ->with('adminhtml/config/switch')
            ->willReturn($testUrl);

        $this->replaceByMock('helper', 'adminhtml', $helperAdminhtmlMock);

        $this->assertEquals($testUrl, $this->_searchBlock->getUrlForFieldValueSwitch());
    }
}
