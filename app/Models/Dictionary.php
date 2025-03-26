<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
    use HasFactory;
    protected $table = 'dictionary';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'dictionary_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'word',
        'ipa',
        'word_type',
        'vietnamese',
        'examples',
        'example_vietnamese',
        'topic',
        'created_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
