<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestedTests extends Model
{
     use HasFactory;

    // Define the table name explicitly (if it doesn't follow Laravel's naming convention)
    protected $table = 'requested_tests';

    // Define the primary key explicitly (if it doesn't follow Laravel's default 'id')
    protected $primaryKey = 'id';

    // Allow mass assignment for these fields
    protected $fillable = ['patient_id', 'test_id', 'price', 'test_date'];

    // Disable auto-incrementing if the primary key is not auto-incrementing
    public $incrementing = true;

    // Define the primary key type (if it's not an integer)
    protected $keyType = 'int';

    // Define the relationship with the Patient model
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'pid');
    }

    // Define the relationship with the AvailableTest model
    public function test()
    {
        return $this->belongsTo(AvailableTest_New::class, 'test_id', 'id');
    }

    public function reportPaths()
    {
        return $this->hasMany(ReportPath::class, 'requested_test_id');
    }
}
