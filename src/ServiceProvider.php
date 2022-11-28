<?php

namespace Michaelmannucci\Coolor;

use Michaelmannucci\Coolor\Modifiers\Coolor;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $modifiers = [
        Coolor::class,
    ];
}