<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Repositories\Eloquent\CompanyRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    public function __construct(protected CompanyRepository $repository)
    {
        $this->repository->withHttpRequest();
    }

    public function index(): AnonymousResourceCollection
    {
        $companies = $this->repository->paginate();

        return CompanyResource::collection($companies);
    }

    public function store(StoreCompanyRequest $request): JsonResource
    {
        $company = $this->repository->create($request->validated());

        return new CompanyResource($company);
    }

    public function show(Company $company): JsonResource
    {
        return new CompanyResource($company);
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $this->repository->update($company->id, $request->validated());

        return new CompanyResource($company->fresh());
    }

    public function destroy(Company $company): Response
    {
        $this->repository->delete($company->id);

        return response()->noContent();
    }
}
