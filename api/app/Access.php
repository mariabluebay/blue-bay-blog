<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    protected $table = 'access';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function audience()
    {
        return $this->hasMany(Post::class, 'accessible_id');
    }

    public function accessible()
    {
        return $this->morphTo();
    }
}
