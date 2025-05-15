<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportPath extends Model
{
    use HasFactory;

    protected $fillable = [
        'requested_test_id',
        'file_path',
    ];
}
