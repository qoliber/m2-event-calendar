<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

namespace Qoliber\EventCalendar\Controller\Adminhtml\Event;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\UrlInterface;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Backend\App\Action;
use Magento\Store\Model\StoreManagerInterface;

class Upload extends Action
{
    /** @var string  */
    public const EVENTS_IMAGES_DIRECTORY = 'events';

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
     * @param \Magento\Framework\App\Filesystem\DirectoryList $directoryList
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        Action\Context $context,
        protected UploaderFactory $fileUploaderFactory,
        protected DirectoryList $directoryList,
        protected StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
    }

    /**
     * Execute Contoller
     *
     * @return ResponseInterface|ResultInterface
     */
    public function execute(): ResultInterface|ResponseInterface
    {
        try {
            $fileId = $this->getRequest()->getParam('param_name', false);
            $uploader = $this->fileUploaderFactory->create(['fileId' => $fileId]);
            $uploader->setFilesDispersion(false);
            $uploader->setFilenamesCaseSensitivity(false);
            $uploader->setAllowRenameFiles(true);
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png', 'svg']);
            $path = $this->directoryList->getPath('media') . DIRECTORY_SEPARATOR . self::EVENTS_IMAGES_DIRECTORY;
            $result = $uploader->save($path);

            $mediaUrl = $this->storeManager-> getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
            $imageUrl = $mediaUrl . self::EVENTS_IMAGES_DIRECTORY . DIRECTORY_SEPARATOR . $result['file'];
            $result['url'] = $imageUrl;
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorCode' => $e->getCode()];
        }

        // @phpstan-ignore-next-line
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
