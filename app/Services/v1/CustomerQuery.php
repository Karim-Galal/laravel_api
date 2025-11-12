<?php

namespace App\Services\v1;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;


class CustomerQuery extends ApiFilter
{

  protected $safeParam = [
    'name'  => ['eq'],
    'email' => ['eq'],
    'city'  => ['eq'],
    'type'  => ['eq'],
    'postalCode' => ['eq', 'gt','lt'],
  ];

  // names of the columns in db
  protected $columnMap = [
    'postalCode'=> 'postal_code',
  ];

  protected $operatorMap = [
    'eq' => '=',
    'gt' => '>',
    'lt' => '<',
    'gte' => '>=',
    'lte' => '<=',
  ];
  // in , like operators

  public function transform( Request $request ) {
    // array to be passed to elquont
    $eloQuery = [];

    foreach( $this->safeParam as $param => $operators) {

      $query = $request-> query( $param );

      if( !isset($query)) continue;

      $column = $this->columnMap[$param] ?? $param;

      foreach ( $operators as $operator ) {

        if (isset( $query[$operator])) {

          $eloQuery[] = [ $column ,  $this->operatorMap[$operator] , $query[$operator]];
        }
      }
    }

    return $eloQuery;
  }
}

