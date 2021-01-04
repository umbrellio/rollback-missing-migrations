<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ config('app.name') }}</title>

        <link href="{{ mix('css/app.css') }}" rel="stylesheet" />
    </head>
    <body>
        <main id="app">
            <x-navigation>
                <x-slot name="header">
                    Header
                </x-slot>
            </x-navigation>

            <main>
                @yield('content')
            </main>

            <footer>
                <a href="https://github.com/RVxLab/project-skeleton" target="blank" rel="noopener noreferrer">Open source on Github</a>
            </footer>
        </main>

        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
