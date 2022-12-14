<?php

namespace App\Http\Requests\Category;

use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PutRequest extends FormRequest
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
    
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        if($this->expectsJson()){
        $response = new Response($validator->errors(),422);
        throw new ValidationException($validator, $response);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "title" => "required|min:5|max:255",
            "slug" => []
        ];
    }

    public static function myRules($post)
    {
        return [
            "title" => "required|min:5|max:255",
            "slug" => [Rule::unique('categories')->ignore($post->id)]
        ];
    }
}
