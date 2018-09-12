<?php
/**
 * See LICENSE.md for license details.
 */
namespace Dhl\ExpressRates\Model\Config\Source;

use Magento\Framework\Logger\Monolog;

/**
 * Class DebugLog
 *
 * @package Dhl\ExpressRates\Model\Backend\Config\Source
 * @author Ronny Gertler <ronny.gertler@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @link http://www.netresearch.de/
 */
class LogLevel implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            ['value' => (string)Monolog::ERROR, 'label' => 'Errors'],
            ['value' => (string)Monolog::INFO, 'label' => 'Info (Errors and Warnings)'],
            ['value' => (string)Monolog::DEBUG, 'label' => 'Debug (All API Activities)'],
        ];
    }
}
