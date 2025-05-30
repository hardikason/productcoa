<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * @author  Sonali Kosrabe <sonali.kosrabe@outlook.com>
 */
declare(strict_types=1);

namespace SK\ProductCOA\Controller\Adminhtml\Image;

use \Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\ResultFactory;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Filesystem;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\Json;

class Upload extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * Authentication photo upload directory config
     */
    private const UPLOAD_DIR = 'catalog/productcoa/auth_images_dir';

    /**
     * Upload constructor function
     *
     * @param Context $context
     * @param UploaderFactory $uploaderFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param Filesystem $filesystem
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        protected Context $context,
        protected UploaderFactory $uploaderFactory,
        protected ScopeConfigInterface $scopeConfig,
        protected Filesystem $filesystem,
        protected JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
    }

    /**
     * Upload file controller action.
     *
     * @return Json
     */
    public function execute()
    {
        
        $imageUploadId = $this->getRequest()->getParam('param_name', 'authentication_photo');
        try {
            
            $fileUploader = $this->uploaderFactory->create(['fileId' => $imageUploadId]);

            // Set our parameters
            $fileUploader->setFilesDispersion(false);
            $fileUploader->setAllowRenameFiles(true);
            $fileUploader->setAllowedExtensions(['jpeg','jpg','png','gif']);
            $fileUploader->setAllowCreateFolders(true);

            try {
                if (!$fileUploader->checkMimeType(['image/png', 'image/jpeg', 'image/gif', 'image/customtype'])) {
                    throw new \Magento\Framework\Exception\LocalizedException(__('File validation failed.'));
                }

                $imageResult = $fileUploader->save($this->getUploadDir());
                $baseUrl = $this->_backendUrl->getBaseUrl(['_type' => \Magento\Framework\UrlInterface::URL_TYPE_MEDIA]);

                $imageResult['name'] = $imageResult['file'];

                $imageResult['url'] = $baseUrl.$this->getAuthDirName(). '/' . $imageResult['file'];
            } catch (\Exception $e) {
                $imageResult = [
                    'error' => $e->getMessage(),
                    'errorcode' => $e->getCode()
                ];
            }

        } catch (\Exception $e) {
            $imageResult = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        //return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($imageResult);
        return $this->jsonFactory->create()->setData($imageResult);
    }

    /**
     * Get upload directory absolute path
     *
     * @return string
     */
    private function getUploadDir(): string
    {
        return $this->filesystem
            ->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath() . $this->getAuthDirName() . '/';
    }

    /**
     * Get authentication upload photo directory
     *
     * @return mixed
     */
    public function getAuthDirName(): mixed
    {
        return $this->scopeConfig->getValue(self::UPLOAD_DIR, ScopeInterface::SCOPE_STORE);
    }
}
