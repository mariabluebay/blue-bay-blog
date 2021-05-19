<?php

namespace App\Http\Resources;

use App\Http\Resources\Post as PostResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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
        $avatar = URL::to('/') . '/images/avatar.svg';

        if( !is_null( $this->avatar ) && !empty( $this->avatar ) ) {
            $avatar = URL::to('/') . Storage::url('profiles/'. $this->username.'/avatar/' . $this->avatar);
        }

        $status = $this->follows()->where('following_user_id', auth()->id())->value('status');

        if( is_null( $status ) ) {
            $status = $this->followers()->where('user_id', auth()->id())->value('status');
        }

        return [
            'username' => $this->username,
            'name' => $this->name,
            'avatar' => $avatar,
            'is_followed' => $this->is_followed,
            'status' => $status
        ];
    }
}
