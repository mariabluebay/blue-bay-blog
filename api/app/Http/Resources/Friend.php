<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class Friend extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $is_followed = false;

        if( $request->user() ){
            $is_followed = $this->is_followed;
        }
        return [
            'username' => $this->username,
            'name' => $this->name,
            'avatar' => $this->avatar_url,
            'is_followed' => $is_followed
        ];
    }
}
