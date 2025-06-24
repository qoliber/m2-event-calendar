<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\EventCalendar\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\DataObject;
use Qoliber\EventCalendar\Api\Data\EventInterface;
use Qoliber\EventCalendar\Api\Data\EventSearchResultsInterface;

interface EventRepositoryInterface
{
    /**
     * Get Event
     *
     * @param int $id
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function get(int $id): EventInterface;

    /**
     * Get List of Events
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Qoliber\EventCalendar\Api\Data\EventSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria): EventSearchResultsInterface;

    /**
     * Get active events
     *
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface[]
     */
    public function getActiveEvents(): array;

    /**
     * Save Event
     *
     * @param \Qoliber\EventCalendar\Api\Data\EventInterface $entity
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function save(EventInterface $entity): EventInterface;

    /**
     * Delete Event
     *
     * @param \Qoliber\EventCalendar\Api\Data\EventInterface $entity
     * @return bool
     */
    public function delete(EventInterface $entity): bool;

    /**
     * Delete Event By Id
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;
}
