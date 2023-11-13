<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModulPermission extends Model
{
    use HasFactory;

    protected $table = "modul_permission";

    public function modul()
    {
        return $this->belongsTo(Modul::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
