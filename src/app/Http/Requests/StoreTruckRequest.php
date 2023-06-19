<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTruckRequest extends FormRequest
{

    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = false;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $dirtyUnit = $this->validationData()['unit'] ?? false;
        if (!is_string($dirtyUnit))
            return;
        if ($dirtyUnit) {
            $this->merge(['unit' => strtoupper($dirtyUnit)]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'unit' => 'required|string|unique:App\Models\Truck,unit',
            'year' => [
                'required',
                'integer',
                'between:1900,' . date('Y') + 5,
            ],
            'notes' => 'string|max:255'
        ];
    }

    /**
     * Get the validation messages that apply to this request.
     * 
     * @return array<string>
     */
    public function messages(): array
    {
        return [
            'unit.required' => 'Unit name is required.',
            'unit.unique' => 'Unit with the same name already exists.',
            'unit.string' => 'Unit name must be a string',
            'year.required' => 'Year is required.',
            'year.integer' => 'Year must be a number.',
            'year.between' => 'Year must be between 1900 and 5 years from now.',
            'notes.string' => 'Note must be a string.',
            'notes.max' => 'Note cannot exceed 255 symbols.'
        ];
    }
}