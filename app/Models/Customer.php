<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Mutators\CustomerMutator;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{

    use SoftDeletes, CustomerMutator;

    protected $fillable = ['first_name', 'middle_name', 'last_name', 'sex', 'date_of_birth', 'cpf', 'active'];
    
}
