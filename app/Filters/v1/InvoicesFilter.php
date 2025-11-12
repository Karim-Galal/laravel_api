<?php

namespace App\Filters\v1;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;


class InvoicesFilter extends ApiFilter
{

  protected $safeParam = [
    'id'         => ['eq', 'gt', 'lt'],
    'customerId' => ['eq'],
    'amount'     => ['eq', 'gt', 'lt', 'lte', 'gte'],
    'status'     => ['eq', 'ne'],
    'billedAt'   => ['eq', 'gt', 'lt', 'lte', 'gte'],
    'paidAt'     => ['eq', 'gt', 'lt', 'lte', 'gte'],
  ];

  protected $columnMap = [
      'customerId' => 'customer_id',
      'billedAt'   => 'billed_at',
      'paidAt'     => 'paid_at',
  ];


  protected $operatorMap = [
    'eq' => '=',
    'gt' => '>',
    'lt' => '<',
    'gte' => '>=',
    'lte' => '<=',
    'ne' => '!=',
  ];
  // in , like operators

}
