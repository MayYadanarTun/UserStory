<?php

namespace App\GraphQL\Queries;

use App\Models\User;

class EmployeeQuery
{
  public function paginate($root , array $args)
  {
      return User::query()->paginate(
          $args['count'],
          ['*'],
          'page',
          $args['page']
      );
  }
}
