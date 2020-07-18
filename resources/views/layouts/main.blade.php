<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="movies, tv show, actor, CodeMechanic, netMechanics, Alghool" />
    <meta name="robots" content="index, follow">
    <meta name="copyright" content="netmechanics 2020">
    <meta name="description" content="movies database" />
    <meta property="og:image" content="{{ asset('img/netmechanics-movies.png') }}"/>
    <meta name="author" content="CodeMechanic, Mahmoud Alghool">

    <title>NetMechanics Movies</title>

    <link rel="stylesheet" href="/css/main.css">
    <livewire:styles/>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

</head>
<body class="font-sans bg-gray-900 text-white">
    <nav class="border-b border-gray-800">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between px-4 py-6">
            <ul class="flex flex-col md:flex-row items-center">
                <li>
                    <a href="{{ route('movies.index') }}">
                        <img class="h-10" src="{{ asset('img/header-logo-transparent.png') }}" alt="">
                    </a>
                </li>
                <li class="md:ml-16 mt-3 md:mt-0">
                    <a href="{{ route('movies.index') }}" class="hover:text-gray-300">Movies</a>
                </li>
                <li class="md:ml-6 mt-3 md:mt-0">
                    <a href="{{ route('tv.index') }}" class="hover:text-gray-300">TV Shows</a>
                </li>
                <li class="md:ml-6 mt-3 md:mt-0">
                    <a href="{{ route('actors.index') }}" class="hover:text-gray-300">Actors</a>
                </li>
            </ul>
            <div class="flex flex-col md:flex-row items-center">
                 <livewire:search-dropdown/>
                <div class="md:ml-4 mt-3 md:mt-0">
                    {{--<a href="#">--}}
                        {{--<img src="/img/avatar.jpg" alt="avatar" class="rounded-full w-8 h-8">--}}
                    {{--</a>--}}
                </div>
            </div>
        </div>
    </nav>
    @yield('content')

    <footer class="flex content-between border-t border-gray-800">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between px-4 py-6">
            <div class="flex flex-col md:flex-row items-center  w-6/12">
                Powered by
                <a href="https://netmechanics.net">
                    <img class="h-8 m-2 " src="{{ asset('img/netmechanics.png') }}" alt="NetMechanics">
                </a>
            </div>
            <div class="flex flex-col md:flex-row items-center lg:w-1/4 w-3/12">
                <img src="https://www.themoviedb.org/assets/2/v4/logos/v2/blue_long_2-9665a76b1ae401a510ec1e0ca40ddcb3b0cfe45f1d51b77a308fea0845885648.svg">
            </div>
        </div>
    </footer>
<livewire:scripts/>
@yield("scripts")
</body>
</html>
