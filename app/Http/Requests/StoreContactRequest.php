<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'shipper_id' => 'required|integer|exists:shippers,id',
            'name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'contact_type' => 'required|string|max:255|in:primary,site,billing,admin,shipping',
        ];
    }
}
