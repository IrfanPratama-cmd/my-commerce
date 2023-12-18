<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;

    protected $table = "transactions";

    protected $fillable = ['id', 'user_id', 'transaction_time', 'transaction_code', 'transaction_status', 'total_price', 'total_tax', 'price_after_tax'];

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

    public function checkout(){
        return $this->hasMany(Checkout::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
