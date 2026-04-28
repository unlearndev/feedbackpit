<?php

namespace App\Models;

use App\Enums\IdeaStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Idea extends Model
{
    /** @use HasFactory<\Database\Factories\IdeaFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => IdeaStatus::class,
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function voters(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'idea_vote');
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'idea_subscribers')->withTimestamps();
    }

    /**
     * @return HasMany<Comment, $this>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
