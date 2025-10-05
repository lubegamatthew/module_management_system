<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    
    use HasFactory;

    // protected $fillable = [
    //     'name',
    //     'leader_id',
    //     'created_by',
    // ];
    protected $guarded = [];

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'group_user');
    }
}
