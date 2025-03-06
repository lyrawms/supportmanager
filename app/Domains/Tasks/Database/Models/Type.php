<?php

namespace App\Domains\Tasks\Database\Models;

use App\Domains\Tasks\Database\Factories\TypeFactory;
use App\Domains\Users\Database\Models\User;
use App\Support\Traits\GenerateUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use HasFactory, softDeletes, generateUuid;

    protected $fillable = [
        'title',
        'color',
        'sla',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }


    protected static function newFactory()
    {
        return TypeFactory::new();
    }


}
