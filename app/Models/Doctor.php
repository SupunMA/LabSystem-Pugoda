<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
    'mobile', 
    'gender',
    'clinicName',
    'clinicAddress',
    'userID'

];


protected $primaryKey = 'did';


public function user()
{
    return $this->belongsTo(User::class, 'userID');
}
}
