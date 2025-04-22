<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite('resources/css/app.css')




</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <main>
        @include('components.landing.navbar')
        @include('components.landing.hero')
        @include('components.landing.about')
        @include('components.landing.cta')
        @include('components.landing.activity-program')
        @include('components.landing.school')
        @include('components.landing.location')
        @include('components.landing.footer')

    </main>
</body>

</html>
