<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subcategory extends Model
{
    use HasFactory;

    protected $table = 'subcategories';

    protected $fillable = [
        'SubCategoryName',
        'SubCategoryRangeMin',
        'SubCategoryRangeMax',
        'Units',
        'AvailableTestID'
    ];

    public function availableTests()
    {
        return $this->belongsTo(AvailableTest::class, 'AvailableTestID', 'tlid');
    }

    protected $primaryKey = 'sub_id';
}