<?php declare(strict_types=1);

namespace Qoliber\EventCalendar\Controller\MyEvents;

use Magento\Customer\Controller\AccountInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Page\Config;
use Magento\Framework\View\Result\PageFactory;

class Index implements HttpGetActionInterface, AccountInterface
{
    /**
     * @param PageFactory $resultPageFactory
     * @param Config $pageConfig
     */
    public function __construct(
        private readonly PageFactory $resultPageFactory,
        private readonly Config $pageConfig
    ) {
    }

    /**
     * Execute My Events List
     *
     * @return ResultInterface|null
     */
    public function execute(): ?ResultInterface
    {
        $this->pageConfig->getTitle()->set(__('My Events'));

        return $this->resultPageFactory->create();
    }
}
