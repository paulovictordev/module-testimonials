<?php

namespace PauloVictorDev\Testimonials\Model;

use Magento\Framework\Filesystem;
use Magento\Framework\File\Uploader;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;

class Image
{
    const IMAGE_PATH = 'testimonials/image';
    const IMAGE_TMP_PATH = 'testimonials/tmp/image';

    /** @var UploaderFactory  */
    protected $uploaderFactory;

    /** @var Filesystem  */
    protected $filesystem;

    /** @var StoreManagerInterface  */
    protected $storeManager;

    public function __construct(
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem,
        StoreManagerInterface $storeManager
    ) {
        $this->uploaderFactory = $uploaderFactory;
        $this->filesystem = $filesystem;
        $this->storeManager = $storeManager;
    }

    /**
     * @param string $input
     * @return string|null
     * @throws \Exception
     */
    public function uploadFile(string $input): ?string
    {
        try {
            $uploader = $this->uploaderFactory->create(['fileId' => $input]);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(false);
            $uploader->setAllowCreateFolders(true);
            $uploader->setAllowedExtensions(['jpg','jpeg','png']);

            $mediaWrite = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
            $mediaRead = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);

            $basePath = $mediaRead->getAbsolutePath(self::IMAGE_PATH);

            if (!is_dir($basePath)) {
                $mediaWrite->create($basePath);
            }

            $result = $uploader->save($basePath);
            return 'testimonials/image/' . $result['file'];
        } catch (\Exception $e) {
            if ($e->getCode() == Uploader::TMP_NAME_EMPTY) {
                return '';
            }

            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param string $imagePath
     * @throws \Exception
     */
    public function deleteFile(string $imagePath): void
    {
        try {
            $mediaWrite = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
            $pathImageDelete = $mediaWrite->getAbsolutePath($imagePath);

            if (is_file($pathImageDelete)) {
                $mediaWrite->delete($pathImageDelete);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param string $imageName
     * @return string|null
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function saveFile(string $imageName): ?string
    {
        $mediaWrite = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $mediaRead = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);

        $imagePath = $mediaRead->getAbsolutePath(self::IMAGE_PATH);

        if ($mediaWrite->isExist($mediaRead->getAbsolutePath(self::IMAGE_PATH . '/' . $imageName))) {
            return $mediaRead->getRelativePath(self::IMAGE_PATH . '/' . $imageName);
        }

        if (!is_dir($imagePath)) {
            $mediaWrite->create($imagePath);
        }

        $imageTmpPath = $mediaRead->getAbsolutePath(self::IMAGE_TMP_PATH . '/' . $imageName);
        $newImagePath = $imagePath . '/' . time() . '_' . $imageName;

        if ($mediaWrite->isExist($imageTmpPath)) {
            $mediaWrite->copyFile($imageTmpPath, $newImagePath);
            $mediaWrite->delete($imageTmpPath);
            return $mediaRead->getRelativePath($newImagePath);
        }

        return $mediaRead->getRelativePath($newImagePath);
    }

    /**
     * @param string $pathImage
     * @return array|array[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getImageFile(string $pathImage): array
    {
        $mediaRead = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);

        if (!$mediaRead->isExist($pathImage)) {
            return [];
        }

        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        $filePath = $mediaRead->getRelativePath($pathImage);

        $ultimaBarra = strrpos($pathImage, '/');
        $nomeArquivo = substr($pathImage, $ultimaBarra + 1);

        $imageUrl = $mediaUrl . $filePath;

        return [
            [
                'name' => $nomeArquivo,
                'url' => $imageUrl
            ]
        ];
    }
}
