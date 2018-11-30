<?php
/**
 * See LICENSE.md for license details.
 */
namespace Dhl\ExpressRates\Test\Integration\Model\Config;

use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\TestFramework\ObjectManager;

/**
 * ModuleConfigTest
 *
 * @package Dhl\ExpressRates\Test\Integration
 * @author  Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license https://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link    https://www.netresearch.de/
 */
class ModuleConfigTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var $objectManager ObjectManager
     */
    private $objectManager;

    /** @var ModuleConfigInterface */
    private $config;

    /**
     * Config fixtures are loaded before data fixtures. Config fixtures for
     * non-existent stores will fail. We need to set the stores up first manually.
     *
     * @link http://magento.stackexchange.com/a/93961
     */
    public static function setUpBeforeClass()
    {
        require realpath(TESTS_TEMP_DIR . '/../testsuite/Magento/Store/_files/core_fixturestore_rollback.php');
        require realpath(
            TESTS_TEMP_DIR . '/../testsuite/Magento/Store/_files/core_second_third_fixturestore_rollback.php'
        );

        require realpath(TESTS_TEMP_DIR . '/../testsuite/Magento/Store/_files/core_fixturestore.php');
        require realpath(TESTS_TEMP_DIR . '/../testsuite/Magento/Store/_files/core_second_third_fixturestore.php');
        parent::setUpBeforeClass();
    }

    /**
     * Delete manually added stores.
     *
     * @see setUpBeforeClass()
     */
    public static function tearDownAfterClass()
    {
        require realpath(TESTS_TEMP_DIR . '/../testsuite/Magento/Store/_files/core_fixturestore_rollback.php');
        require realpath(
            TESTS_TEMP_DIR . '/../testsuite/Magento/Store/_files/core_second_third_fixturestore_rollback.php'
        );
        parent::tearDownAfterClass();
    }

    protected function setUp()
    {
        parent::setUp();

        $this->objectManager = ObjectManager::getInstance();

        $this->config = $this->objectManager->create(ModuleConfig::class);
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/active 0
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/active 1
     */
    public function isEnabled()
    {
        $this->assertEquals(0, $this->config->isEnabled());
        $this->assertEquals(1, $this->config->isEnabled('fixturestore'));
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/sort_order 10
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/sort_order 20
     */
    public function getSortOrder()
    {
        $this->assertEquals(10, $this->config->getSortOrder());
        $this->assertEquals(20, $this->config->getSortOrder('fixturestore'));
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/title DHL Express
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/title Title
     */
    public function getTitle()
    {
        $this->assertEquals('DHL Express', $this->config->getTitle());
        $this->assertEquals('Title', $this->config->getTitle('fixturestore'));
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/emulated_carrier flatrate
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/emulated_carrier tablerate
     */
    public function getEmulatedCarrier()
    {
        $this->assertEquals('flatrate', $this->config->getEmulatedCarrier());
        $this->assertEquals('tablerate', $this->config->getEmulatedCarrier('fixturestore'));
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/sallowspecific 0
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/sallowspecific 1
     */
    public function shipToSpecificCountries()
    {
        $this->assertEquals(0, $this->config->shipToSpecificCountries());
        $this->assertEquals(1, $this->config->shipToSpecificCountries('fixturestore'));
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/specificcountry AL,DZ
     */
    public function getSpecificCountries()
    {
        $euCountries = $this->config->getSpecificCountries();
        $this->assertNotEmpty($euCountries);
        $this->assertCount(2, $euCountries);
        $this->assertContains('AL', $euCountries);
        $this->assertContains('DZ', $euCountries);
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/specificerrmsg Error message
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/specificerrmsg Special error message
     */
    public function getErrorMessage()
    {
        $this->assertEquals('Error message', $this->config->getNotApplicableErrorMessage());
        $this->assertEquals('Special error message', $this->config->getNotApplicableErrorMessage('fixturestore'));
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/username Username
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/username userName
     */
    public function getUserName()
    {
        $this->assertEquals('Username', $this->config->getUserName());
        $this->assertEquals('userName', $this->config->getUserName('fixturestore'));
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/password testcase1
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/password testcase2
     */
    public function getPassword()
    {
        /** @var EncryptorInterface $encryptor */
        $encryptor = $this->objectManager->get(EncryptorInterface::class);

        $this->assertSame($encryptor->decrypt('testcase1'), $this->config->getPassword());
        $this->assertSame($encryptor->decrypt('testcase2'), $this->config->getPassword('fixturestore'));
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/sandboxmode 0
     */
    public function sandboxModeDisabled()
    {
        $this->assertFalse($this->config->sandboxModeEnabled());
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/sandboxmode 1
     */
    public function sandboxModeEnabled()
    {
        $this->assertTrue($this->config->sandboxModeEnabled());
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/loglevel 400
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/loglevel 200
     * @magentoConfigFixture secondstore_store carriers/dhlexpress/loglevel 100
     */
    public function getLogLevel()
    {
        $this->assertEquals('400', $this->config->getLogLevel());
        $this->assertEquals('100', $this->config->getLogLevel('secondstore'));
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/accountnumber 987654321
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/accountnumber 123456789
     */
    public function getAccountNumber()
    {
        $this->assertEquals('987654321', $this->config->getAccountNumber());
        $this->assertEquals('123456789', $this->config->getAccountNumber('fixturestore'));
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/logging 0
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/logging 1
     */
    public function getLogging()
    {
        $this->assertEquals(0, $this->config->isLoggingEnabled());
        $this->assertEquals(1, $this->config->isLoggingEnabled('fixturestore'));
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/duty_taxes_accountnumber 987654321
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/duty_taxes_accountnumber 123456789
     */
    public function getDutyTaxesAccountNumber()
    {
        $this->assertEquals('987654321', $this->config->getDutyTaxesAccountNumber());
        $this->assertEquals('123456789', $this->config->getDutyTaxesAccountNumber('fixturestore'));
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/regular_pickup 1
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/regular_pickup 0
     */
    public function getRegularPickup()
    {
        $this->assertEquals(1, $this->config->isRegularPickup());
        $this->assertEquals(0, $this->config->isRegularPickup('fixturestore'));
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/pickup_time 00,00,00
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/pickup_time 12,07,10
     */
    public function getPickupTime()
    {
        $this->assertEquals('00,00,00', $this->config->getPickupTime());
        $this->assertEquals('12,07,10', $this->config->getPickupTime('fixturestore'));
    }

    /**
     * @test
     * @magentoConfigFixture current_store      carriers/dhlexpress/domestic_handling_type F
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/domestic_handling_type P
     */
    public function getDomesticHandlingType()
    {
        self::assertSame(AbstractCarrier::HANDLING_TYPE_FIXED, $this->config->getDomesticHandlingType());
        self::assertSame(
            AbstractCarrier::HANDLING_TYPE_PERCENT,
            $this->config->getDomesticHandlingType('fixturestore')
        );
    }

    /**
     * @test
     * @magentoConfigFixture current_store      carriers/dhlexpress/domestic_handling_fee 0
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/domestic_handling_fee 30
     */
    public function getDomesticHandlingFee()
    {
        self::assertSame(0.0, $this->config->getDomesticHandlingFee());
        self::assertSame(30.0, $this->config->getDomesticHandlingFee('fixturestore'));
    }

    /**
     * @test
     * @magentoConfigFixture current_store      carriers/dhlexpress/international_handling_type F
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/international_handling_type P
     */
    public function getInternationalHandlingType()
    {
        self::assertSame(AbstractCarrier::HANDLING_TYPE_FIXED, $this->config->getInternationalHandlingType());
        self::assertSame(
            AbstractCarrier::HANDLING_TYPE_PERCENT,
            $this->config->getInternationalHandlingType('fixturestore')
        );
    }

    /**
     * @test
     * @magentoConfigFixture current_store      carriers/dhlexpress/international_handling_fee 0
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/international_handling_fee 30
     */
    public function getInternationalHandlingFee()
    {
        self::assertSame(0.0, $this->config->getInternationalHandlingFee());
        self::assertSame(30.0, $this->config->getInternationalHandlingFee('fixturestore'));
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/alloweddomesticproducts I,O,1,N
     */
    public function getAllowedDomesticProducts()
    {
        $productKeys = $this->config->getAllowedDomesticProducts();
        $this->assertInternalType('array', $productKeys);
        $this->assertNotEmpty($productKeys);
        $this->assertContainsOnly('string', $productKeys);
        $this->assertCount(4, $productKeys);
        $this->assertContains('I', $productKeys);
        $this->assertContains('O', $productKeys);
        $this->assertContains('1', $productKeys);
        $this->assertContains('N', $productKeys);
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/allowedinternationalproducts X,D;P,K;E,L;M,T;Y
     */
    public function getAllowedInternationalProducts()
    {
        $productKeys = $this->config->getAllowedInternationalProducts();
        $this->assertInternalType('array', $productKeys);
        $this->assertNotEmpty($productKeys);
        $this->assertContainsOnly('string', $productKeys);
        $this->assertCount(9, $productKeys);
        $this->assertContains('X', $productKeys);
        $this->assertContains('D', $productKeys);
        $this->assertContains('P', $productKeys);
        $this->assertContains('K', $productKeys);
        $this->assertContains('E', $productKeys);
        $this->assertContains('L', $productKeys);
        $this->assertContains('M', $productKeys);
        $this->assertContains('T', $productKeys);
        $this->assertContains('Y', $productKeys);
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/round_prices_mode no_rounding
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/round_prices_mode round_up
     * @magentoConfigFixture secondstore_store carriers/dhlexpress/round_prices_mode round_off
     */
    public function getRoundedPricesMode()
    {
        $this->assertEquals('no_rounding', $this->config->getRoundedPricesMode());
        $this->assertEquals('round_up', $this->config->getRoundedPricesMode('fixturestore'));
        $this->assertEquals('round_off', $this->config->getRoundedPricesMode('secondstore'));
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/round_prices_mode no_rounding
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/round_prices_mode round_up
     * @magentoConfigFixture secondstore_store carriers/dhlexpress/round_prices_mode round_off
     */
    public function roundUp()
    {
        $this->assertFalse($this->config->roundUp('current'));
        $this->assertTrue($this->config->roundUp('fixturestore'));
        $this->assertFalse($this->config->roundUp('secondstore'));
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/round_prices_mode no_rounding
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/round_prices_mode round_up
     * @magentoConfigFixture secondstore_store carriers/dhlexpress/round_prices_mode round_off
     */
    public function roundOff()
    {
        $this->assertFalse($this->config->roundOff('current'));
        $this->assertFalse($this->config->roundOff('fixturestore'));
        $this->assertTrue($this->config->roundOff('secondstore'));
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/round_prices_format full_price
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/round_prices_format static_decimal
     */
    public function getRoundedPricesFormat()
    {
        $this->assertEquals('full_price', $this->config->getRoundedPricesFormat());
        $this->assertEquals('static_decimal', $this->config->getRoundedPricesFormat('fixturestore'));
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/round_prices_static_decimal 0
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/round_prices_static_decimal 10
     * @magentoConfigFixture secondstore_store carriers/dhlexpress/round_prices_static_decimal 25
     */
    public function getRoundedPricesStaticDecimal()
    {
        $this->assertEquals(0.00, $this->config->getRoundedPricesStaticDecimal('current'));
        $this->assertEquals(0.1, $this->config->getRoundedPricesStaticDecimal('fixturestore'));
        $this->assertEquals(0.25, $this->config->getRoundedPricesStaticDecimal('secondstore'));
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/checkout_show_logo 1
     */
    public function getCheckoutLogoSettingEnabled()
    {
        $this->assertTrue($this->config->isCheckoutLogoEnabled());
    }

    /**
     * @test
     * @magentoConfigFixture current_store carriers/dhlexpress/terms_of_trade DTP/DDP
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/terms_of_trade DDU/DAP
     */
    public function getTermsOfTrade()
    {
        $this->assertEquals('DTP/DDP', $this->config->getTermsOfTrade());
        $this->assertEquals('DDU/DAP', $this->config->getTermsOfTrade('fixturestore'));
    }

    /**
     * @magentoConfigFixture current_store scarriers/dhlexpress/cut_off_time 00,00,00
     * @magentoConfigFixture fixturestore_store carriers/dhlexpress/cut_off_time 12,07,10
     */
    public function getCutOffTime()
    {
        $this->assertEquals('00,00,00', $this->config->getCutOffTime());
        $this->assertEquals('12,07,10', $this->config->getCutOffTime('fixturestore'));
    }
}
