<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkStoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user != null && $user->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'city'     => ['required', 'string', 'max:255'],
            'state'       => ['required', 'string'],
            'type'        => ['required', Rule::in(['business', 'individual'])],
            'postal_code' => ['required', 'numeric'],
            // 'password' => ['required', 'string', 'min:8'],
        ];

    }
    protected function prepareForValidation(): void {

      $this->merge([
        'postal_code' => $this->postalCode,
      ]);
    }

}
