<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductAsset extends Model
{
    use HasFactory;

    protected $table = "product_asset";

    protected $fillable = ['id', 'product_id', 'file_name', 'file_url', 'is_primary'];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected static function boot(){
        parent::boot();

        static::creating(function($model){
            if(empty($model->id)){
                $model->id = Str::uuid();
            }
        });
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
