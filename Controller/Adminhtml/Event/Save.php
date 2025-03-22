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

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Message\ManagerInterface;
use Qoliber\EventCalendar\Api\EventRepositoryInterface;
use Qoliber\EventCalendar\Model\EventFactory;

class Save implements HttpPostActionInterface
{
    /** @var string  */
    public const ADMIN_RESOURCE = 'Qoliber_EventCalendar::Event_save';

    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory
     * @param \Qoliber\EventCalendar\Api\EventRepositoryInterface $repository
     * @param \Qoliber\EventCalendar\Model\EventFactory $modelFactory
     */
    public function __construct(
        private readonly RequestInterface $request,
        private readonly ManagerInterface $messageManager,
        private readonly RedirectFactory $resultRedirectFactory,
        private readonly EventRepositoryInterface $repository,
        private readonly EventFactory $modelFactory,
    ) {
    }

    /**
     * Execute Controller
     *
     * @return \Magento\Framework\Controller\ResultInterface|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect
     */
    public function execute(): ResultInterface|ResponseInterface|\Magento\Framework\Controller\Result\Redirect
    {
        // @phpstan-ignore-next-line
        $data = $this->request->getPostValue();
        $model = $this->modelFactory->create();

        if (isset($data['logo'][0]['name'])) {
            $data['logo'] = sprintf('events/%s', $data['logo'][0]['name']);
        }

        $model->setData($data);

        try {
            $model = $this->repository->save($model->getDataModel());
            // @phpstan-ignore-next-line
            $this->messageManager->addSuccessMessage(__('You saved the event.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $this->resultRedirectFactory->create()
            ->setPath('*/*/edit', ['event_id' => $model->getEventId()]);
    }
}
