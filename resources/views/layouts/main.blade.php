<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/styles.css" >
</head>
<body>
    <nav>
        <div class="container no-padding">
            <a href="/" class="logo">D.</a>
            <span> Just a blog</span>
        </div>
    </nav>

    <section>
        @yield('content')
    </section>
</body>
</html>
