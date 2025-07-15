<?php declare(strict_types=1);

namespace Qoliber\EventCalendar\Model;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Qoliber\EventCalendar\Api\Data\EventInterface;
use Qoliber\EventCalendar\Model\Data\Event;
use Qoliber\EventCalendar\Model\EventRepository;
use Psr\Log\LoggerInterface;

class CurrentEvent
{
    public const PARAM_EVENT = 'event_id';

    /**
     * @var Event|null
     */
    public ?Event $event = null;

    /**
     * @param RequestInterface $request
     * @param EventRepository $eventRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly RequestInterface $request,
        private readonly EventRepository $eventRepository,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Get current event
     *
     * @return EventInterface|Event|null
     */
    public function getCurrentEvent(): EventInterface|Event|null
    {
        $eventId = $this->request->getParam(self::PARAM_EVENT);

        try {
            if (!$this->event && $eventId) {
                $this->event = $this->eventRepository->get((int) $eventId);
            }
        } catch (NoSuchEntityException $e) {
            $this->logger->error(__METHOD__ . ': ' . $e->getMessage());
        }

        return $this->event;
    }
}
