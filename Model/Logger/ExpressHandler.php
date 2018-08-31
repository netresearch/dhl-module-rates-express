<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\ExpressRates\Model\Logger;

use Dhl\ExpressRates\Model\Config\ModuleConfigInterface;
use Magento\Framework\Filesystem\DriverInterface;
use Magento\Framework\Logger\Handler\Base;

/**
 * Class ExpressHandler
 *
 * @package Dhl\ExpressRates\Model
 */
class ExpressHandler extends Base
{
    /**
     * @var ModuleConfigInterface
     */
    private $moduleConfig;

    /**
     * @var string
     */
    protected $fileName = 'var/log/dhl_express_rates.log';

    /**
     * ExpressHandler constructor.
     *
     * @param DriverInterface $filesystem
     * @param ModuleConfigInterface $config
     * @param null|string $filePath
     * @param null|string $fileName
     */
    public function __construct(
        DriverInterface $filesystem,
        ModuleConfigInterface $config,
        $filePath = null,
        $fileName = null
    ) {
        $this->moduleConfig = $config;
        parent::__construct($filesystem, $filePath, $fileName);
    }

    /**
     * @inheritdoc
     */
    public function isHandling(array $record): bool
    {
        $logEnabled = $this->moduleConfig->isLoggingEnabled();
        $logLevel = $this->moduleConfig->getLogLevel();

        return $logEnabled && $record['level'] >= $logLevel && parent::isHandling($record);
    }
}
