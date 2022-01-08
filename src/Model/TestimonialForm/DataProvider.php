<?php

namespace PauloVictorDev\Testimonials\Model\TestimonialForm;

use PauloVictorDev\Testimonials\Model\Image;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\App\Request\DataPersistorInterface;
use PauloVictorDev\Testimonials\Model\ResourceModel\TestimonialForm\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /** @var array */
    protected $loadedData;

    /** @var DataPersistorInterface */
    protected $dataPersistor;

    /** @var Image  */
    protected $imageModel;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        Image $imageModel,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->imageModel = $imageModel;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $imagePath = $item->getData('image');
            if (!empty($imagePath)) {
                $image = $this->imageModel->getImageFile($imagePath);
                $item['image'] = $image;
            }
            $this->loadedData[$item->getId()]['testimonial'] = $item->getData();
        }

        $data = $this->dataPersistor->get('testimonialform_data');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data->getData());
            $this->loadedData[$model->getId()]['testimonial'] = $model->getData();
            $this->dataPersistor->clear('testimonialform_data');
        }

        return $this->loadedData;
    }
}
