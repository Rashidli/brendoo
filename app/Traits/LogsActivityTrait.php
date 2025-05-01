<?php

namespace App\Traits;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

trait LogsActivityTrait
{

    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        $fillable = $this->getFillable();

//        $translationFields = (new ($this->translations()->getRelated()))->getFillable();
//        $translationFields = array_map(fn ($field) => 'translations.'.$field, $translationFields);
//        dd($translationFields);
//        $fillable = array_merge($fillable, $translationFields);

        return LogOptions::defaults()
            ->logOnly($fillable)
            ->useLogName(class_basename($this))
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

}
