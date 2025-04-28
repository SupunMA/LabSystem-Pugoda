<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableTest_New extends Model
{
    use HasFactory;

    protected $table = 'availableTests';

    protected $fillable = ['name', 'cost', 'price'];

    public function categories()
    {
        return $this->hasMany(TestCategory_New::class);
    }

    public function elements()
    {
        return $this->hasMany(TestElement_New::class);
    }

}
