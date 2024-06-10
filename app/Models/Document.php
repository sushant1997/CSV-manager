<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'guid',
        'document_name',
        'document_type',
        'file_path',
        'document_size',
        'user_id',
        'document_checksum',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
