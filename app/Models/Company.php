<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'registration_number',
    ];

    /**
     * Products belonging to this company.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
