<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\EventCalendar\Controller\New;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Event\Manager;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;

class Submit implements HttpPostActionInterface
{
    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Controller\ResultFactory $resultFactory
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Framework\Event\Manager $eventManager
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(
        protected Context $context,
        protected ResultFactory $resultFactory,
        protected ManagerInterface $messageManager,
        protected Manager $eventManager,
        protected RequestInterface $request
    ) {
    }

    /**
     * Execute method
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute(): ResultInterface
    {
        $postData = $this->request->getParams();
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        // @phpstan-ignore-next-line
        $resultRedirect->setPath('events/new', ['_secure' => true]);

        if ($postData) {
            try {
                $this->eventManager->dispatch('event_validate_recaptcha', ['request' => $this->request]);
                $this->eventManager->dispatch('event_form_submit', ['request' => $this->request]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('An error occurred: %1', $e->getMessage())->render());
            }
        } else {
            // @phpstan-ignore-next-line
            $this->messageManager->addErrorMessage(__('Empty Post Request.'));
        }

        return $resultRedirect;
    }
}
