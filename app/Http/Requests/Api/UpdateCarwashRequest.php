<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarwashRequest extends FormRequest
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
            "title"    => "required",
            "lat"      => "required",
            "long"     => "required",
            "address"  => "required",
            "city_id"  => "required|exists:cities,id",
            "state_id" => "required|exists:states,id",
            "payment"  => "required|in:cash,online",
            "type"     => "required|in:manual,automatic,semi_automatic",
        ];
    }
}
