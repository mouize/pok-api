<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Product;

class ProductRepository extends BaseRepository
{
    /** Classname of the model. */
    protected string $modelClassname = Product::class;

    /** Fields that can be used to sort the results. */
    protected array $allowedSorts = [
        'id',
        'name',
        'created_at',
        'updated_at',
    ];

    /** Fields that can be used to filter the results. */
    protected array $allowedFilters = [
        'company_id',
        'name',
    ];

    /** Relations that can be included in the results. */
    protected array $allowedIncludes = [
        'company',
    ];
}
