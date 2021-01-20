<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
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

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->somethingElseIsInvalid()) {
                $errors = $this->errors();
                return response()->json([
                    'status' => 'fail',
                    'msg' => $validator->errors()->all(),
                    'errors'=> [
                        'name'=> $errors->first('name'),
                        'email'=> $errors->first('email'),
                        'phone' => $errors->first('phone'),
                        'birthdate'=>$errors->first('birthdate'),
                        'currency'=>$errors->first('currency'),
                        'password'=> $errors->first('password'),
                    ]
                ]);
            }
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'birthdate'=>'required',
            'currency'=>'required',
            'password' => 'required|string|min:6|max:10',
        ];
    }
}
