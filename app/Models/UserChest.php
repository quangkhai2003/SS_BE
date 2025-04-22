<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserChest extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'progress_id', 'opened_at'];
    public $timestamps = false;
    /**
     * Quan hệ với model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id'); // Tham chiếu đúng cột user_id
    }

    /**
     * Quan hệ với model ProgressThroughLevel.
     */
    public function progress()
    {
        return $this->belongsTo(Progress::class, 'progress_id', 'progress_id'); // Tham chiếu đúng cột progress_id
    }
}
