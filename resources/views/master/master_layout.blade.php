<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen antialiased leading-none"> 

            <div id="app" class="flex h-full">  
                    <nav class="w-1/5 border-r-2 borde-solid border-gray-600 h-full">                        
                        ddddinclude_once('master_menu');
                        <ul>
                            <li><a href="">DashBoard</a></li>
                            <li><a href="">환경설정</a></li>
                            <li><a href="">회원관리</a></li>
                            <li><a href="">게시판관리</a></li>
                            <li class=" bg-teal-200"><a href="">콘텐츠관리</a>
                                <ul class="ml-2  bg-teal-200">
                                    <li><a href="{{ url('/master/cont_portfolio') }}">ㄴ포트폴리오관리</a></li>
                                    <li><a href="">ㄴ비롯소식관리</a></li> 
                                </ul>
                            </li>
                            <li><a href="">문의관리</a></li>
                        </ul>
                    </nav>  
                <div class="w-4/5 border-r-2 borde-solid border-gray-600 ">
                @yield('content')
                </div>
            </div>
    </div>

    <!-- Scripts --> 
</body>
</html>
