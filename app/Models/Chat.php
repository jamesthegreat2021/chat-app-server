<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    public $fillable = [
        'last_message'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function chats_with($userid)
    {
        $chats_with = self::find($this->id)->users()->where('user_id', '!=', $userid)->first();
        return $chats_with;
    }
}
