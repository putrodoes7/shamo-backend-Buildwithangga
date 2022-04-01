<?php

namespace App\Models;

use App\Models\User;
use App\Models\TransactionItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=[
        'users_id',
        'address',
        'payment',
        'total_price',
        'shipping_price',
        'status'
    ];

    public function users(){
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function items(){
        return $this->hasMany(TransactionItem::class, 'transactions_id', 'id');
    }

}
