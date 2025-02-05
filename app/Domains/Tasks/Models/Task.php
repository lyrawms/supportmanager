<?php

namespace App\Domains\Tasks\Models;

use App\Domains\Tasks\Models\Factories\TaskFactory;
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

    protected static function newFactory(): Factories\TaskFactory|\Illuminate\Database\Eloquent\Factories\Factory
    {
        return TaskFactory::new();
    }
}

;
