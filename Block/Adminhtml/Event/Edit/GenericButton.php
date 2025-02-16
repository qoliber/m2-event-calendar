<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\EventCalendar\Block\Adminhtml\Event\Edit;

use Magento\Backend\Block\Widget\Context;
use Qoliber\EventCalendar\Api\EventRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    /** @var \Magento\Backend\Block\Widget\Context  */
    protected Context $context;

    /** @var \Qoliber\EventCalendar\Api\EventRepositoryInterface  */
    protected EventRepositoryInterface $repository;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Qoliber\EventCalendar\Api\EventRepositoryInterface $repository
     */
    public function __construct(
        Context $context,
        EventRepositoryInterface $repository
    ) {
        $this->context = $context;
        $this->repository = $repository;
    }

    /**
     * Get Id
     *
     * @return int|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getId(): ?int
    {
        $id = (int) $this->context->getRequest()->getParam('entity_id');
        if (!$id) {
            return null;
        }

        try {
            return $this->repository->get($id)->getEntityId();
        } catch (NoSuchEntityException $e) {
            throw new NoSuchEntityException(__($e->getMessage()));
        }
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param mixed[] $params
     * @return string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
