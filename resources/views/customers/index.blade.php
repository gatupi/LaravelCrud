@extends('layouts.main')
@section('content')
<div class="title-row">
    <span class="title list-title">{{$meta['title'][$meta['lang']]}}</span>
    <a href="{{route('customer.create')}}">
        <img class="add-icon" src="{{asset('img/add-icon-6-blue.png')}}" alt="add icon">
    </a> <!-- redireciona pro formulario -->
</div>
@if(count($list) > 0)
@component('components.crudlist', compact('list', 'meta'))
@endcomponent
@else
<h2>Nenhum cliente encontrado</h2>
@endif
@endsection
