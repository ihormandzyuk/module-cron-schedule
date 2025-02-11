<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magefan\CronSchedule\Controller\Adminhtml\Schedule\Log;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Cron\Model\ResourceModel\Schedule\CollectionFactory;
use Magento\Backend\App\Action;

class MassDelete extends Action implements HttpPostActionInterface
{

    const ADMIN_RESOURCE = 'Magefan_CronSchedule::delete';
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfigInterface;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param ScopeConfigInterface $scopeConfigInterface
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        ScopeConfigInterface $scopeConfigInterface
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->scopeConfigInterface = $scopeConfigInterface;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $moduleEnabled = $this->scopeConfigInterface->getValue(Index::XML_PATH_MODULE_ENABLED);

        if (!$moduleEnabled) {
            $this->messageManager->addErrorMessage(__('Magefan Cr' . 'on Schedule is dis' . 'abled. Plea' . 'se enable it fir' . 'st.'));
            $this->_redirect(Index::XML_PATH_MODULE_CONFIGURATION);
            return;
        }
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $page) {
            $page->delete();
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
