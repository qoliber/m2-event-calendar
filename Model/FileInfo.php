<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\EventCalendar\Model;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\File\Mime;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\Filesystem\ExtendedDriverInterface;

class FileInfo
{
    /**
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Framework\File\Mime $mime
     * @param \Magento\Framework\Filesystem\Directory\WriteInterface|null $mediaDirectory
     */
    public function __construct(
        private readonly Filesystem $filesystem,
        private readonly Mime $mime,
        private ?WriteInterface $mediaDirectory = null
    ) {
    }

    /**
     * Get Media Directory
     *
     * @return \Magento\Framework\Filesystem\Directory\WriteInterface
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    private function getMediaDirectory(): WriteInterface
    {
        if ($this->mediaDirectory === null) {
            $this->mediaDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        }

        return $this->mediaDirectory;
    }

    /**
     * Get Mime Type
     *
     * @param string $fileName
     * @return mixed|string
     *
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function getMimeType(string $fileName): mixed
    {
        if ($this->getMediaDirectory()->getDriver() instanceof ExtendedDriverInterface) {
            // @phpstan-ignore-next-line
            return $this->mediaDirectory->getDriver()->getMetadata($fileName)['mimetype'];
        } else {
            return $this->mime->getMimeType(
                $this->getMediaDirectory()->getAbsolutePath(
                    $fileName
                )
            );
        }
    }

    /**
     * Get File Stats
     *
     * @param string $fileName
     * @return mixed[]
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function getStat(string $fileName): array
    {
        return $this->getMediaDirectory()->stat($fileName);
    }
}
