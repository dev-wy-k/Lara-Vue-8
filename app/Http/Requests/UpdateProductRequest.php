<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => "required|string" ,
            'price' => "required|numeric"
        ];
    }

    public function messages(){
        return [
            "name.required" => "နာမည်လိုအပ်ပါတယ်" ,
            "price.required" => "စျေးနှုန်းလိုအပ်ပါတယ်" ,
            "name.string" => "နာမည်သည် စာသားဖြစ်ရပါမယ်" ,
            "price.numeric" => "စျေးနှုန်းသည် ဂဏန်းဖြစ်ရပါမယ်" 
        ];
    }
}
