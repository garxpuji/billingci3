<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'causer_type',
        'causer_id',
        'event',
        'batch_uuid',
        'properties',
    ];

    protected $casts = [
        'subject_id' => 'integer',
        'causer_id' => 'integer',
        'properties' => 'array',
    ];

    /**
     * Get the parent subject model
     */
    public function subject(): MorphMany
    {
        return $this->morphTo();
    }

    /**
     * Get the causer (user who performed the action)
     */
    public function causer(): MorphMany
    {
        return $this->morphTo();
    }

    /**
     * Scope to filter by subject
     */
    public function scopeForSubject($query, Model $subject)
    {
        return $query->where('subject_type', get_class($subject))
            ->where('subject_id', $subject->id);
    }

    /**
     * Scope to filter by causer
     */
    public function scopeForCauser($query, Model $causer)
    {
        return $query->where('causer_type', get_class($causer))
            ->where('causer_id', $causer->id);
    }

    /**
     * Scope to filter by event type
     */
    public function scopeForEvent($query, string $event)
    {
        return $query->where('event', $event);
    }

    /**
     * Scope to filter by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Log a created event
     */
    public static function logCreated(Model $model, ?Model $causer = null): self
    {
        return static::create([
            'log_name' => $model->getTable(),
            'description' => "Created {$model->getMorphClass()}",
            'subject_type' => get_class($model),
            'subject_id' => $model->id,
            'causer_type' => $causer ? get_class($causer) : null,
            'causer_id' => $causer?->id,
            'event' => 'created',
            'properties' => $model->toArray(),
        ]);
    }

    /**
     * Log an updated event
     */
    public static function logUpdated(Model $model, ?Model $causer = null, array $changes = []): self
    {
        return static::create([
            'log_name' => $model->getTable(),
            'description' => "Updated {$model->getMorphClass()}",
            'subject_type' => get_class($model),
            'subject_id' => $model->id,
            'causer_type' => $causer ? get_class($causer) : null,
            'causer_id' => $causer?->id,
            'event' => 'updated',
            'properties' => array_merge($model->toArray(), ['changes' => $changes]),
        ]);
    }

    /**
     * Log a deleted event
     */
    public static function logDeleted(Model $model, ?Model $causer = null): self
    {
        return static::create([
            'log_name' => $model->getTable(),
            'description' => "Deleted {$model->getMorphClass()}",
            'subject_type' => get_class($model),
            'subject_id' => $model->id,
            'causer_type' => $causer ? get_class($causer) : null,
            'causer_id' => $causer?->id,
            'event' => 'deleted',
            'properties' => $model->toArray(),
        ]);
    }

    /**
     * Log a custom event
     */
    public static function log(string $description, Model $subject, ?Model $causer = null, string $event = 'custom', array $properties = []): self
    {
        return static::create([
            'log_name' => $subject->getTable(),
            'description' => $description,
            'subject_type' => get_class($subject),
            'subject_id' => $subject->id,
            'causer_type' => $causer ? get_class($causer) : null,
            'causer_id' => $causer?->id,
            'event' => $event,
            'properties' => $properties,
        ]);
    }
}
