<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Update to TestCategory_New model
class TestCategory_New extends Model
{
    use HasFactory;

    protected $table = 'test_categories';

    protected $fillable = [
        'availableTests_id', 'name', 'value_type', 'value_type_Value',
        'unit_enabled', 'unit',  // Added unit_enabled
        'reference_type', 'min_value', 'max_value', 'display_order' // Removed range_unit
    ];

    public function test()
    {
        return $this->belongsTo(AvailableTest_New::class, 'availableTests_id');
    }

    // In TestCategory_New model
    public function referenceRangeTable()
    {
        return $this->hasMany(ReferenceRangeTable::class, 'test_categories_id');
    }


    public function availableTest()
    {
        return $this->belongsTo(AvailableTest_New::class, 'availableTests_id');
    }
}
