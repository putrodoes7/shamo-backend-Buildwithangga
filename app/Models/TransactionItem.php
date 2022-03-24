<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=[
        'users_id',
        'products_id',
        'transactions_id',
        'quantity'
    ];


    public function product(){
        return $this->hasOne(Products::class,  'id', 'products_id');
    }
    // public function users(){
    //     return $this->belongsTo(User::class, 'users_id', 'id');
    // }

    // public function transactioins(){
    //     return $this->belongsTo(Transaction::class, 'transactions_id', 'id');
    // }



}
