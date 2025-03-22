<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\EventCalendar\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Qoliber\EventCalendar\Api\Data\EventInterface;
use Qoliber\EventCalendar\Generator\UuidGenerator;
use Ramsey\Uuid\Uuid;

class Event extends AbstractDb
{
    /** @var string  */
    public const MAIN_TABLE = 'qoliber_events';

    /** @var string  */
    public const ID_FIELD_NAME = 'event_id';

    /**
     * Perform actions before entity save
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(AbstractModel $object): Event
    {
        if (!$object->getId() || $object->getData(EventInterface::UUID) == "") {
            $object->setData(EventInterface::UUID, Uuid::uuid4());
        }

        parent::save($object);

        return $this;
    }

    /**
     * _Construct Implementation
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(self::MAIN_TABLE, self::ID_FIELD_NAME);
    }
}
