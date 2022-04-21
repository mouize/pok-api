<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Repositories\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /** The "after initializing query" callbacks that will be applied to the model. */
    protected array $afterInializingQuery = [];

    /** Classname of the model. */
    protected string $modelClassname = '';

    /** Fields that can be used to sort the results. */
    protected array $allowedSorts = [];

    /** Fields that can be used to filter the results. */
    protected array $allowedFilters = [];

    /** Relations that can be included in the results. */
    protected array $allowedIncludes = [];

    /**
     * Return a new fresh query builder.
     */
    protected function newQuery(): QueryBuilder
    {
        $query = QueryBuilder::for($this->modelClassname);

        foreach ($this->afterInializingQuery as $callback) {
            $query = $callback($query);
        }

        return $query;
    }

    /**
     * Specify that the HTTP request must be examined by the request builder
     * to look for filters, sorts and inclusions.
     */
    public function withHttpRequest(): self
    {
        $this->appendToCallbacks(function ($query): QueryBuilder {
            return $query
                ->allowedSorts($this->getAllowedSorts())
                ->allowedFilters($this->getAllowedFilters())
                ->allowedIncludes($this->getAllowedIncludes());
        });

        return $this;
    }

    /**
     * Find a model by its ID.
     */
    public function find(int $id): ?Model
    {
        return $this->newQuery()->find($id);
    }

    /**
     * Find a model by its ID and raises a ModelNotFound exception if no record.
     */
    public function findOrFail(int $id): ?Model
    {
        return $this->newQuery()->findOrFail($id);
    }

    /**
     * Get all models.
     */
    public function all(): Collection
    {
        return $this->newQuery()->get();
    }

    /**
     * Return a page of models.
     *
     * !important: keep the $table.* in column in case u add any join
     * it can get the id of the joined table when hydratating the model.
     */
    public function paginate(int $perPage = 10, int $page = null): LengthAwarePaginator
    {
        $table = $this->getTableName();

        return $this
            ->newQuery()
            ->paginate($perPage, ["{$table}.*"], 'page', $page);
    }

    /**
     * Create a new model.
     */
    public function create(array $attributes): Model
    {
        return $this->newQuery()->create($attributes);
    }

    /**
     * Update a model.
     */
    public function update(int $id, array $attributes): bool
    {
        return $this->newQuery()->find($id)->update($attributes);
    }

    /**
     * Delete a model.
     */
    public function delete(int $id): ?bool
    {
        return $this->newQuery()->find($id)->delete();
    }

    public function getAllowedSorts(): array
    {
        return $this->allowedSorts;
    }

    public function getAllowedFilters(): array
    {
        return $this->allowedFilters;
    }

    public function getAllowedIncludes(): array
    {
        return $this->allowedIncludes;
    }

    public function appendToCallbacks(callable $callback): void
    {
        $this->afterInializingQuery[] = $callback;
    }

    protected function getTableName(): string
    {
        return (new $this->modelClassname())->getTable();
    }
}
