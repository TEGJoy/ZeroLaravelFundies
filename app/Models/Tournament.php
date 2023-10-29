<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WaitingList;
use App\Models\User;
class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_at',
        'name',
        'max',
        'is_active',
        'description',
        'created_by',
    ];
    public function Users()
    {
        return $this->belongsTo(Users::class);
    }
    public function Waitinglists()
    {
        return $this->belongsTo(Waitinglist::class);
    }
}
