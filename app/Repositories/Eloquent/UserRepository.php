<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository
{
    /** Classname of the model. */
    protected string $modelClassname = User::class;

    /** Fields that can be used to sort the results. */
    protected array $allowedSorts = [
        'id',
        'name',
        'email',
        'email_verified_at',
        'created_at',
        'updated_at',
    ];

    /** Fields that can be used to filter the results. */
    protected array $allowedFilters = [
        'name',
        'email',
    ];

    public function findByEmailOrFail(string $email): Model
    {
        return $this->newQuery()->where('email', $email)->firstOrFail();
    }
}
