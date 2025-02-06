<?php

<<<<<<<< HEAD:app/Domains/Tasks/Database/Models/Task.php
namespace App\Domains\Tasks\Database\Models;

use App\Domains\Tasks\Database\Factories\TaskFactory;
use App\Domains\Users\Database\Models\User;
========
namespace App\Domains\Tasks\Models;

use App\Domains\Tasks\Models\Factories\TaskFactory;
>>>>>>>> ui-improvement:app/Domains/Tasks/Models/Task.php
use App\Support\Traits\GenerateUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes, GenerateUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'intercom_link',
        'sla',
        'status',
        'deadline',
        'creator_id',

    ];

<<<<<<<< HEAD:app/Domains/Tasks/Database/Models/Task.php
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function type()
    {
        return $this->hasOne(Type::class, 'type_id');
    }

    protected static function newFactory()
========
    protected static function newFactory(): Factories\TaskFactory|\Illuminate\Database\Eloquent\Factories\Factory
>>>>>>>> ui-improvement:app/Domains/Tasks/Models/Task.php
    {
        return TaskFactory::new();
    }
}



;
