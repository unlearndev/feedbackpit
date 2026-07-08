<?php

namespace App\Http\Resources;

use App\Models\Idea;
use App\Models\Reaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Idea */
class IdeaResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $request->user();

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'votes' => $this->votes,
            'has_voted' => $user ? $this->voters->contains('id', $user->id) : false,
            'reactions' => $this->when(
                $this->relationLoaded('reactions'),
                fn () => collect(Reaction::EMOJIS)->map(fn (string $emoji) => [
                    'emoji' => $emoji,
                    'count' => $this->reactions->where('emoji', $emoji)->count(),
                    'reacted' => $user ? $this->reactions->where('emoji', $emoji)->contains('user_id', $user->id) : false,
                ])->values(),
            ),
            'is_subscribed' => $user ? $this->subscribers->contains('id', $user->id) : false,
            'can' => [
                'update' => $user ? $user->can('update', $this->resource) : false,
                'delete' => $user ? $user->can('delete', $this->resource) : false,
            ],
            'user' => new UserResource($this->whenLoaded('user')),
            'comments_count' => $this->whenCounted('comments'),
            'latest_status_update' => new IdeaStatusUpdateResource($this->whenLoaded('latestStatusUpdate')),
            'status_updates' => IdeaStatusUpdateResource::collection($this->whenLoaded('statusUpdates')),
            'created_at' => $this->created_at,
        ];
    }
}
