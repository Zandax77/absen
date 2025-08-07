<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bk extends Model
{
    use HasFactory;
    protected $table = 'bks';
    protected $fillable = ['kode','nama','sandi'];
}
