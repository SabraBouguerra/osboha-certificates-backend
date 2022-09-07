<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thesis extends Model
{
    use HasFactory;

    protected $table = 'thesis';

    protected $fillable = [
        'reviews',
        'degree',
        'reviewer_id',
        'thesis_text',
        'starting_page',
        'ending_page',
        'user_book_id'
    ];

    protected $with = array('photos');


    public function user_book(){
        return $this->belongsTo(UserBook::class,'user_book_id');
    }

    public function photos(){
        return $this->hasMany(Photos::class);
    }
}
