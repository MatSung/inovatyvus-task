<?php

namespace App\Http\Requests;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Truck;

class StoreTruckSubunitRequest extends FormRequest
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
        $dirtyData = [
            'main_truck' => $this->validationData()['main_truck'] ?? false,
            'subunit' => $this->validationData()['subunit'] ?? false,
        ];
        if (!is_string($dirtyData['main_truck']) && !is_string($dirtyData['subunit']))
            return;

        $this->merge([
            'main_truck' => strtoupper($dirtyData['main_truck']),
            'subunit' => strtoupper($dirtyData['subunit']),
        ]);

        $this->merge([
            'main_truck_id' => Truck::getIdFromName(strtoupper($dirtyData['main_truck'])),
            'subunit_id' => Truck::getIdFromName(strtoupper($dirtyData['subunit'])),
        ]);

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'main_truck' => [
                'required',
                'string',
                'different:subunit',
                'exists:App\Models\Truck,unit'
            ],
            'main_truck_id' => '',
            'subunit' => [
                'required',
                'string',
                'exists:App\Models\Truck,unit',
            ],
            'subunit_id' => '',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
        ];
    }

    /**
     * Do extra validation for storing subunit requests.
     */
    public function withValidator(Validator $validator): void
    {

        $validator->after(function ($validator) {
            $validated = $this->validated();
            $startDate = $validated['start_date'];
            $endDate = $validated['end_date'];
            if (
                !Truck::isAvailableBetweenDates(
                    $startDate,
                    $endDate,
                    $validated['main_truck_id']
                )
            ) {
                $validator->errors()->add('main_truck', 'Main truck is busy in the given time period.');
            }

            if (
                !Truck::isAvailableBetweenDates(
                    $startDate,
                    $endDate,
                    $validated['subunit_id']
                )
            ) {
                $validator->errors()->add('subunit', 'Subunit truck is busy in the given time period.');
            }
        });
    }

    /**
     * Get the validation messages that apply to this request.
     * 
     * @return array<string>
     */
    public function messages(): array
    {
        return [
        ];
    }
}