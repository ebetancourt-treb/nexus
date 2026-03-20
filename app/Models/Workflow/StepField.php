<?php

namespace App\Models\Workflow;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StepField extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'workflow_step_id',
        'field_key',
        'label',
        'field_type',
        'is_required',
        'is_repeatable',
        'options',
        'default_value',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_required' => 'boolean',
            'is_repeatable' => 'boolean',
            'options' => 'array',
        ];
    }

    public function step(): BelongsTo
    {
        return $this->belongsTo(WorkflowStep::class, 'workflow_step_id');
    }
}
