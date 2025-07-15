<?php declare(strict_types=1);

namespace Qoliber\EventCalendar\Controller\Adminhtml\Event;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\DB\Helper as DbHelper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Controller for obtaining customer suggestions by query.
 */
class CustomerList extends Action implements HttpPostActionInterface, HttpGetActionInterface
{
    /**
     * @param Context $context
     * @param CustomerRepositoryInterface $customerRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param DbHelper $dbHelper
     */
    public function __construct(
        Context $context,
        private readonly CustomerRepositoryInterface $customerRepository,
        private readonly SearchCriteriaBuilder $searchCriteriaBuilder,
        private readonly DbHelper $dbHelper
    ) {
        parent::__construct($context);
    }

    /**
     * Execute search for customer by email
     *
     * @return Json|ResultInterface|ResponseInterface
     */
    public function execute(): Json|ResultInterface|ResponseInterface
    {
        /** @var Json $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $name = $this->getRequest()->getParam('name', '');

        try {
            $customers = $this->getSuggestedCustomer($name);

            $result->setData(
                $this->getCustomerData($customers)
            );
        } catch (LocalizedException $e) {
            $result->setData(['error' => $e->getMessage()]);
        }

        return $result;
    }

    /**
     * Get suggested customer by query.
     *
     * @param string $query
     * @return CustomerInterface[]
     * @throws LocalizedException
     */
    private function getSuggestedCustomer(string $query): array
    {
        $escapedQuery = $this->dbHelper->escapeLikeValue(
            $query,
            ['position' => 'start']
        );

        $searchCriteria = $this->searchCriteriaBuilder->addFilter(
            CustomerInterface::EMAIL,
            $escapedQuery,
            'like'
        )->create();

        $searchResult = $this->customerRepository->getList($searchCriteria);

        return $searchResult->getItems();
    }

    /**
     * Get customers data as array.
     *
     * @param CustomerInterface[] $customers
     * @return array
     */
    private function getCustomerData(array $customers): array
    {
        return array_map(
            function (CustomerInterface $customer) {
                return [
                    'id' => $customer->getId(),
                    'name' => $customer->getId() . ' - ' . $customer->getEmail(),
                ];
            },
            array_values($customers)
        );
    }
}
