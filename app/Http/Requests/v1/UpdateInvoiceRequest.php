<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvoiceRequest extends FormRequest
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
      if ($this->isMethod('PUT')) {

        return [
            'customerId' => ['required', 'exists:users,id'],
            'amount'     => ['required', 'numeric', 'min:1'],
            'status'     => ['required', Rule::in(['billed', 'paid', 'void'])],
            'billedAt'   => ['required', 'date'],
            'paidAt'     => ['nullable', 'date', 'after_or_equal:billedAt'],
        ];

      }else {

        return [
            'customerId' => ['sometimes','required', 'exists:users,id'],
            'amount'     => ['sometimes','required', 'numeric', 'min:1'],
            'status'     => ['sometimes','required', Rule::in(['billed', 'paid', 'void'])],
            'billedAt'   => ['sometimes','required', 'date'],
            'paidAt'     => ['sometimes','nullable', 'date', 'after_or_equal:billedAt'],
        ];

      }
    }

    protected function prepareForValidation(): void
    {
        if ($this->isMethod('put')) {

            $this->merge([
                'customer_id' => $this->customerId,
                'billed_at'   => $this->billedAt,
                'paid_at'     => $this->paidAt,
            ]);
        }

        if ($this->isMethod('patch')) {

            $data = [];

            if ($this->customerId) $data['customer_id'] = $this->customerId;
            if ($this->billedAt)   $data['billed_at']   = $this->billedAt;
            if ($this->paidAt)     $data['paid_at']     = $this->paidAt;

            $this->merge($data);
        }
    }
}
