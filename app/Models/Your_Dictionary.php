<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Your_Dictionary extends Model
{
    use HasFactory;
    protected $table = 'your_dictionary'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'user_dictionary_id'; // Khóa chính của bảng

    public $timestamps = false; // Bảng không có cột `updated_at`

    protected $fillable = [
        'user_id',
        'dictionary_id',
        'created_at',
    ];

    /**
     * Quan hệ với model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Quan hệ với model Dictionary.
     */
    public function dictionary()
    {
        return $this->belongsTo(Dictionary::class, 'dictionary_id', 'dictionary_id');
    }
}
