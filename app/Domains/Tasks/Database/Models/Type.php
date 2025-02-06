<?php

namespace App\Domains\Tasks\Database\Models;

use App\Domains\Tasks\Database\Factories\TypeFactory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'title',
        'description',
        'color',
        'creator_id'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
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
