<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetOrganizationsByBuildingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'buildingId' => [
                'required',
                'integer',
                Rule::exists('buildings', 'id'),
            ],
        ];
    }
    
    protected function prepareForValidation()
    {
        $this->merge([
            'buildingId' => $this->route('buildingId'),
        ]);
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'buildingId.required' => 'Building ID is required.',
            'buildingId.integer' => 'Building ID must be an integer.',
            'buildingId.exists' => 'Building with this ID does not exist.',
        ];
    }
} 