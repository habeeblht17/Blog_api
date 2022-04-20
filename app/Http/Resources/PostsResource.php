<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {


        return [

            'id' => (string)$this->id,
            'type' => 'Posts',
            'attributes' => [
                'title' => $this->title,
                'content' => $this->content,
                'users' => UsersResource::make($this->whenLoaded('user')),
                'comments' => CommentsResorce::collection($this->whenLoaded('comments')),
                'tags' => TagsResource::collection($this->whenLoaded('tags')),
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ]

        ];
    }
}
