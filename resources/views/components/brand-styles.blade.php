@php
    $primary = setting(
        'brand_primary',
        '#22D3EE'
    );

    $primaryLight = setting(
        'brand_primary_light',
        '#67E8F9'
    );

    $primaryDark = setting(
        'brand_primary_dark',
        '#0891B2'
    );

    $secondary = setting(
        'brand_secondary',
        '#2563EB'
    );

    $secondaryLight = setting(
        'brand_secondary_light',
        '#60A5FA'
    );

    $secondaryDark = setting(
        'brand_secondary_dark',
        '#1D4ED8'
    );

    $accent = setting(
        'brand_accent',
        '#10B981'
    );
@endphp

<style>
    :root {
        --brand-primary:
            {{ hex_to_rgb(
                $primary,
                '34 211 238'
            ) }};

        --brand-primary-light:
            {{ hex_to_rgb(
                $primaryLight,
                '103 232 249'
            ) }};

        --brand-primary-dark:
            {{ hex_to_rgb(
                $primaryDark,
                '8 145 178'
            ) }};

        --brand-secondary:
            {{ hex_to_rgb(
                $secondary,
                '37 99 235'
            ) }};

        --brand-secondary-light:
            {{ hex_to_rgb(
                $secondaryLight,
                '96 165 250'
            ) }};

        --brand-secondary-dark:
            {{ hex_to_rgb(
                $secondaryDark,
                '29 78 216'
            ) }};

        --brand-accent:
            {{ hex_to_rgb(
                $accent,
                '16 185 129'
            ) }};
    }
</style>
