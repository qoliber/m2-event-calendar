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

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Qoliber\EventCalendar\Api\EventRepositoryInterface;
use Qoliber\EventCalendar\Model\EventFactory;

class EventSubmitForm implements ObserverInterface
{
    /**
     * @param \Magento\Framework\File\UploaderFactory $uploaderFactory
     * @param \Qoliber\EventCalendar\Model\EventFactory $eventFactory
     * @param \Qoliber\EventCalendar\Api\EventRepositoryInterface $eventRepository
     * @param \Magento\Framework\Filesystem $filesystem
     */
    public function __construct(
        protected UploaderFactory $uploaderFactory,
        protected EventFactory $eventFactory,
        protected EventRepositoryInterface $eventRepository,
        private readonly Filesystem $filesystem,
    ) {
    }

    /**
     * Execute Observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        /** @var \Magento\Framework\App\RequestInterface $request */
        $request = $observer->getRequest();
        $eventLogo = '';

        if ($request->getParams()) {
            // @phpstan-ignore-next-line
            $eventPicture = $request->getFiles()['event_logo'] ?? null;

            if (isset($eventPicture) && $eventPicture['error'] !== UPLOAD_ERR_NO_FILE) {
                $uploader = $this->uploaderFactory->create(['fileId' => 'event_logo']);
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png', 'svg']);
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);
                $path = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('events');
                $uploader->save($path);
                $eventLogo = sprintf('events/%s', $uploader->getUploadedFileName());
            }

            $event = $this->eventFactory->create();
            $event->setData($request->getParams());
            $event->setLogo($eventLogo);
            $this->eventRepository->save($event->getDataModel());
        }
    }
}
