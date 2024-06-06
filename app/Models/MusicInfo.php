<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusicInfo extends Model
{
    use HasFactory;
    protected $table = 'musicinfo';
    protected $fillable = [
        'idCard',
        'name',
        'duree',
        'musicUrl'
    ];

    public function card()
    {
        return $this->belongsTo(MusicCard::class,'idCard');
    }
}
