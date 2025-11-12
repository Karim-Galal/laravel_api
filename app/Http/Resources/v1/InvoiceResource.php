<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
          "id"=> $this->id,
          "customerId"=> $this->customer_id,
          'amount'=> $this->amount,
          'status' => $this->status,
          'billedAt' => $this->billed_at,
          'paidAt' => $this->paid_at,
        ];
    }
}
