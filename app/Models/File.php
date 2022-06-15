<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $filename
 * @property string $extension
 * @property int $size
 * @property string $disk
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'extension',
        'size',
        'disk',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
