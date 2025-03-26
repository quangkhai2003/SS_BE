<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = 'level'; // Tên bảng từ migration
    protected $primaryKey = 'level_id'; // Khóa chính tùy chỉnh
    public $timestamps = true;

    protected $fillable = [
        'progress_id',
    ];

    // Quan hệ n-1 với Progress
    public function progress()
    {
        return $this->belongsTo(Progress::class, 'progress_id', 'progress_id');
    }

    // Quan hệ 1-n với Word
    public function words()
    {
        return $this->hasMany(Word::class, 'id_level', 'level_id');
    }
}
