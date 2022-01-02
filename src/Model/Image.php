<?php

namespace PauloVictorDev\Testimonials\Model;

use Magento\Framework\File\Uploader;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\UploaderFactory;

class Image
{
    const IMAGE_PATH = 'testimonials/image';

    /** @var UploaderFactory  */
    protected $uploaderFactory;

    /** @var Filesystem  */
    protected $filesystem;

    public function __construct(
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem
    ) {
        $this->uploaderFactory = $uploaderFactory;
        $this->filesystem = $filesystem;
    }

    public function uploadFile(string $input): ?string
    {
        try {
            $uploader = $this->uploaderFactory->create(['fileId' => $input]);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            $uploader->setAllowCreateFolders(true);
            $uploader->setAllowedExtensions(['jpg','jpeg','png']);

            $mediaWrite = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
            $mediaRead = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);

            $basePath = $mediaRead->getAbsolutePath() . self::IMAGE_PATH;

            if (!is_dir($basePath)) {
                $mediaWrite->create($basePath);
            }

            $result = $uploader->save($basePath);
            return $result['file'];
        } catch (\Exception $e) {
            if ($e->getCode() == Uploader::TMP_NAME_EMPTY) {
                return '';
            }

            throw new \Exception($e->getMessage());
        }
    }

    public function deleteFile(string $imagePath): void
    {
        try {
            $mediaWrite = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
            $pathImageDelete = $mediaWrite->getAbsolutePath(self::IMAGE_PATH . $imagePath);

            if (is_file($pathImageDelete)) {
                $mediaWrite->delete($pathImageDelete);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}