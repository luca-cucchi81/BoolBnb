<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('css/guest/app.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/07f1e373ab.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha256-pTxD+DSzIwmwhOqTFN+DB+nHjO4iAsbgfyFq5K5bcE0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('css/guest/owl.carousel.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/guest/owl.theme.default.css')}}" type="text/css">

</head>
<body>
    @include('layouts.guest.partials.header')

        @if (session('success'))
            <span class="alert alert-success">
                {{session('success')}}
            </span>
        @endif
        @if (session('failure'))
            <span class="alert alert-danger">
                {{session('failure')}}
            </span>
        @endif
    @yield('main')
    @include('layouts.guest.partials.footer')
</body>
</html>
