<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchOrganizationsByNameRequest extends FormRequest
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
            'name' => [
                'nullable',
                'string',
                'min:1',
            ],
        ];
    }
    
    protected function prepareForValidation()
    {
        $this->merge([
            'name' => $this->query('name') ?? '',
        ]);
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Organization name is required.',
            'name.string' => 'Organization name must be a string.',
            'name.min' => 'Organization name must be at least 1 character.',
        ];
    }
} 