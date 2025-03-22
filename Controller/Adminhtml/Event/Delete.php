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

use Qoliber\EventCalendar\Model\Event;
use Qoliber\EventCalendar\Model\EventFactory;
use Qoliber\EventCalendar\Model\ResourceModel\Event as ModelResource;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Delete extends Action implements HttpPostActionInterface
{
    /** @var string  */
    public const ADMIN_RESOURCE = 'Qoliber_EventCalendar::Event_delete';

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Qoliber\EventCalendar\Model\EventFactory $modelFactory
     * @param \Qoliber\EventCalendar\Model\ResourceModel\Event $modelResource
     */
    public function __construct(
        Context $context,
        protected EventFactory $modelFactory,
        protected ModelResource $modelResource
    ) {
        parent::__construct($context);
    }

    /**
     * Execute Controller
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute(): Redirect
    {
        try {
            $id = $this->getRequest()->getParam('event_id');
            /** @var Event $model */
            $model = $this->modelFactory->create();
            $this->modelResource->load($model, $id);
            if ($model->getId()) {
                $this->modelResource->delete($model);
                // @phpstan-ignore-next-line
                $this->messageManager->addSuccessMessage(__('The record has been deleted.'));
            } else {
                // @phpstan-ignore-next-line
                $this->messageManager->addErrorMessage(__('The record does not exist.'));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        /** @var Redirect $redirect */
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $redirect->setPath('*/*');
    }
}
