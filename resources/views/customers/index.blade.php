@extends('layouts.main', ['title'=>'Clientes', 'create'=>true, 'createRoute'=>route('customer.create')])
@section('content')
@if(count($list) > 0)
@component('components.crudlist', compact('list', 'meta'))
@endcomponent
@else
<h2>Nenhum cliente encontrado</h2>
@endif
@endsection
