<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\v1\CustomerResource;
use App\Http\Resources\v1\CustomerCollection;
use App\Services\v1\CustomerQuery;
use App\Filters\v1\CustomerFilter;
use App\Http\Requests\v1\StoreCustomerRequest;
use App\Http\Requests\v1\UpdateCustomerRequest;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $filter = new CustomerFilter();
        $filterItems = $filter -> transform($request); // [[column , operator, value]]

        // including invoices
        $includeInvoices = $request->query('includeInvoices');


        $customers = User::where('role', 'customer')
                        ->where($filterItems);

        if ($includeInvoices) {

          $customers->with('invoices');

        }

        return CustomerResource::collection($customers->paginate(10)->appends($request->query()));

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {

        return new CustomerResource(User::create($request->all()));
    }

    public function bulkStore() {


    }

    /**
     * Display the specified resource.
     */
    public function show(User $customer)
    {
        // return $customer;
        $includeInvoices = request()->query('includeInvoices');

        if ($includeInvoices) {

          return new CustomerResource($customer -> loadMissing('invoices'));

        }

        return new CustomerResource($customer);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, User $customer)
    {
        $customer->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
