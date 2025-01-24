<?php

namespace App\Http\ViewModels;

use Illuminate\Contracts\Support\Arrayable;
use Inertia\Inertia;
use Inertia\Response;
use InertiaUI\Modal\Modal;
use JsonException;

abstract class ViewModel implements Arrayable
{
    /**
     * The component name.
     */
    public string $component = '';

    /**
     * Convert the ViewModel instance to an array.
     *
     * This method must be implemented by child classes.
     */
    abstract public function toArray(): array;

    /**
     * Convert the ViewModel instance to a JSON string.
     *
     * @throws JsonException
     */
    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }

    /**
     * Render the ViewModel for Inertia.
     */
    public function toInertia(?string $component = null): Response
    {
        return inertia($component ?? $this->component, $this->toArray());
    }

    /**
     * Render the ViewModel as modal for Inertia.
     *
     * @return Response
     */
    public function toInertiaModal(?string $component = null): Modal
    {
        return Inertia::modal($component ?? $this->component, $this->toArray());
    }
}
