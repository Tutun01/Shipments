<?php

namespace App\Http\Requests;

use App\Rules\UserClients;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewShipmentRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:128'],
            'fromCity' => ['required', 'string', 'max:64'],
            'fromCountry' => ['required', 'string', 'max:64'],
            'toCity' => ['required', 'string', 'max:64'],
            'toCountry' => ['required', 'string', 'max:64'],
            'price' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'string',  Rule::in(\App\Models\Shipment::ALLOWED_STATUSES)],
            'details' => ['required', 'string'],
            'documents'  => 'required|array',
            'documents.*'  => 'file|mimes:jpg,jpeg,png,webp,pdf,doc,docx|max:10240',
            'clientId' => ['required', new UserClients()]
        ];
    }
}
