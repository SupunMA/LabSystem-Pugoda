<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    use HasFactory;

    protected $primaryKey = 'remark_id'; // Assuming 'remark_id' is your primary key
    protected $fillable = ['remark_description'];
}
