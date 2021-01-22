<?php
/*
 * Copyright (c) 2020 Zengliwei
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
 * Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFINGEMENT. IN NO EVENT SHALL THE AUTHORS
 * OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Common\Menu\Block\Menu\Item\Renderer;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\Cache\StateInterface;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Cache\LockGuardedCacheLoader;
use Magento\Framework\Escaper;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Filter\FilterManager;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\Session\SidResolverInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\Translate\Inline\StateInterface as InlineTranslation;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Asset\Repository;
use Magento\Framework\View\ConfigInterface;
use Magento\Framework\View\DesignInterface;
use Magento\Framework\View\LayoutInterface;
use Psr\Log\LoggerInterface;

/**
 * @package Common\Menu
 * @author  Zengliwei <zengliwei@163.com>
 * @url https://github.com/zengliwei/magento2_menu
 */
class Context extends \Magento\Framework\View\Element\Context
{
    /**
     * @var CustomerSession
     */
    protected CustomerSession $customerSession;

    /**
     * @param RequestInterface            $request
     * @param LayoutInterface             $layout
     * @param ManagerInterface            $eventManager
     * @param UrlInterface                $urlBuilder
     * @param CacheInterface              $cache
     * @param DesignInterface             $design
     * @param SessionManagerInterface     $session
     * @param SidResolverInterface        $sidResolver
     * @param ScopeConfigInterface        $scopeConfig
     * @param Repository                  $assetRepo
     * @param ConfigInterface             $viewConfig
     * @param StateInterface              $cacheState
     * @param LoggerInterface             $logger
     * @param Escaper                     $escaper
     * @param FilterManager               $filterManager
     * @param TimezoneInterface           $localeDate
     * @param InlineTranslation           $inlineTranslation
     * @param LockGuardedCacheLoader|null $lockQuery
     */
    public function __construct(
        CustomerSession $customerSession,
        RequestInterface $request,
        LayoutInterface $layout,
        ManagerInterface $eventManager,
        UrlInterface $urlBuilder,
        CacheInterface $cache,
        DesignInterface $design,
        SessionManagerInterface $session,
        SidResolverInterface $sidResolver,
        ScopeConfigInterface $scopeConfig,
        Repository $assetRepo,
        ConfigInterface $viewConfig,
        StateInterface $cacheState,
        LoggerInterface $logger,
        Escaper $escaper,
        FilterManager $filterManager,
        TimezoneInterface $localeDate,
        InlineTranslation $inlineTranslation,
        LockGuardedCacheLoader $lockQuery = null
    ) {
        $this->customerSession = $customerSession;
        parent::__construct(
            $request,
            $layout,
            $eventManager,
            $urlBuilder,
            $cache,
            $design,
            $session,
            $sidResolver,
            $scopeConfig,
            $assetRepo,
            $viewConfig,
            $cacheState,
            $logger,
            $escaper,
            $filterManager,
            $localeDate,
            $inlineTranslation,
            $lockQuery
        );
    }

    /**
     * @return CustomerSession
     */
    public function getCustomerSession()
    {
        return $this->customerSession;
    }
}
