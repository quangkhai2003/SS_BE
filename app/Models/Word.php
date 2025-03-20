<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $table = 'word'; // Tên bảng từ migration
    protected $primaryKey = 'id_word'; // Khóa chính tùy chỉnh
    public $timestamps = true;

    protected $fillable = [
        'id_level',
        'word',
        'image',
        'sound',
    ];

    // Quan hệ n-1 với Level
    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level', 'level_id');
    }
}
