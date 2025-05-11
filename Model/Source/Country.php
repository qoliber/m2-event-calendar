<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\EventCalendar\Model\Source;

use Magento\Directory\Model\ResourceModel\Country\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

class Country implements OptionSourceInterface
{
    /**
     * @param CollectionFactory $countryCollectionFactory
     */
    public function __construct(
        private readonly CollectionFactory $countryCollectionFactory
    ) {
    }

    /**
     * Get options
     *
     * @return mixed[]
     */
    public function toOptionArray(): array
    {
        $options = [];
        $collection = $this->countryCollectionFactory->create();

        foreach ($collection as $country) {
            $options[] = [
                'value' => $country->getCountryId(),
                'label' => $country->getName()
            ];
        }

        return $options;
    }
}
