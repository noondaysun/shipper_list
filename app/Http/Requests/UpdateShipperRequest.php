<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShipperRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'shipper-id' => 'required|integer|exists:shippers,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['shipper-id'] = $this->route('shipper-id');

        return $data;
    }
}
