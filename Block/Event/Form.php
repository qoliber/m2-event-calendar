<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\EventCalendar\Block\Event;

use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Directory\Model\ResourceModel\Country\CollectionFactory;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;

class Form extends Template
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Directory\Model\ResourceModel\Country\CollectionFactory $countryCollectionFactory
     * @param \Magento\Directory\Helper\Data $directoryHelper
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        protected Context $context,
        protected CollectionFactory $countryCollectionFactory,
        protected DirectoryHelper $directoryHelper,
        protected StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
    }

    /**
     * Get Country Options
     *
     * @return string[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCountryOptions(): array
    {
        return $this->countryCollectionFactory->create()->loadByStore(
            $this->storeManager->getStore()->getId()
        )->toOptionArray(__('Select Country')->getText());
    }
}
