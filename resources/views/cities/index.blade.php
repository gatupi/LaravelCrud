@extends('layouts.main')
@section('content')
<div class="title-row">
    <span class="title list-title">Cidades</span>
    <a href="">
        <img class="add-icon" src="{{asset('img/add-icon-6-blue.png')}}" alt="add icon">
    </a> <!-- redireciona pro formulario -->
</div>
{{-- @if(count($customers) > 0) --}}
    <table class="list customer-list">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Estado</th>
                <th colspan="3">Actions</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach($customers as $c)
            <tr>
            </tr>
            @endforeach --}}
            <tr>

            </tr>
        </tbody>
    </table>
{{-- @else --}}
{{-- <h2>Nenhum produto encontrado</h2> --}}
{{-- @endif --}}
@endsection
