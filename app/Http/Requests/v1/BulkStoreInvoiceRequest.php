<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkStoreInvoiceRequest extends FormRequest
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
            '*.customer_id' => ['required', 'exists:users,id'],
            '*.amount'     => ['required', 'numeric', 'min:1'],
            '*.status'     => ['required', Rule::in(['billed', 'paid', 'void'])],
            '*.billed_at' => ['required', 'date', 'date_format:Y-m-d H:i:s'],
            '*.paid_at'     => ['nullable', 'date', 'after_or_equal:billedAt' , 'date_format:Y-m-d H:i:s'],
        ];
    }

    protected function prepareForValidation() {

        $data = [];

        foreach ($this->toArray() as $obj) {

          $obj['customer_id'] = $obj['customerId'] ?? null;
          $obj['billed_at'] = $obj['billedAt'] ?? null;
          $obj['paid_at'] = $obj['paidAt'] ?? null;

          unset($obj['customerId'], $obj['billedAt'], $obj['paidAt']);

          $data[] = $obj;
        }

        // $this->merge( $data );
        $this->replace($data);

    }
}
