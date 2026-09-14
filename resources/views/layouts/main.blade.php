<!DOCTYPE html> 
<html lang="id"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>@yield('title', 'Aplikasi Web')</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> 
</head> 
<body>  
    @include('components.header')  
    <div class="container-fluid my-4"> 
        <div class="row"> 
            <div class="col-md-3 mb-3"> 
                @include('components.sidebar') 
            </div> 
            <div class="col-md-9"> 
                @yield('content') 
            </div> 
        </div> 
    </div>  
    @include('components.footer')  
</body> 
</html> 
