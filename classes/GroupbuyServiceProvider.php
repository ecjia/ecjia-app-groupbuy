<?php

namespace Ecjia\App\Groupbuy;

use Royalcms\Component\App\AppParentServiceProvider;

class GroupbuyServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-groupbuy', null, dirname(__DIR__));
    }
    
    public function register()
    {
        
    }
    
    
    
}