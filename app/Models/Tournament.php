<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WaitingList;
class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'max',
        'is_active',
        'description',
        'created_by',
    ];
    public function Tournaments()
    {
        return $this->hasMany(Tournament::class);
    }
    public function Waitinglists()
    {
        return $this->belongsTo(Waitinglists::class, 'tournament_id');
    }
}
