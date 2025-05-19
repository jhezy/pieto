<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Closing extends Model
{
    protected $fillable = ['tanggal', 'jumlah_transaksi', 'total_pendapatan'];
}
