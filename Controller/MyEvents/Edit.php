<?php declare(strict_types=1);

namespace Qoliber\EventCalendar\Controller\MyEvents;

use Magento\Customer\Controller\AccountInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Page\Config;
use Magento\Framework\View\Result\PageFactory;
use Qoliber\EventCalendar\Model\CurrentEvent;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Message\ManagerInterface;
use Qoliber\EventCalendar\Helper\SystemConfigurations;

class Edit implements HttpGetActionInterface, AccountInterface
{
    /**
     * @param PageFactory $resultPageFactory
     * @param Config $pageConfig
     * @param CurrentEvent $currentEvent
     * @param RedirectFactory $resultRedirectFactory
     * @param ManagerInterface $messageManager
     * @param SystemConfigurations $systemConfigurations
     */
    public function __construct(
        private readonly PageFactory $resultPageFactory,
        private readonly Config $pageConfig,
        private readonly CurrentEvent $currentEvent,
        private readonly RedirectFactory $resultRedirectFactory,
        private readonly ManagerInterface $messageManager,
        private readonly SystemConfigurations $systemConfigurations
    ) {
    }

    /**
     * Execute My Events List
     *
     * @return ResultInterface|null
     */
    public function execute(): ?ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('events/myevents');

        if (!$this->systemConfigurations->checkIfCurrentCustomerIsEligible()) {
            $this->messageManager->addErrorMessage(__($this->systemConfigurations->getMembershipNotice()));
            return $resultRedirect;
        }

        if ($event = $this->currentEvent->getCurrentEvent()) {
            $this->pageConfig->getTitle()->set(__('Events - ' . $event->getEventName()));
            return $this->resultPageFactory->create();
        } else {
            $this->messageManager->addErrorMessage(__('Event not found.'));
            return $resultRedirect;
        }
    }
}
