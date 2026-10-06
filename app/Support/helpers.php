<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (! function_exists('setting')) {
    function setting(
        string $key,
        mixed $fallback = null
    ): mixed {
        $settings = Cache::rememberForever(
            'website.public-settings',
            fn () => Setting::query()
                ->where('is_public', true)
                ->pluck('value', 'key')
                ->all()
        );

        $value = $settings[$key] ?? null;

        return filled($value) ? $value : $fallback;
    }
}

if (! function_exists('hex_to_rgb')) {
    function hex_to_rgb(
        ?string $hex,
        string $fallback = '34 211 238'
    ): string {
        if (! is_string($hex)) {
            return $fallback;
        }

        $hex = ltrim(trim($hex), '#');

        if (strlen($hex) === 3) {
            $hex = implode('', array_map(
                fn (string $character): string =>
                    $character . $character,
                str_split($hex)
            ));
        }

        if (
            strlen($hex) !== 6
            || ! ctype_xdigit($hex)
        ) {
            return $fallback;
        }

        return sprintf(
            '%d %d %d',
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2))
        );
    }
}
