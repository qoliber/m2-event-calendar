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
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Qoliber\EventCalendar\Api\EventRepositoryInterface;
use Qoliber\EventCalendar\Model\EventFactory;

class Save extends Action
{
    /** @var string  */
    public const ADMIN_RESOURCE = 'Qoliber_EventCalendar::Event_save';

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Qoliber\EventCalendar\Api\EventRepositoryInterface $repository
     * @param \Qoliber\EventCalendar\Model\EventFactory $modelFactory
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        protected Context $context,
        private readonly EventRepositoryInterface $repository,
        private readonly EventFactory $modelFactory,
        private readonly DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute(): ResponseInterface|ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getParams();

        if ($data) {
            $id = $this->getRequest()->getParam('entity_id');

            $model = $this->modelFactory->create()->getDataModel();

            if ($id) {
                $model = $this->repository->get((int) $id);
            }

            if (isset($data['logo']) && is_array($data['logo'])) {
                if (isset($data['logo'][0]['name'])) {
                    $data['logo'] = sprintf('events/%s', $data['logo'][0]['name']);
                } else {
                    $data['logo'] = '';
                }
            }

            $model->addData($data); // @phpstan-ignore-line
            try {
                $model = $this->repository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the event.')->render());
                $this->dataPersistor->clear('event');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['entity_id' => $model->getEntityId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('Something went wrong while saving the event. %1', $e->getMessage())->render()
                );
            }

            $this->dataPersistor->set('event', $data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
