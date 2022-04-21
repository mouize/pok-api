<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Company;

class CompanyRepository extends BaseRepository
{
    /** Classname of the model. */
    protected string $modelClassname = Company::class;

    /** Fields that can be used to sort the results. */
    protected array $allowedSorts = [
        'id',
        'name',
        'created_at',
        'updated_at',
    ];

    /** Fields that can be used to filter the results. */
    protected array $allowedFilters = [
        'name',
        'description',
    ];

    /** Relations that can be included in the results. */
    protected array $allowedIncludes = [
        'products',
    ];
}
