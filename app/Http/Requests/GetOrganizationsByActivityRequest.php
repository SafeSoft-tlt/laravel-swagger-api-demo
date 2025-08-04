<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetOrganizationsByActivityRequest extends FormRequest
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
            'activityId' => [
                'required',
                'integer',
                Rule::exists('activities', 'id'),
            ],
        ];
    }
    
    protected function prepareForValidation()
    {
        $this->merge([
            'activityId' => $this->route('activityId'),
        ]);
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'activityId.required' => 'Activity ID is required.',
            'activityId.integer' => 'Activity ID must be an integer.',
            'activityId.exists' => 'Activity with this ID does not exist.',
        ];
    }
} 