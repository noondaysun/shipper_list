<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
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
            'contact-id' => 'required|integer|exists:contacts,id',
            'shipper_id' => 'required|integer|exists:shippers,id',
            'name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'cantact_type' => 'required|string|max:255|in:primary,site,billing,admin,shipping',
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['contact-id'] = $this->route('contact-id');

        return $data;
    }
}
