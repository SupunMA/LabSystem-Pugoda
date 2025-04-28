<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestElement_New extends Model
{
    use HasFactory;

    protected $table = 'availableTest_elements';

    protected $fillable = ['availableTests_id', 'type', 'content', 'display_order'];

    public function test()
    {
        return $this->belongsTo(AvailableTest_New::class, 'availableTests_id');
    }
}
