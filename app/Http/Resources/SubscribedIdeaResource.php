<?php

namespace App\Http\Resources;

use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Idea */
class SubscribedIdeaResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status,
            'latest_status_update' => new IdeaStatusUpdateResource($this->whenLoaded('latestStatusUpdate')),
        ];
    }
}
