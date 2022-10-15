<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_name',
        'pages',
        'section_id',
        'level_id',
        'status',

    ];

    public function users(){
        return $this->belongsToMany(User::class,'user_book');
    }


    protected $with = array('section','level');

    public function level(){
        return $this->belongsTo(BookLevel::class,'level_id');
    }

    public function section(){
        return $this->belongsTo(BookSection::class,'section_id');
    }

    public function userBook(){
        return $this->hasMany(UserBook::class);
    }


}
