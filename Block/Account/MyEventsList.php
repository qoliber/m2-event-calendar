<?php declare(strict_types=1);

namespace Qoliber\EventCalendar\Block\Account;

use DateMalformedStringException;
use DateTime;
use DateTimeZone;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Theme\Block\Html\Pager;
use Qoliber\EventCalendar\Model\ResourceModel\Event\CollectionFactory as EventCollectionFactory;
use Qoliber\EventCalendar\Model\ResourceModel\Event\Collection as EventCollection;
use Magento\Customer\Model\Session;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Qoliber\EventCalendar\Helper\SystemConfigurations;

class MyEventsList extends Template
{
    /**
     * @var null|\Qoliber\EventCalendar\Model\ResourceModel\Event\Collection
     */
    protected ?EventCollection $events = null;

    /**
     * @param \Qoliber\EventCalendar\Model\ResourceModel\Event\CollectionFactory $eventCollectionFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     * @param \Qoliber\EventCalendar\Helper\SystemConfigurations $systemConfigurations
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        private readonly EventCollectionFactory $eventCollectionFactory,
        private readonly Session $customerSession,
        private readonly TimezoneInterface $timezone,
        private readonly SystemConfigurations $systemConfigurations,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Get Customer Events
     *
     * @return bool|\Qoliber\EventCalendar\Model\ResourceModel\Event\Collection|null
     */
    public function getCustomerEvents(): bool|EventCollection|null
    {
        if (!$this->customerSession->isLoggedIn()) {
            return false;
        }

        $customerId = $this->customerSession->getCustomerId();

        if (!$this->events) {
            $this->events = $this->eventCollectionFactory->create()->addFieldToSelect('*')
                ->addFieldToFilter('customer_id', ['in' => $customerId])
                ->setOrder('entity_id', 'desc');
        }

        return $this->events;
    }

    /**
     * Add a pager in the layout
     *
     * Declared page block in XML as creating here bloch here creates issue in hyva
     *
     * @return $this|\Qoliber\EventCalendar\Block\Account\MyEventsList
     * @throws LocalizedException
     */
    protected function _prepareLayout(): MyEventsList|static
    {
        parent::_prepareLayout();

        if ($this->getCustomerEvents()) {
            $pager = $this->getLayout()->getBlock('events.list.pager')
                ->setCollection($this->getCustomerEvents());
            $this->setChild('pager', $pager);
            $this->getCustomerEvents()->load();
        }

        return $this;
    }

    /**
     * Get Pager child block output
     *
     * @return string
     */
    public function getPagerHtml(): string
    {
        return $this->getChildHtml('pager');
    }

    /**
     * Get Event View URL
     *
     * @param mixed $eventId
     * @return string
     */
    public function getViewUrl(mixed $eventId): string
    {
        return $this->getUrl('events/myevents/edit', ['event_id' => $eventId]);
    }

    /**
     * Change date to readable format
     *
     * @param string|null $dataFrom
     * @param string|null $dataTo
     * @return string
     * @throws \DateMalformedStringException
     */
    public function changeDataToReadableFormat(?string $dataFrom, ?string $dataTo): string
    {
        $result = '';

        if ($dataFrom) {
            $date = new DateTime($dataFrom);
            $format = $date->format('F j, Y');

            $result .= $format;
        }

        if ($dataTo) {
            $date = new DateTime($dataTo);
            $format = $date->format('F j, Y');

            if ($dataFrom) {
                $result .= ' - ';
            }

            $result .= $format;
        }

        return $result;
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
}
