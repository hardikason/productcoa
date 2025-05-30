<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * @author  Sonali Kosrabe <sonali.kosrabe@outlook.com>
 */
declare(strict_types=1);

namespace SK\ProductCOA\Plugin;

use Magento\Framework\App\Request\Http;
use Magento\Framework\App\Router\Base;

class FrontendRouter
{
    /**
     * Rewrite dashed URLs to controller-friendly format
     * 
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param Base $subject
     * @param \Closure $proceed
     * @param Http $request
     * @return bool
     */
    public function aroundMatch(Base $subject, \Closure $proceed, Http $request)
    {
        $pathInfo = trim($request->getPathInfo(), '/');

        // Rewrite 'auth-photo' to 'authphoto'
        if (strpos($pathInfo, 'productcoa/customer/auth-photo/') === 0) {
            $newPath = str_replace('auth-photo', 'authphoto', $pathInfo);
            $request->setPathInfo('/' . $newPath);
        }

        return $proceed($request);
    }
}
