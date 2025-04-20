<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'achievements';

    // Khóa chính của bảng
    protected $primaryKey = 'achievement_id';

    // Các cột có thể được gán giá trị
    protected $fillable = [
        'name',
        'requirement',
        'sticker',
        'type',
        'bonus_points',
        'created_at',
        'updated_at',
    ];

    // Tắt tự động tăng cho khóa chính nếu cần
    public $incrementing = true;

    // Định nghĩa kiểu dữ liệu cho các cột
    protected $casts = [
        'achievement_id' => 'integer',
        'bonus_points' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}