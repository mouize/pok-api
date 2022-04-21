<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    /**
     * Find a model by its ID.
     */
    public function find(int $id): ?Model;

    /**
     * Find a model by its ID and raises a ModelNotFound exception if no record.
     */
    public function findOrFail(int $id): ?Model;

    /**
     * Get all models.
     */
    public function all(): Collection;

    /**
     * Get a page of models.
     */
    public function paginate(int $perPage, int $page = null): LengthAwarePaginator;

    /**
     * Create a new model.
     */
    public function create(array $attributes): Model;

    /**
     * Update a model.
     */
    public function update(int $id, array $attributes): bool;

    /**
     * Delete a model.
     */
    public function delete(int $id): ?bool;

    /**
     * Specify that the HTTP request must be examined by the request builder
     * to look for filters, sorts and inclusions.
     */
    public function withHttpRequest(): self;
}
