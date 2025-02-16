<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\EventCalendar\Model\ResourceModel\Event;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Qoliber\EventCalendar\Model\Event;

class Collection extends AbstractCollection
{
    /**
     * Construct _ implementation, init resource model and model classes
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(Event::class, \Qoliber\EventCalendar\Model\ResourceModel\Event::class);
    }
}
