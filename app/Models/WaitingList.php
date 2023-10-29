<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tournament;
use App\Models\User;
class WaitingList extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tournament_id',
    ];
    public function users()
    {
        return $this->hasMany(User::class, 'id');
    }
    public function tournaments()
    {
        return $this->hasMany(Tournament::class, 'id');
    }
}
