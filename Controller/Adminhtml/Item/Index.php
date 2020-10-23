<?php

namespace Common\Menu\Controller\Adminhtml\Item;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    /**
     * @var DataPersistorInterface|mixed|null
     */
    protected $dataPersistor;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    public function __construct(
        DataPersistorInterface $dataPersistor,
        PageFactory $resultPageFactory,
        Context $context
    ) {
        parent::__construct($context);

        $this->dataPersistor = $dataPersistor;
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return Page
     */
    public function execute()
    {
        $this->dataPersistor->clear('menu_item');

        /* @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Common_Menu::menu_item');
        $resultPage->addBreadcrumb(__('Menu Item'), __('Menu Item'));
        $resultPage->addBreadcrumb(__('Manage Menu Items'), __('Manage Menu Items'));
        $resultPage->getConfig()->getTitle()->prepend(__('Menu Items'));

        return $resultPage;
    }
}
