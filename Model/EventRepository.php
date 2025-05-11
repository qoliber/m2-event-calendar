<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

namespace Qoliber\EventCalendar\Model;

use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Qoliber\EventCalendar\Api\Data\EventInterface;
use Qoliber\EventCalendar\Api\Data\EventSearchResultsInterface;
use Qoliber\EventCalendar\Api\Data\EventSearchResultsInterfaceFactory;
use Qoliber\EventCalendar\Api\EventRepositoryInterface;
use Qoliber\EventCalendar\Model\ResourceModel\Event as ResourceEvent;
use Qoliber\EventCalendar\Model\ResourceModel\Event\CollectionFactory as EventCollectionFactory;

class EventRepository implements EventRepositoryInterface
{
    /**
     * @param \Qoliber\EventCalendar\Model\ResourceModel\Event $resource
     * @param \Qoliber\EventCalendar\Model\EventFactory $eventFactory
     * @param \Qoliber\EventCalendar\Model\ResourceModel\Event\CollectionFactory $eventCollectionFactory
     * @param \Qoliber\EventCalendar\Api\Data\EventSearchResultsInterfaceFactory $searchResultsFactory
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     * @param \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        private readonly ResourceEvent $resource,
        private readonly EventFactory $eventFactory,
        private readonly EventCollectionFactory $eventCollectionFactory,
        private readonly EventSearchResultsInterfaceFactory $searchResultsFactory,
        private readonly CollectionProcessorInterface $collectionProcessor,
        private readonly JoinProcessorInterface $extensionAttributesJoinProcessor,
        private readonly ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
    }

    /**
     * Save Event
     *
     * @param \Qoliber\EventCalendar\Api\Data\EventInterface $entity
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(EventInterface $entity): EventInterface
    {
        $eventData = $this->extensibleDataObjectConverter->toNestedArray(
            $entity,
            [],
            EventInterface::class
        );

        // Convert active to integer if it's a string
        if (isset($eventData['active']) && is_string($eventData['active'])) {
            $eventData['active'] = (int)$eventData['active'];
        }

        $eventModel = $this->eventFactory->create()->setData($eventData);

        try {
            $this->resource->save($eventModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the event: %1',
                $exception->getMessage()
            ));
        }

        return $eventModel->getDataModel();
    }

    /**
     * Get Event by ID
     *
     * @param int $id
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get(int $id): EventInterface
    {
        $event = $this->eventFactory->create();
        $this->resource->load($event, $id);

        if (!$event->getId()) {
            throw new NoSuchEntityException(__('Event with id "%1" does not exist.', $id));
        }

        return $event->getDataModel();
    }

    /**
     * Get List
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Qoliber\EventCalendar\Api\Data\EventSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria): EventSearchResultsInterface
    {
        $collection = $this->eventCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            EventInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Get active events
     *
     * @return \Magento\Framework\DataObject[]
     */
    public function getActiveEvents(): array
    {
        $collection = $this->eventCollectionFactory->create();
        $collection->addFieldToFilter('active', ['eq' => 1]);

        return $collection->getItems();
    }

    /**
     * Delete Event By Entity
     *
     * @param \Qoliber\EventCalendar\Api\Data\EventInterface $entity
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(EventInterface $entity): bool
    {
        try {
            $eventModel = $this->eventFactory->create();
            $this->resource->load($eventModel, $entity->getEntityId());
            $this->resource->delete($eventModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Event: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * Delete Event By ID
     *
     * @param int $id
     * @return bool
     *
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById(int $id): bool
    {
        return $this->delete($this->get($id));
    }
}
