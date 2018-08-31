<?php
/**
 * See LICENSE.md for license details.
 */
namespace Dhl\ExpressRates\Model\Config;

/**
 * ModuleConfigInterface
 *
 * @package  Dhl\ExpressRates\Model
 * @author   Ronny Gertler <ronny.gertler@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
interface ModuleConfigInterface
{
    const CONFIG_ROOT = 'carriers/dhlexpress/';

    const CONFIG_XML_PATH_ENABLED = self::CONFIG_ROOT . 'active';
    const CONFIG_XML_PATH_SORT_ORDER = self::CONFIG_ROOT . 'sort_order';
    const CONFIG_XML_PATH_TITLE = self::CONFIG_ROOT . 'title';
    const CONFIG_XML_PATH_EMULATED_CARRIER = self::CONFIG_ROOT . 'emulated_carrier';
    const CONFIG_XML_PATH_SHIP_TO_SPECIFIC_COUNTRIES = self::CONFIG_ROOT . 'sallowspecific';
    const CONFIG_XML_PATH_SPECIFIC_COUNTRIES = self::CONFIG_ROOT . 'specificcountry';
    const CONFIG_XML_PATH_SHOW_IF_NOT_APPLICABLE = self::CONFIG_ROOT . 'show_method_if_not_applicable';
    const CONFIG_XML_PATH_ERROR_MESSAGE = self::CONFIG_ROOT . 'specificerrmsg';
    const CONFIG_XML_PATH_USERNAME = self::CONFIG_ROOT . 'username';
    const CONFIG_XML_PATH_PASSWORD = self::CONFIG_ROOT . 'password';
    const CONFIG_XML_PATH_SANDBOX_MODE = self::CONFIG_ROOT . 'sandboxmode';
    const CONFIG_XML_PATH_ACCOUNT_NUMBER = self::CONFIG_ROOT . 'accountnumber';
    const CONFIG_XML_PATH_LOGLEVEL = self::CONFIG_ROOT . 'loglevel';
    const CONFIG_XML_PATH_ENABLE_LOGGING = self::CONFIG_ROOT . 'logging';
    const CONFIG_XML_PATH_ALLOWED_DOMESTIC_PRODUCTS = self::CONFIG_ROOT . 'alloweddomesticproducts';
    const CONFIG_XML_PATH_ALLOWED_INTERNATIONAL_PRODUCTS = self::CONFIG_ROOT . 'allowedinternationalproducts';
    const CONFIG_XML_PATH_REGULAR_PICKUP = self::CONFIG_ROOT . 'regular_pickup';
    const CONFIG_XML_PATH_PACKAGE_INSURANCE = self::CONFIG_ROOT . 'package_insurance';
    const CONFIG_XML_PATH_PACKAGE_INSURANCE_FROM_VALUE = self::CONFIG_ROOT . 'package_insurance_from_value';
    const CONFIG_XML_PATH_PICKUP_TIME = self::CONFIG_ROOT . 'pickup_time';
    const CONFIG_XML_PATH_DOMESTIC_HANDLING_TYPE = self::CONFIG_ROOT . 'domestic_handling_type';
    const CONFIG_XML_PATH_DOMESTIC_HANDLING_FEE = self::CONFIG_ROOT . 'domestic_handling_fee';
    const CONFIG_XML_PATH_INTERNATIONAL_HANDLING_TYPE = self::CONFIG_ROOT . 'international_handling_type';
    const CONFIG_XML_PATH_INTERNATIONAL_HANDLING_FEE = self::CONFIG_ROOT . 'international_handling_fee';
    const CONFIG_XML_PATH_ROUNDED_PRICES_MODE = self::CONFIG_ROOT . 'round_prices_mode';
    const CONFIG_XML_PATH_ROUNDED_PRICES_FORMAT = self::CONFIG_ROOT . 'round_prices_format';
    const CONFIG_XML_PATH_ROUNDED_PRICES_STATIC_DECIMAL = self::CONFIG_ROOT . 'round_prices_static_decimal';
    const CONFIG_XML_PATH_FREE_SHIPPING_SUBTOTAL = self::CONFIG_ROOT . 'free_shipping_subtotal';
    const CONFIG_XML_PATH_FREE_SHIPPING_ENABLED = self::CONFIG_ROOT . 'free_shipping_enable';
    const CONFIG_XML_PATH_FREE_SHIPPING_VIRTUAL_ENABLED = self::CONFIG_ROOT . 'free_shipping_virtual_products_enable';
    const CONFIG_XML_PATH_DOMESTIC_FREE_SHIPPING_PRODUCTS = self::CONFIG_ROOT . 'domestic_free_shipping_products';
    const CONFIG_XML_PATH_DOMESTIC_FREE_SHIPPING_SUBTOTAL = self::CONFIG_ROOT . 'domestic_free_shipping_subtotal';
    const CONFIG_XML_PATH_INTERNATIONAL_FREE_SHIPPING_PRODUCTS = self::CONFIG_ROOT . 'international_free_shipping_products';
    const CONFIG_XML_PATH_INTERNATIONAL_FREE_SHIPPING_SUBTOTAL = self::CONFIG_ROOT . 'international_free_shipping_subtotal';
    const CONFIG_XML_PATH_CARRIER_LOGO = self::CONFIG_ROOT . 'carrier_logo_url';
    const CONFIG_XML_PATH_CHECKOUT_SHOW_LOGO = self::CONFIG_ROOT . 'checkout_show_logo';
    const CONFIG_XML_PATH_CHECKOUT_SHOW_DELIVERY_TIME = self::CONFIG_ROOT . 'checkout_show_delivery_time';
    const CONFIG_XML_PATH_TERMS_OF_TRADE = self::CONFIG_ROOT . 'terms_of_trade';
    const CONFIG_XML_PATH_CUT_OFF_TIME = self::CONFIG_ROOT . 'cut_off_time';
    const CONFIG_XML_PATH_ENABLE_RATES_CONFIGURATION = self::CONFIG_ROOT . 'enable_rates_configuration';
    const CONFIG_XML_PATH_WEIGHT_UNIT = 'general/locale/weight_unit';
    const CONFIG_XML_SUFFIX_FIXED = '_fixed';
    const CONFIG_XML_SUFFIX_PERCENTAGE = '_percentage';

    /**
     * Check if the module is enabled.
     *
     * @param string|null $store
     * @return bool
     */
    public function isEnabled($store = null);

    /**
     * Get the sort order.
     *
     * @param string|null $store
     * @return int
     */
    public function getSortOrder($store = null);

    /**
     * Get the title.
     *
     * @param string|null $store
     * @return string
     */
    public function getTitle($store = null);

    /**
     * Get the emulated carrier.
     *
     * @param string|null $store
     * @return string
     */
    public function getEmulatedCarrier($store = null);

    /**
     * Check if shipping only to specific countries.
     *
     * @param string|null $store
     * @return bool
     */
    public function shipToSpecificCountries($store = null);

    /**
     * Get the specific countries.
     *
     * @param string|null $store
     * @return string[]
     */
    public function getSpecificCountries($store = null);

    /**
     * Show DHL Express in checkout if there are no products available.
     *
     * @param string|null $store
     * @return bool
     */
    public function showIfNotApplicable($store = null);

    /**
     * Get the error message.
     *
     * @param string|null $store
     * @return string
     */
    public function getNotApplicableErrorMessage($store = null);

    /**
     * Get the username.
     *
     * @param string|null $store
     * @return string
     */
    public function getUserName($store = null);

    /**
     * Get the password.
     *
     * @param string|null $store
     * @return string
     */
    public function getPassword($store = null);

    /**
     * Check if Sandbox mode is enabled.
     *
     * @param string|null $store
     * @return bool
     */
    public function sandboxModeEnabled($store = null);

    /**
     * Check if Sandbox mode is disabled.
     *
     * @param string|null $store
     * @return bool
     */
    public function sandboxModeDisabled($store = null);

    /**
     * Get the Logging status.
     *
     * @param string|null $store
     * @return bool
     */
    public function isLoggingEnabled($store = null);

    /**
     * Get the log level.
     *
     * @param string|null $store
     * @return int
     */
    public function getLogLevel($store = null);

    /**
     * Get the account number.
     *
     * @param string|null $store
     * @return string
     */
    public function getAccountNumber($store = null);

    /**
     * Get the allowed domestic products.
     *
     * @param string|null $store
     * @return string[]
     */
    public function getAllowedDomesticProducts($store = null);

    /**
     * Get the allowed international products.
     *
     * @param string|null $store
     * @return string[]
     */
    public function getAllowedInternationalProducts($store = null);

    /**
     * Check if regular pickup is enabled.
     *
     * @param null $store
     * @return bool
     */
    public function isRegularPickup($store = null);

    /**
     * Return if packages are insured.
     *
     * @param string|null $store
     * @return bool
     */
    public function isInsured($store = null);

    /**
     * Get the value from which the packages should be insured.
     *
     * @param string|null $store
     * @return float
     */
    public function insuranceFromValue($store = null);

    /**
     * Get the pickup time.
     *
     * @param null $store
     * @return string
     */
    public function getPickupTime($store = null);

    /**
     * Get the domestic handling type.
     *
     * @param string|null $store
     *
     * @return string
     */
    public function getDomesticHandlingType($store = null);

    /**
     * Get the domestic handling fee.
     *
     * @param string|null $store
     *
     * @return float
     */
    public function getDomesticHandlingFee($store = null);

    /**
     * Get the international handling type.
     *
     * @param string|null $store
     *
     * @return string
     */
    public function getInternationalHandlingType($store = null);

    /**
     * Get the international handling fee.
     *
     * @param string|null $store
     *
     * @return float
     */
    public function getInternationalHandlingFee($store = null);

    /**
     * Get mode for rounded prices.
     *
     * @param string|null $store
     * @return string|null
     */
    public function getRoundedPricesMode($store = null);

    /**
     * Returns true when price should be rounded up.
     *
     * @param string|null $store
     * @return bool
     */
    public function roundUp($store = null);

    /**
     * Returns true when price should be rounded off.
     *
     * @param string|null $store
     * @return bool
     */
    public function roundOff($store = null);

    /**
     * Get rounded prices format.
     *
     * @param string|null $store
     * @return string
     */
    public function getRoundedPricesFormat($store = null);

    /**
     * Get rounded prices static value.
     *
     * @param string|null $store
     * @return float
     */
    public function getRoundedPricesStaticDecimal($store = null);

    /**
     * Returns whether free shipping is enabled or not.
     *
     * @param string|null $store Store name
     *
     * @return bool
     */
    public function isFreeShippingEnabled($store = null);

    /**
     * Returns whether virtual products should be included in the subtotal value calculation or not.
     *
     * @param string|null $store Store name
     *
     * @return bool
     */
    public function isFreeShippingVirtualProductsIncluded($store = null);

    /**
     * Get the domestic free shipping allowed products.
     *
     * @param string|null $store Store name
     *
     * @return string[]
     */
    public function getDomesticFreeShippingProducts($store = null);

    /**
     * Get the domestic free shipping subtotal value.
     *
     * @param string|null $store Store name
     *
     * @return float
     */
    public function getDomesticFreeShippingSubTotal($store = null);

    /**
     * Get the international free shipping allowed products.
     *
     * @param string|null $store Store name
     *
     * @return string[]
     */
    public function getInternationalFreeShippingProducts($store = null);

    /**
     * Get the international free shipping subtotal value.
     *
     * @param string|null $store Store name
     *
     * @return float
     */
    public function getInternationalFreeShippingSubTotal($store = null);

    /**
     * Get carrier logo url
     *
     * @param string|null $store
     * @return string
     */
    public function getCarrierLogoUrl($store = null);

    /**
     * Check if logo should be displayed in checkout
     *
     * @param string|null $store
     * @return bool
     */
    public function isCheckoutLogoEnabled($store = null);

    /**
     * Check if delivery time should be displayed in checkout
     *
     * @param string|null $store
     * @return bool
     */
    public function isCheckoutDeliveryTimeEnabled($store = null);

    /**
     * Get terms of trade
     *
     * @param null $store
     * @return string
     */
    public function getTermsOfTrade($store = null);

    /**
     * Get the cut off time.
     *
     * @param null $store
     * @return string
     */
    public function getCutOffTime($store = null);

    /**
     * Check if rates configuration is enabled
     *
     * @param null $store
     * @return bool
     */
    public function isRatesConfigurationEnabled($store = null);

    /**
     * Get the general weight unit.
     *
     * @param null $store
     * @return string
     */
    public function getWeightUnit($store = null);

    /**
     * Get the general dimensions unit.
     *
     * @return string
     */
    public function getDimensionsUOM();

    /**
     * Maps Magento's internal unit names to SDKs unit names
     *
     * @param string $unit
     * @return string
     */
    public function normalizeDimensionUOM($unit);

    /**
     * Checks if route is dutiable by stores origin country and eu country list
     *
     * @param string $receiverCountry
     * @param mixed $store
     * @return bool
     *
     */
    public function isDutiableRoute($receiverCountry, $store = null);

    /**
     * Returns countries that are marked as EU-Countries
     *
     * @param mixed $store
     * @return string[]
     */
    public function getEuCountries($store = null);

    /**
     * Returns the shipping origin country
     *
     * @see Config
     *
     * @param mixed $store
     * @return string
     */
    public function getOriginCountry($store = null);
}
