<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SumberDana extends Model
{
    use HasFactory;

    protected $table = 'sumber_dana';

    protected $fillable = ['keterangan'];

    public function Pagu()
    {
        return $this->hasMany(Pagu::class, 'sumber_dana_id');
    }
}
