<?php
/**
 * See LICENSE.md for license details.
 */
namespace Dhl\ExpressRates\Block\Adminhtml\System\Config\Form\Field;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\View\Asset\Repository;
use Magento\Framework\Module\ModuleList;

/**
 * Class CustomInformation
 *
 * @package Dhl\ExpressRates\Block\Adminhtml
 * @author Ronny Gertler <ronny.gertler@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link http://www.netresearch.de/
 */
class CustomInformation extends Field
{

    /**
     * @var ModuleList
     */
    private $moduleList;

    /**
     * CustomInformation constructor.
     *
     * @param Context    $context
     * @param Repository $repository
     * @param ModuleList $moduleList
     */
    public function __construct(Context $context, ModuleList $moduleList)
    {
        $this->moduleList = $moduleList;

        parent::__construct($context);
    }


    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     *
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $moduleVersion = $this->moduleList->getOne('Dhl_ExpressRates')['setup_version'];
        $logo          = $this->getViewFileUrl('Dhl_ExpressRates::images/logo.svg');

        $html = $this->getLayout()
            ->createBlock(\Magento\Framework\View\Element\Template::class)
            ->setModuleVersion($moduleVersion)
            ->setLogo($logo)
            ->setTemplate('Dhl_ExpressRates::system/config/customInformation.phtml')
            ->toHtml();

        return $html;
    }
}
