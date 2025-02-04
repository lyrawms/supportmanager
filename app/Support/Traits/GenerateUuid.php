<?php

namespace App\Support\Traits;

use Illuminate\Support\Str;

trait GenerateUuid
{    public function beforeCreate(): void
    {
        $this->uuid = Str::uuid();
    }

    public function save(array $options = []){
        if ($this[$this->primaryKey] === null) {
            $this->beforeCreate();
        }

        return parent::save($options);
    }
}
