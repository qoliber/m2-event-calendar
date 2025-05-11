<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\EventCalendar\Block;

use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Qoliber\EventCalendar\Api\EventRepositoryInterface;
use Qoliber\EventCalendar\Controller\Adminhtml\Event\Upload;

class EventList extends Template
{
    /**
     * @param \Qoliber\EventCalendar\Api\EventRepositoryInterface $eventRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
     * @param \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param mixed[] $data
     */
    public function __construct(
        protected EventRepositoryInterface $eventRepository,
        protected SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        protected SortOrderBuilder $sortOrderBuilder,
        protected Context $context,
        protected StoreManagerInterface $storeManager,
        protected array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Get List of Active Events
     *
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface[]
     */
    public function getActiveEvents(): array
    {
        return $this->eventRepository->getActiveEvents();
    }

    /**
     * Get Logo URL
     *
     * @param string|null $logo
     * @return string|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getEventLogoUrl(?string $logo): ?string
    {
        $mediaBaseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

        if ($logo) {
            return sprintf(
                '%s/%s',
                $mediaBaseUrl,
                $logo
            );
        }

        return null;
    }
}
