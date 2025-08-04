<?php declare(strict_types=1);

namespace Qoliber\EventCalendar\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
use Magento\Framework\Exception\LocalizedException;

class Customer implements OptionSourceInterface
{
    /**
     * @param \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory
     */
    public function __construct(
        private readonly CollectionFactory $customerCollectionFactory
    ) {
    }

    /**
     * Get an option array
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function toOptionArray(): array
    {
        $options = [];
        $collection = $this->customerCollectionFactory->create();
        $collection->addAttributeToSelect(['email', 'firstname', 'lastname']);

        foreach ($collection as $customer) {
            $options[] = [
                'value' => $customer->getId(),
                'label' => sprintf(
                    '%s (%s)',
                    $customer->getEmail(),
                    $customer->getId()
                )
            ];
        }

        return $options;
    }
}
