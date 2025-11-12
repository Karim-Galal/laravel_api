<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;



use App\Http\Resources\v1\InvoiceResource;
use App\Http\Resources\v1\InvoiceCollection;


class CustomerResource extends JsonResource
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
          'name'  => $this->name,
          'email' => $this->email,
          'city'  => $this->city,
          'type'  => $this->type,
          'postalCode' => $this->postal_code,
          'invoices' => InvoiceResource::collection($this->whenLoaded('invoices')),
        ];

    }
}
