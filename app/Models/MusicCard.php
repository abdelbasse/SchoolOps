<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusicCard extends Model
{
    use HasFactory;
    protected $table = 'musiccard';
    protected $fillable = [
        'from',
        'to',
        'UserId'
    ];

    public function musics()
    {
        return $this->hasMany(MusicInfo::class,'idCard');
    }

    public function user()
    {
        return $this->hasOne(User::class,'UserId');
    }



}
