<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\EventCalendar\Controller\Adminhtml\Event;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Qoliber\EventCalendar\Model\ResourceModel\Event\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends Action implements HttpPostActionInterface
{
    /** @var string  */
    public const ADMIN_RESOURCE = 'Qoliber_EventCalendar::Event_delete';

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Qoliber\EventCalendar\Model\ResourceModel\Event\CollectionFactory $collectionFactory
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     */
    public function __construct(
        Context $context,
        private readonly CollectionFactory $collectionFactory,
        private readonly Filter $filter
    ) {
        parent::__construct($context);
    }

    /**
     * Execute Controller
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(): Redirect
    {
        $collection = $this->collectionFactory->create();
        $items = $this->filter->getCollection($collection);
        $itemsSize = $items->getSize();

        foreach ($items as $item) {
            $item->delete();
        }

        // @phpstan-ignore-next-line
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $itemsSize));
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        // @phpstan-ignore-next-line
        return $redirect->setPath('*/*');
    }
}
