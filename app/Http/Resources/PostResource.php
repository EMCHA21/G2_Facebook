<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'img' => $this->img,
            'content' => $this->content,
            'auth_id' => $this->user,
            'comment' => $this->comments,
            'tags' => $this->tags,
            'likes' => $this->likes->transform(function ($like) {
                $like->user_name = $like->user->name;
                unset($like->user);
                return $like;
            }),
            'like_count' => count($this->likes),
        ];
    }
}
