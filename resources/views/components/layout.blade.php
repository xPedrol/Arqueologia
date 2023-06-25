<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html;" charset="UTF-8">
    <title>
        @if($title == 'home')
            Patrimônio Arqueológico - Universidade Federal de Viçosa (UFV)
        @else
            {{ $title }} - Patrimônio Arqueológico
        @endif
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{$description}}">
    {{--    icon --}}
    <link rel="icon" href="./images/icone.jpg">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{ $assets ?? '' }}

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-3710638-4"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-3710638-4');
    </script>
</head>

<body class="antialiased">
<x-navbar/>
<div class="main-container">
    {{ $content ?? '' }}
</div>
<x-footer/>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
      integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
      crossorigin="anonymous" referrerpolicy="no-referrer"/>
<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="{{ asset('js/app.js') }}" defer></script>
<script>
    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
{{ $scripts ?? '' }}
</body>

</html>
