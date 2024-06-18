<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['title','description','long_description', 'completed'];
    // protected $guarded = ['password']; stops column to be used in mass assignment
    // protected $fillable =[] is used to enable this mass assignment, columns to be used 
    // in the mass assignment are put inside the array as strings
}
