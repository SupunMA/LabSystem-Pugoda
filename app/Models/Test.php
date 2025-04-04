<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'pid', 
        'tlid',
        'date',
        'doctorName',
        'done'
    
    ];
    
    
    protected $primaryKey = 'tid';


    public function patient()
    {
        return $this->belongsTo(Patient::class, 'pid', 'pid');
    }

    public function availableTest()
    {
        return $this->belongsTo(AvailableTest::class, 'tlid', 'tlid');
    }
}
