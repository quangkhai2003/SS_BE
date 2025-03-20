<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $table = 'progress_through_level'; // Tên bảng từ migration
    protected $primaryKey = 'progress_id'; // Khóa chính tùy chỉnh
    public $timestamps = true; // Bật timestamps

    protected $fillable = [
        'topic_name',
    ];

    // Quan hệ 1-n với Level
    public function levels()
    {
        return $this->hasMany(Level::class, 'progress_id', 'progress_id');
    }
}
