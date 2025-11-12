<?php

namespace App\Http\Requests\v1;


use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;



class UpdateCustomerRequest extends FormRequest
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
        $method =  $this->method();

        // if ($method == 'PUT') {
        if ($this-> isMethod('PUT') ) {

          return [
              'name'     => ['required', 'string', 'max:255'],
              'email'    => ['required', 'email', 'unique:users,email'],
              'city'     => ['required', 'string', 'max:255'],
              'state'       => ['required', 'string'],
              'type'        => ['required', Rule::in(['business', 'individual'])],
              'postal_code' => ['required', 'numeric'],
              // 'password' => ['required', 'string', 'min:8'],
          ];

        }else {

          return [
              'name'     => ['sometimes',  'string', 'max:255'],
              'email'    => ['sometimes',  'email', 'unique:users,email'],
              'city'     => ['sometimes',  'string', 'max:255'],
              'state'       => ['required', 'string'],
              'type'        => ['sometimes','required', Rule::in(['business', 'individual'])],
              'postal_code' => ['sometimes','required', 'numeric'],
              // 'password' => ['required', 'string', 'min:8'],
          ];

        }

    }
    protected function prepareForValidation(): void {

      if ($this->postalCode) {

        $this->merge([
          'postal_code' => $this->postalCode,
        ]);

      }

    }
}
