<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id'
    ];


    protected $table = 'user_book';

    protected $with = array('thesises');


    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function book(){
        return $this->belongsTo(Book::class,'book_id');
    }

    public function certificates(){
        return $this->hasMany(Certificates::class);
    }

    public function thesises(){
        return $this->hasMany(Thesis::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }
}

