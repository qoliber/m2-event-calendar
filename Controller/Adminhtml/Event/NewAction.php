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
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class NewAction extends Action implements HttpGetActionInterface
{
    /** @var string  */
    public const ADMIN_RESOURCE = 'Qoliber_EventCalendar::Event_save';

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     */
    public function __construct(
        Context $context,
        private readonly PageFactory $pageFactory
    ) {
        parent::__construct($context);
    }

    /**
     * Execute Controller
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute(): Page
    {
        $page = $this->pageFactory->create();
        // @phpstan-ignore-next-line
        $page->getConfig()->getTitle()->prepend(__('New Event'));

        return $page;
    }
}
