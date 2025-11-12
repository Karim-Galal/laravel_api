<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInvoiceRequest extends FormRequest
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
            'customer_id' => ['required', 'exists:users,id'],
            'amount'     => ['required', 'numeric', 'min:1'],
            'status'     => ['required', Rule::in(['billed', 'paid', 'void'])],
            'billedA_at'   => ['required', 'date'],
            'paid_at'     => ['nullable', 'date', 'after_or_equal:billedAt'],
        ];
    }

    protected function prepareForValidation() {

        $this->merge([
            'customer_id' => $this->customerId,
            'billed_at'   => $this->billedAt,
            'paid_at'     => $this->paidAt,
        ]);

    }
}
