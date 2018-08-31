<?php
/**
 * See LICENSE.md for license details.
 */
namespace Dhl\ExpressRates\Model\Carrier;

use Dhl\ExpressRates\Model\Config\ModuleConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Asset\Repository as AssetRepository;
use Magento\Framework\View\Design\Theme\ThemeProviderInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class CarrierLogo
 *
 * @package Dhl\ExpressRates\Model
 * @author Andreas Müller <andreas.mueller@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link http://www.netresearch.de/
 */
class CarrierLogo
{
    /**
     * @var ModuleConfigInterface
     */
    private $moduleConfig;

    /**
     * @var AssetRepository
     */
    private $assetRepo;

    /**
     * @var ThemeProviderInterface
     */
    private $themeProvider;

    /**
     * @var StoreManagerInterface
     */
    private $storeManger;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * CarrierLogo constructor.
     *
     * @param ModuleConfigInterface $moduleConfig
     * @param AssetRepository $assetRepository
     * @param ThemeProviderInterface $themeProvider
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ModuleConfigInterface $moduleConfig,
        AssetRepository $assetRepository,
        ThemeProviderInterface $themeProvider,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->assetRepo = $assetRepository;
        $this->themeProvider = $themeProvider;
        $this->storeManger = $storeManager;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return null|string
     */
    public function getImageUrl()
    {
        try {
            $store = (string)$this->storeManger->getStore()->getId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
        $logo = $this->moduleConfig->isCheckoutLogoEnabled($store)
            ? $this->getViewFileUrl('Dhl_ExpressRates::'.$this->moduleConfig->getCarrierLogoUrl())
            : null;

        return $logo;
    }

    /**
     * @param string $fileId
     * @return null|string
     */
    private function getViewFileUrl($fileId)
    {
        $themeId = $this->getThemeId();
        $theme = $this->themeProvider->getThemeById($themeId);
        $themeId = $theme->getCode();

        try {
            $params = ['_secure' => false, 'area' => 'frontend', 'theme' => $themeId];
            return $this->assetRepo->getUrlWithParams($fileId, $params);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get the current theme id
     *
     * @param string|null $store
     * @return string
     */
    private function getThemeId($store = null)
    {
        return $this->scopeConfig->getValue(
            \Magento\Framework\View\DesignInterface::XML_PATH_THEME_ID,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
    }
}
