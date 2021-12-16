<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $comments = null;
        if (!is_null($this->comments)) {
            $comments = CommentResource::collection($this->comments);
        }

        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'text' => $this->text,
            'author' => new UserResource($this->user),
            'comments' => $comments,
            'created_at' => $this->created_at->format('d-m-Y H:i'),
            'updated_at' => $this->updated_at->format('d-m-Y H:i')
        ];
    }
}
