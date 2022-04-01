<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductGallery extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'products_id',
        'url'
    ];

    public function product(){
        return $this->BelongsTo(Product::class, 'id', 'products_id');
    }
    public function categories(){
        return $this->BelongsTo(Product::class, 'id', 'products_id');
    }

    public function getUrlAttribute($url){
        return config('app.url') . Storage::url($url);
    }
}
