<?php

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

if (!function_exists('toast')) {
    function toast(string $type, string $message, ?RedirectResponse $response = null)
    {
        $toasts = session()->get('toasts', []);
        $toasts[] = [
            'id' => Str::uuid(),
            'type' => $type,
            'message' => $message,
        ];
        if ($response) {
            return $response->with('toasts', $toasts);
        } else {
            session()->flash('toasts', $toasts);
        }
    }
}

if (!function_exists('toast_success')) {
    function toast_success(string $message)
    {
        return toast('success', $message);
    }
}

if (!function_exists('toast_warning')) {
    function toast_warning(string $message)
    {
        return toast('warning', $message);
    }
}

if (!function_exists('toast_error')) {
    function toast_error(string $message)
    {
        return toast('error', $message);
    }
}
