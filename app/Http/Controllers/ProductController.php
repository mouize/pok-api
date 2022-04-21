<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\Eloquent\ProductRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function __construct(protected ProductRepository $repository)
    {
        $this->repository->withHttpRequest();
    }

    public function index(): AnonymousResourceCollection
    {
        $products = $this
            ->repository
            ->paginate();

        return ProductResource::collection($products);
    }

    public function show(Product $product): JsonResource
    {
        return new ProductResource($product);
    }

    public function store(StoreProductRequest $request): JsonResource
    {
        $product = $this->repository->create($request->validated());

        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product): JsonResource
    {
        $this->repository->update($product->id, $request->validated());

        return new ProductResource($product->fresh());
    }

    public function destroy(Product $product): Response
    {
        $this->repository->delete($product->id);

        return response()->noContent();
    }
}
