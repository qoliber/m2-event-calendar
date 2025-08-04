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

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Page\Config;
use Magento\Framework\View\Result\PageFactory;
use Magento\Customer\Controller\AccountInterface;

class Index implements HttpGetActionInterface, AccountInterface
{
    /**
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\View\Page\Config $pageConfig
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        protected PageFactory $resultPageFactory,
        protected Config $pageConfig,
        private readonly ScopeConfigInterface $scopeConfig,
    ) {
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface|null
     */
    public function execute(): ?ResultInterface
    {
        $this->pageConfig->setMetaTitle($this->scopeConfig->getValue('qoliber_event_calendar/seo_new/meta_title'));
        $this->pageConfig->setDescription(
            $this->scopeConfig->getValue('qoliber_event_calendar/seo_new/meta_description')
        );
        $this->pageConfig->setKeywords($this->scopeConfig->getValue('qoliber_event_calendar/seo_new/meta_keywords'));
        $this->pageConfig->getTitle()->set($this->scopeConfig->getValue('qoliber_event_calendar/seo_new/meta_title'));

        return $this->resultPageFactory->create();
    }
}
