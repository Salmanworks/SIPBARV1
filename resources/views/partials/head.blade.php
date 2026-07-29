<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'SIPBAR') }}
</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<!-- Google Fonts: Plus Jakarta Sans & Outfit -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

@fonts

@vite(['resources/css/app.css', 'resources/js/app.js'])

{{-- FORCE LIGHT THEME GLOBAL (hapus override gelap dari @fluxAppearance yang tidak dipakai) --}}
<style>
    html { color-scheme: light !important; }
    body { color-scheme: light !important; }
    input, select, textarea, option, optgroup, button {
        color-scheme: light !important;
        background-color: #ffffff !important;
        color: #0f172a !important;
    }
    input::placeholder, textarea::placeholder {
        color: #94a3b8 !important;
        opacity: 1;
    }
    select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%232563eb'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 0.9rem center !important;
        background-size: 1.1em 1.1em !important;
        padding-right: 2.75rem !important;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
    input[type=checkbox], input[type=radio] {
        background-color: #ffffff !important;
        accent-color: #2563eb;
    }
    input[type=date]::-webkit-calendar-picker-indicator,
    input[type=datetime-local]::-webkit-calendar-picker-indicator {
        background-color: transparent !important;
        filter: invert(25%) sepia(95%) saturate(2500%) hue-rotate(210deg) brightness(95%);
        cursor: pointer;
    }
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        opacity: 1;
    }
</style>

