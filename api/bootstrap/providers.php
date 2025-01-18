<?php

use Nuwave\Lighthouse\LighthouseServiceProvider;
use Nuwave\Lighthouse\Pagination\PaginationServiceProvider;
use Nuwave\Lighthouse\Validation\ValidationServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    LighthouseServiceProvider::class,
    PaginationServiceProvider::class,
    ValidationServiceProvider::class,
];
