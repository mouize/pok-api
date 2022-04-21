<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $companyTable = (new (Company::class))->getTable();

        return [
            'name' => ['required', 'string', "unique:{$companyTable}"],
            'registration_number' => ['string', "unique:{$companyTable}"],
            'description' => ['string'],
        ];
    }
}
