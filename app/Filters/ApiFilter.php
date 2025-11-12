<?php

namespace App\Filters;

use Illuminate\Http\Request;


class ApiFilter
{

  protected $safeParam = [ ];

  // names of the columns in db
  protected $columnMap = [];

  protected $operatorMap = [];
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
