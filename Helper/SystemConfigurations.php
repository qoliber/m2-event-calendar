<?php declare(strict_types=1);

namespace Qoliber\EventCalendar\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class SystemConfigurations extends AbstractHelper
{
    public const XML_PATH_EVENTS_GENERAL = 'qoliber_event_calendar/general/';
    public const XML_PATH_EVENTS_GENERAL_ENABLE_FOR_CUSTOMER_GROUPS = 'enable_for_customer_groups';
    public const XML_PATH_EVENTS_GENERAL_MEMBERSHIP_NOTICE = 'membership_notice';

    /**
     * Get config value by field
     *
     * @param string $field
     * @param mixed|null $storeId
     * @return mixed
     */
    public function getConfigValue(string $field, mixed $storeId = null): mixed
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_EVENTS_GENERAL . $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Returns empty or a list of customer group
     *
     * @return mixed
     */
    public function getEnableForCustomerGroups(): mixed
    {
        return $this->getConfigValue(self::XML_PATH_EVENTS_GENERAL_ENABLE_FOR_CUSTOMER_GROUPS);
    }

    /**
     * Returns membership notice for not eligible customer groups
     *
     * @return mixed
     */
    public function getMembershipNotice(): mixed
    {
        return $this->getConfigValue(self::XML_PATH_EVENTS_GENERAL_MEMBERSHIP_NOTICE);
    }
}
