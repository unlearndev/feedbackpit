<?php

namespace App\Models;

use App\Enums\IdeaStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IdeaStatusUpdate extends Model
{
    /** @use HasFactory<\Database\Factories\IdeaStatusUpdateFactory> */
    use HasFactory;

    protected $fillable = [
        'from_status',
        'to_status',
        'message',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'from_status' => IdeaStatus::class,
            'to_status' => IdeaStatus::class,
        ];
    }

    /**
     * @return BelongsTo<Idea, $this>
     */
    public function idea(): BelongsTo
    {
        return $this->belongsTo(Idea::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
