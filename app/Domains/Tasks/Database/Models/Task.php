<?php
namespace App\Domains\Tasks\Database\Models;

use App\Domains\Tasks\Database\Factories\TaskFactory;
use App\Domains\Users\Database\Models\User;
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
        'assignee_id',

    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    protected static function newFactory(): TaskFactory
    {
        return TaskFactory::new();
    }
}



;
