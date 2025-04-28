<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestCategory_New extends Model
{
    use HasFactory;

    protected $table = 'test_categories';

    protected $fillable = [
        'availableTests_id', 'name', 'value_type', 'unit',
        'reference_type', 'min_value', 'max_value', 'range_unit', 'display_order'
    ];

    public function test()
    {
        return $this->belongsTo(AvailableTest_New::class, 'availableTests_id');
    }

    public function referenceRangeTable()
    {
        return $this->hasMany(ReferenceRangeTable::class, 'test_categories_id');
    }
}
