<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return $this->hasOne(Product::class,  'id', 'products_id');
    }
    // public function users(){
    //     return $this->belongsTo(User::class, 'users_id', 'id');
    // }

    public function transactions(){
        return $this->belongsTo(Transaction::class, 'id', 'transactions_id');
    }



}
