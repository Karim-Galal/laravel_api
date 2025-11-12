<?php

namespace App\Http\Controllers\Api\v1;

use App\Filters\v1\InvoicesFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\InvoiceResource;
use App\Http\Resources\v1\InvoiceCollection;
use App\Models\Invoice;

use App\Http\Requests\v1\StoreInvoiceRequest;
use App\Http\Requests\v1\BulkStoreInvoiceRequest;
use App\Http\Requests\v1\UpdateInvoiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $filter = new InvoicesFilter();

        $queryItems = $filter -> transform($request); // [[column , operator, value]]

        if (count(value: $queryItems) > 0) {
          $invoices = Invoice::where($queryItems)
                          ->paginate(10);

          return  new InvoiceCollection($invoices->appends($request->query()));

        }else {

          return  new InvoiceCollection(Invoice::paginate(10));
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        return new InvoiceResource(  Invoice::create($request->all()));
    }

    public function bulkStore(BulkStoreInvoiceRequest $request) {

      $bulk = collect( $request->all())->map( function($arr, $key) {
          return Arr::except($arr, [ 'customerId', 'billedAt', 'paidAt' ]);
      });

      Invoice::insert( $bulk->toArray() );

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        return $invoice->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
