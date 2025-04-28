<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferenceRangeTable extends Model
{
    use HasFactory;

    protected $table = 'reference_range_tables';

    protected $fillable = ['test_categories_id', 'row', 'column', 'value'];

    public function testCategory()
    {
        return $this->belongsTo(TestCategory_New::class, 'test_categories_id');
    }
}
