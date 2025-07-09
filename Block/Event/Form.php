<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\EventCalendar\Block\Event;

use Exception;
use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Directory\Model\ResourceModel\Country\CollectionFactory;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Qoliber\EventCalendar\Helper\SystemConfigurations;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Customer\Model\Context as CustomerContext;

class Form extends Template
{
    /**
     * @param Context $context
     * @param CollectionFactory $countryCollectionFactory
     * @param DirectoryHelper $directoryHelper
     * @param StoreManagerInterface $storeManager
     * @param SystemConfigurations $systemConfigurations
     * @param LoggerInterface $logger
     * @param HttpContext $httpContext
     */
    public function __construct(
        protected Context $context,
        protected CollectionFactory $countryCollectionFactory,
        protected DirectoryHelper $directoryHelper,
        protected StoreManagerInterface $storeManager,
        protected readonly SystemConfigurations $systemConfigurations,
        protected LoggerInterface $logger,
        protected readonly HttpContext $httpContext,
    ) {
        parent::__construct($context);
    }

    /**
     * Returns membership notice for not eligible customer groups
     *
     * @return mixed
     */
    public function getMembershipNotice(): mixed
    {
        return $this->systemConfigurations->getMembershipNotice();
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
            $groupConfig = $this->systemConfigurations->getEnableForCustomerGroups();

            if ($groupConfig === null) {
                return true;
            }

            $allowedGroupIds = trim($this->systemConfigurations->getEnableForCustomerGroups(), ',');
            $allowedGroupIds = explode(',', $allowedGroupIds);
            $currentGroupId = $this->httpContext->getValue(CustomerContext::CONTEXT_GROUP);

            return in_array($currentGroupId, $allowedGroupIds);
        } catch (Exception $e) {
            $this->logger->error(__METHOD__ . ': ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get Country Options
     *
     * @return string[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCountryOptions(): array
    {
        return $this->countryCollectionFactory->create()->loadByStore(
            $this->storeManager->getStore()->getId()
        )->toOptionArray(__('Select Country')->getText());
    }
}
