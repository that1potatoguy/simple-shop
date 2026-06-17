<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Simple Shop</title>
    <link href="/css/app.css" rel="stylesheet">
</head>
<body>
    <header class="site-header container" role="banner" style="border-bottom:1px solid rgba(255,255,255,0.04);">
        <div class="brand">
            <div class="logo" aria-hidden="true"></div>
            <span>Simple Shop</span>
        </div>
        <nav class="nav-links" role="navigation" aria-label="Main Navigation">
            <a href="{{ route('shop.index') }}">Home</a>
            <a href="{{ route('shop.cart') }}">Cart</a>
        </nav>
    </header>
    <main class="container" style="padding-top:1.25rem;">
        @if(session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error" role="alert">
                <ul style="margin:0;padding-left:1rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>
