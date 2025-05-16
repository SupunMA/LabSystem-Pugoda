<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'requested_test_id',
        'category_id',
        'result_value',
        'added_by'
    ];

    // Relationship with requested test
    public function requestedTest()
    {
        return $this->belongsTo(RequestedTests::class, 'requested_test_id');
    }

    // Relationship with test category
    public function category()
    {
        return $this->belongsTo(TestCategory::class, 'category_id');
    }

    // Relationship with user who added the result
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
