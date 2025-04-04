<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = ['mobile', 'dob', 'gender', 'userID','address'];

    protected $primaryKey = 'pid';
    
    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'id');
    }

    public function tests()
    {
        return $this->hasMany(Test::class, 'pid', 'pid');
    }
    
}
