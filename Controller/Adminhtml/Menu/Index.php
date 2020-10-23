<?php

namespace Common\Menu\Controller\Adminhtml\Menu;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action implements HttpGetActionInterface
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
        $this->dataPersistor->clear('menu_menu');

        /* @var $resultPage Page */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Common_Menu::menu_menu');
        $resultPage->addBreadcrumb(__('Menu'), __('Menu'));
        $resultPage->addBreadcrumb(__('Manage Menus'), __('Manage Menus'));
        $resultPage->getConfig()->getTitle()->prepend(__('Menus'));

        return $resultPage;
    }
}
