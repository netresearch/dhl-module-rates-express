<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\ExpressRates\Model;

use Dhl\ExpressRates\Model\Config\ModuleConfigInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

/**
 * Class PickupTime
 *
 * @author Max Melzer <max.melzer@netresearch.de>
 * @package Dhl\ExpressRates\Model
 */
class PickupTime
{
    /**
     * The module configuration.
     *
     * @var ModuleConfigInterface
     */
    private $moduleConfig;

    /**
     * @var TimezoneInterface
     */
    private $timezone;

    /**
     * PickupTime constructor.
     *
     * @param ModuleConfigInterface $moduleConfig
     * @param TimezoneInterface $timezone
     */
    public function __construct(
        ModuleConfigInterface $moduleConfig,
        TimezoneInterface $timezone
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->timezone = $timezone;
    }

    /**
     * Returns the timestamp when the offer is ready. When the current time is after today's cut off time,
     * tomorrows cut off time will be returned. If it's not, today's cut off time will be returned.
     *
     * @return int
     */
    public function getReadyAtTimestamp()
    {
        $cutOffTimeRaw = explode(',', $this->moduleConfig->getCutOffTime());
        $pickUpTimeRaw = explode(',', $this->moduleConfig->getPickupTime());

        $cutOffTime = $this->timezone->date();
        $cutOffTime->setTime((int)$cutOffTimeRaw[0], (int)$cutOffTimeRaw[1], (int)$cutOffTimeRaw[2]);

        $pickUpTime = $this->timezone->date();
        $pickUpTime->setTime((int)$pickUpTimeRaw[0], (int)$pickUpTimeRaw[1], (int)$pickUpTimeRaw[2]);

        if ($this->timezone->date()->getTimestamp() >= $cutOffTime->getTimestamp()) {
            $pickUpTime->modify('+1 day');
        }

        return $pickUpTime->getTimestamp();
    }
}
