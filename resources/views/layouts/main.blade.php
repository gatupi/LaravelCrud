<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/form.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" href="{{asset('css/profile.css')}}">
    
</head>
<body>
    <header></header>
    <div class="cms-body">
        <nav class="menu main-menu">
            <a href="{{route('customer.index')}}">
                <div class="menu-option">
                    <img class="icon" src="{{asset('img/customers-icon-white.png')}}" alt="icon">
                    <span class="opt-content">Clientes</span>
                </div>
            </a>
            <div class="menu-option">
                <img class="icon" src="{{asset('img/products-icon-white.png')}}" alt="icon">
                <span class="opt-content">Produtos</span>
            </div>
            <div class="menu-option">
                <img class="icon" src="{{asset('img/sales-icon-white.png')}}" alt="icon">
                <span class="opt-content">Vendas</span>
            </div>
            <div class="menu-option">
                <img class="icon" src="{{asset('img/bills-icon-white.png')}}" alt="icon">
                <span class="opt-content">Contas</span>
            </div>
            <div class="menu-option">
                <img src="{{asset('img/city-icon.png')}}" alt="" class="icon">
                <span class="opt-content">Cidades</span>
            </div>
        </nav>
        <main class="cms-content">
            @yield('content')
        </main>
    </div>
</body>
</html>