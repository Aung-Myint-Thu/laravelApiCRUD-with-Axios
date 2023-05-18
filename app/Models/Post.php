<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
     protected $fillable = ['title','description'];
    // protected $guarded -> the thing that you don't want to CRUD
    protected $hidden = ['created_at','updated_at'];
}
