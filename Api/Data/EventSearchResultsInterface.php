<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\EventCalendar\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface EventSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get Items
     *
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface[]
     */
    public function getItems();

    /**
     * Set Items
     *
     * @param \Qoliber\EventCalendar\Api\Data\EventInterface[] $items
     */
    public function setItems(array $items);
}
