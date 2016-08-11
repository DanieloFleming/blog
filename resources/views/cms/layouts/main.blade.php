<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/assets/css/simditor.css">
    <link rel="stylesheet" href="/assets/css/cms.css">

    <script type="text/javascript" src="/assets/js/libs/jquery.js"></script>
    <script type="text/javascript" src="/assets/js/libs/simditor.js"></script>
    <title></title>
</head>
<body>
<nav>

    <a href="/" class="logo" >
        D. <!--<span>Dashboard</span>-->
    </a>
    <ul class="list-horizontal option-menu">
        <li><a href="/cms/post/new">write &#x270e;</a> </li>
        <li><a href="/cms/post/">posts ✣</a> </li>
        <!--<li><a href="/cms/user/">account ♗</a> </li>-->
        <li><a href="/logout">logout ⎋</a> </li>
    </ul>
</nav>

<div class="main-panel">
    @yield('content')
</div>
<div class="toastbar text-center">
    <span class="toastbar-text">Post saved as draft</span>
</div>
</body>
</html>