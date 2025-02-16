<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\EventCalendar\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Qoliber\EventCalendar\Api\EventRepositoryInterface;
use Qoliber\EventCalendar\Model\EventFactory;

class EventSubmitForm implements ObserverInterface
{
    /**
     * @param \Qoliber\EventCalendar\Model\EventFactory $eventFactory
     * @param \Qoliber\EventCalendar\Api\EventRepositoryInterface $eventRepository
     */
    public function __construct(
        protected EventFactory $eventFactory,
        protected EventRepositoryInterface $eventRepository,
    ) {
    }

    /**
     * Execute Observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        /** @var \Magento\Framework\App\RequestInterface $request */
        $request = $observer->getRequest();

        if ($request->getParams()) {
            $event = $this->eventFactory->create();
            $event->setData($request->getParams());
            $this->eventRepository->save($event->getDataModel());
        }
    }
}
