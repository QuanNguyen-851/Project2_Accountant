<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubFeeModel extends Model
{
    use HasFactory;
    protected $table = 'subfee';
    public $timestamps = false; 
}
