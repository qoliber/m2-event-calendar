<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\EventCalendar\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Qoliber\EventCalendar\Api\Data\EventInterface;
use Qoliber\EventCalendar\Api\Data\EventInterfaceFactory;

class Event extends AbstractModel
{
    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \Qoliber\EventCalendar\Api\Data\EventInterfaceFactory $eventDataFactory
     * @param \Qoliber\EventCalendar\Model\ResourceModel\Event $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param mixed[] $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        private readonly DataObjectHelper $dataObjectHelper,
        private readonly EventInterfaceFactory $eventDataFactory,
        ResourceModel\Event $resource,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Get DataModel
     *
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function getDataModel(): EventInterface
    {
        $data = $this->getData();

        $dataObject = $this->eventDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $dataObject,
            $data,
            EventInterfaceFactory::class
        );

        return $dataObject;
    }
}
