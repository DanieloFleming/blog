<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <footer class="text-center">
        <p>© Copyright 2016 - Danielo.</p>
    </footer>
</body>
</html>
