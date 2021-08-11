<?php

namespace Anastiuk\Vendor\Controller\Adminhtml\Vendors;

use Magento\Framework\App\Action\HttpPostActionInterface;

class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    protected $_reviewsFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context   $context,
        \Anastiuk\Vendor\Model\ReviewsFactory $reviewsFactory,
        \Magento\Framework\Image\AdapterFactory $adapterFactory,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploader,
        \Magento\Framework\Filesystem $filesystem
    )
    {
        $this->_reviewsFactory = $reviewsFactory;
        $this->_adapterFactory = $adapterFactory;
        $this->_uploader = $uploader;
        $this->_filesystem = $filesystem;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $reviewId = isset($data['vendor_id']) ? $data['vendor_id'] : '';
        if (!$data) {
            $this->_redirect('vendor/vendors/index');
        }
        try {
            $rowData = $this->_reviewsFactory->create()->load($reviewId);
            if (!$rowData->getId() && $reviewId) {
                $this->messageManager->addError(__('row data no longer exist.'));
                $this->_redirect('vendor/vendors/index');
            }
            $data = $this->_uploadLogo($data);
            $rowData->setData($data);
            $rowData->save();
            $this->messageManager->addSuccess(__('Row data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('vendor/vendors/index');
    }

    protected function _uploadLogo($data)
    {
        if (isset($_FILES['logo']) && isset($_FILES['logo']['name']) && strlen($_FILES['logo']['name'])) {
            try {
                $base_media_path = 'pub/media';
                $uploader = $this->_uploader->create(['fileId' => 'logo']);
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'png']);
                $imageAdapter = $this->_adapterFactory->create();
                $uploader->addValidateCallback('image', $imageAdapter, 'validateUploadFile');
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(true);
                $mediaDirectory = $this->_filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
                $result = $uploader->save($mediaDirectory->getAbsolutePath($base_media_path));
                $data['logo'] = $base_media_path . $result['file'];
            } catch (\Exception $e) {
                if ($e->getCode() == 0) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                }
            }
        } elseif (isset($data['logo']['delete'])) {
            $data['logo'] = '';
        } elseif (isset($data['logo']['value'])) {
            $data['logo'] = $data['logo']['value'];
        } else {
            $data['logo'] = '';
        }

        return $data;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Anastiuk_Vendor::home');
    }
}
