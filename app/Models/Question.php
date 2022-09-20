<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'reviews',
        'degree',
        'reviewer_id',
        'auditor_id',
        'question',
        'user_book_id',
        "starting_page",
        "ending_page"
    ];


    protected $with = array('quotation');

    public function user_book(){
        return $this->belongsTo(UserBook::class,'user_book_id');
    }


    public function quotation(){
        return $this->hasMany(Quotation::class);
    }
}
