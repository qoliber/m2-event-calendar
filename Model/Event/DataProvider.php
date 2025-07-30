<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\EventCalendar\Model\Event;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Qoliber\EventCalendar\Controller\Adminhtml\Event\Upload;
use Qoliber\EventCalendar\Model\FileInfo;
use Qoliber\EventCalendar\Model\ResourceModel\Event\CollectionFactory;

/**
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param FileInfo $fileInfo
     * @param Filesystem $filesystem
     * @param File $fileDriver
     * @param DirectoryList $directoryList
     * @param StoreManagerInterface $storeManager
     * @param mixed[] $meta
     * @param mixed[] $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        protected FileInfo $fileInfo,
        protected Filesystem $filesystem,
        protected File $fileDriver,
        protected DirectoryList $directoryList,
        protected StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    /**
     * Get Data
     *
     * @return mixed[]
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getData(): array
    {
        $data = parent::getData();
        $path = $this->directoryList->getPath('media');
        $mediaBaseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        $items = [];

        foreach ($data['items'] as $item) {
            $items[$item['entity_id']] = $item;

            if ($item['logo'] !== null) {
                $eventLogo = sprintf('%s/%s', $path, $item['logo']);
                $stat = $this->fileInfo->getStat($eventLogo);
                $mimeType = $this->fileInfo->getMimeType($eventLogo);
                $items[$item['entity_id']]['logo'] = [
                    [
                        // phpcs:ignore Magento2.Functions.DiscouragedFunction
                        'name' => basename($eventLogo),
                        'url' =>  sprintf(
                            '%s/%s',
                            $mediaBaseUrl,
                            $item['logo']
                        ),
                        'size' => $stat['size'],
                        'type' => $mimeType,
                    ]
                ];
            }
        }

        return $items;
    }
}
