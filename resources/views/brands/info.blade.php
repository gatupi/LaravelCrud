@extends('layouts.main', ['title'=>'Marca > Detalhes', 'create'=>false])
@section('content')
<div id="brand-info">
    <div>
        <div>
            <span class="brand-attr-key brand-attr">Id: </span>
            <span class="brand-attr-value brand-attr">{{$brand->id}}</span>
        </div>
        <div>
            <span class="brand-attr-key brand-attr">Nome: </span>
            <span class="brand-attr-value brand-attr">{{$brand->name}}</span>
        </div>
    </div>
    <div class="brand-icon-box">
        <img class="brand-icon" src="{{asset('img/edit-icon-2.png')}}" alt="edit icon" title="Editar">
        <img class="brand-icon" src="{{asset('img/delete-icon.png')}}" alt="delete icon" title="Apagar">
    </div>
</div>
@endsection