<?php
/**
 * See LICENSE.md for license details.
 */
namespace Dhl\ExpressRates\Block\Adminhtml\System\Config\Form\Field;

use Dhl\ExpressRates\Model\Config\ModuleConfig;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;

/**
 * Class CustomInformation
 *
 * @package   Dhl\ExpressRates\Block\Adminhtml
 * @author    Ronny Gertler <ronny.gertler@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link      http://www.netresearch.de/
 */
class CustomInformation extends Field
{
    /**
     * @var ModuleConfig
     */
    private $moduleConfig;

    /**
     * CustomInformation constructor.
     *
     * @param Context      $context
     * @param ModuleConfig $moduleConfig
     */
    public function __construct(
        Context $context,
        ModuleConfig $moduleConfig
    ) {
        $this->moduleConfig = $moduleConfig;

        parent::__construct($context);
    }

    /**
     * @param AbstractElement $element
     *
     * @return string
     * @throws LocalizedException
     */
    public function render(AbstractElement $element)
    {
        $moduleVersion = $this->moduleConfig->getVersion();
        $logo          = $this->getViewFileUrl('Dhl_ExpressRates::images/logo.svg');

        $html = $this->getLayout()
            ->createBlock(Template::class)
            ->setModuleVersion($moduleVersion)
            ->setLogo($logo)
            ->setTemplate('Dhl_ExpressRates::system/config/customInformation.phtml')
            ->toHtml();

        return $html;
    }
}
