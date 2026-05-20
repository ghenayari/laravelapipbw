<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // Mengizinkan kolom ini diisi
    protected $fillable = ['instructor_id', 'title', 'description'];

    // Relasi: Satu kursus dimiliki oleh satu pengajar
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}
