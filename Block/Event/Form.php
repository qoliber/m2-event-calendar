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

use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Directory\Model\ResourceModel\Country\CollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Qoliber\EventCalendar\Api\Data\EventInterface;
use Qoliber\EventCalendar\Helper\SystemConfigurations;
use Qoliber\EventCalendar\Model\CurrentEvent;
use Qoliber\EventCalendar\Model\Data\Event;

class Form extends Template
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Directory\Model\ResourceModel\Country\CollectionFactory $countryCollectionFactory
     * @param \Magento\Directory\Helper\Data $directoryHelper
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Qoliber\EventCalendar\Helper\SystemConfigurations $systemConfigurations
     * @param \Qoliber\EventCalendar\Model\CurrentEvent $currentEvent
     */
    public function __construct(
        protected Context $context,
        protected CollectionFactory $countryCollectionFactory,
        protected DirectoryHelper $directoryHelper,
        protected StoreManagerInterface $storeManager,
        protected readonly SystemConfigurations $systemConfigurations,
        private readonly CurrentEvent $currentEvent
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
        return $this->systemConfigurations->checkIfCurrentCustomerIsEligible();
    }

    /**
     * Get current event if available
     *
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface|\Qoliber\EventCalendar\Model\Data\Event|null
     */
    public function getCurrentEvent(): EventInterface|Event|null
    {
        return $this->currentEvent->getCurrentEvent();
    }

    /**
     * Check if method has value and set default if none
     *
     * @param mixed|null $data
     * @return mixed
     */
    public function getDataValue(mixed $data = null): mixed
    {
        return $data ?: '';
    }

    /**
     * Remove time in date
     *
     * @param String|null $date
     * @return string
     */
    public function getDateOnly(String|null $date): string
    {
        return $date ? explode(' ', $date)[0] : '';
    }

    /**
     * Get Logo URL
     *
     * @param string|null $logoUrl
     * @return string|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getLogoUrl(?string $logoUrl): ?string
    {
        return $this->systemConfigurations->getEventLogoUrl($logoUrl);
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
