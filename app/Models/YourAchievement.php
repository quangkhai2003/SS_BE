<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YourAchievement extends Model
{
    use HasFactory;
    // Định nghĩa tên bảng (tùy chọn, nếu tên bảng khớp với tên model theo chuẩn Laravel)
    protected $table = 'your_achievements';

    // Định nghĩa primary key
    protected $primaryKey = 'user_achievement_id';
    public $timestamps = false;
    // Các cột có thể điền
    protected $fillable = [
        'user_id',
        'achievement_id',
        'created_at',
        'status',
    ];

    // Cast các cột nếu cần
    protected $casts = [
        'created_at' => 'date',
        'status' => 'string', // Enum được xử lý như string
    ];

    // Quan hệ với model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Quan hệ với model Achievement
    public function achievement()
    {
        return $this->belongsTo(Achievement::class, 'achievement_id', 'achievement_id');
    }
}
