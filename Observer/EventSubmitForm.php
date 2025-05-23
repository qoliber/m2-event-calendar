<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\EventCalendar\Observer;

use Laminas\Stdlib\Parameters;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\Message\ManagerInterface;
use Qoliber\EventCalendar\Api\EventRepositoryInterface;
use Qoliber\EventCalendar\Model\EventFactory;
use Psr\Log\LoggerInterface;

class EventSubmitForm implements ObserverInterface
{
    /**
     * @param \Magento\Framework\File\UploaderFactory $uploaderFactory
     * @param \Qoliber\EventCalendar\Model\EventFactory $eventFactory
     * @param \Qoliber\EventCalendar\Api\EventRepositoryInterface $eventRepository
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        private readonly UploaderFactory $uploaderFactory,
        private readonly EventFactory $eventFactory,
        private readonly EventRepositoryInterface $eventRepository,
        private readonly Filesystem $filesystem,
        private readonly ManagerInterface $messageManager,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Execute Observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @throws \Exception
     */
    public function execute(Observer $observer): void
    {
        /** @var \Magento\Framework\App\RequestInterface $request */
        $request = $observer->getRequest();
        $params = $request->getParams();

        if (!$params) {
            return;
        }

        try {
            $this->saveEvent($params, $request->getFiles());
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage(
                __('There was an error saving your event: %1', $e->getMessage())->render()
            );
        } catch (\Throwable $e) {
            $this->messageManager->addErrorMessage(
                __('There was an error saving your event: %1', $e->getMessage())->render()
            );
        }
    }

    /**
     * Process event logo
     *
     * @param \Laminas\Stdlib\Parameters $files
     * @return string|null
     * @throws \Exception
     */
    private function processLogo(Parameters $files): ?string
    {
        $logo = $files->get('event_logo');

        if ($logo && $logo['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploader = $this->uploaderFactory->create(['fileId' => 'event_logo']);
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png', 'svg', 'webp']);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(false);

            $path = $this->filesystem
                ->getDirectoryRead(DirectoryList::MEDIA)
                ->getAbsolutePath('events');
            $uploader->save($path);

            return sprintf('events/%s', $uploader->getUploadedFileName());
        }

        return null;
    }

    /**
     * Save Event
     *
     * @param array<mixed> $params
     * @param \Laminas\Stdlib\Parameters $files
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Exception
     */
    private function saveEvent(array $params, Parameters $files): void
    {
        $logoPath = $this->processLogo($files);

        // Handle logo
        if (!empty($params['remove_logo'])) {
            $params['logo'] = '';
        } else {
            $params['logo'] = $logoPath ?? ($params['logo'] ?? '');
        }

        $params['event_name'] = strip_tags($params['event_name'] ?? '');
        $params['address_details'] = strip_tags($params['address_details'] ?? '');

        try {
            $this->logger->info('Saving event', ['params' => $params]);
            $event = !empty($params['entity_id'])
                ? $this->eventRepository->get((int)$params['entity_id'])
                : $this->eventFactory->create()->getDataModel();

            $event->addData($params);
            $this->eventRepository->save($event);
            $this->messageManager->addSuccessMessage(__('Your event has been saved.')->render());
        } catch (\Exception $e) {
            throw new LocalizedException(__('Could not save the event: %1', $e->getMessage()));
        }
    }
}
