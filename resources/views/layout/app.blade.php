<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
    <header>
        <div class="navbar navbar-dark bg-dark">
            <div class="container">
                <a href="/" class="navbar-brand">
                    <strong>Home</strong>
                </a>
            </div>   
        </div>
    </header>    

    <main>
        <section class="py-5 text-center container-fluid">
            <div class="row py-5">
                <div class="col-md-12">
                    <h1 class="text-black">Tutorial Laravel dengan MongoDB</h1>
                </div>    
            </div>    
        </section>    
        
        <div class="py-5 bg-light">
            <div class="container">
                @yield('content')
            </div>    
        </div>
    </main>
    
    <footer class="py-5">
        <div class="container">
            <p class="mb-0">Faerul Salamun 2022</p>
        </div>    
    </footer>    
</body>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</html>