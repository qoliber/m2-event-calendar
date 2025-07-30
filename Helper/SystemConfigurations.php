<?php declare(strict_types=1);

namespace Qoliber\EventCalendar\Helper;

use Exception;
use Magento\Customer\Model\Context as CustomerContext;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Http\Context as HttpContext;
use Psr\Log\LoggerInterface;
use Magento\Store\Model\StoreManagerInterface;

class SystemConfigurations extends AbstractHelper
{
    public const XML_PATH_EVENTS_GENERAL = 'qoliber_event_calendar/general/';
    public const XML_PATH_EVENTS_GENERAL_ENABLE_FOR_CUSTOMER_GROUPS = 'enable_for_customer_groups';
    public const XML_PATH_EVENTS_GENERAL_MEMBERSHIP_NOTICE = 'membership_notice';

    /**
     * @param \Magento\Framework\App\Http\Context $httpContext
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        private readonly HttpContext $httpContext,
        private readonly LoggerInterface $logger,
        private readonly StoreManagerInterface $storeManager,
        Context $context
    ) {
        parent::__construct($context);
    }

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

    /**
     * Check if current session is logged in and check customer group if eligible
     *
     * @return bool|null
     */
    public function checkIfCurrentCustomerIsEligible(): ?bool
    {
        if (!$this->httpContext->getValue(CustomerContext::CONTEXT_AUTH)) {
            return false;
        }

        try {
            $groupConfig = $this->getEnableForCustomerGroups();

            if ($groupConfig === null) {
                return true;
            }

            $allowedGroupIds = trim($this->getEnableForCustomerGroups(), ',');
            $allowedGroupIds = explode(',', $allowedGroupIds);
            $currentGroupId = $this->httpContext->getValue(CustomerContext::CONTEXT_GROUP);

            return in_array($currentGroupId, $allowedGroupIds);
        } catch (Exception $e) {
            $this->logger->error(__METHOD__ . ': ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get Logo URL
     *
     * @param string|null $logo
     * @return string|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getEventLogoUrl(?string $logo): ?string
    {
        $mediaBaseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

        return $logo ? sprintf('%s/%s', $mediaBaseUrl, $logo) : null;
    }
}
