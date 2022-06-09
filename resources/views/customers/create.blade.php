@extends('layouts.main')
@section('content')
{{-- <form action="{{ route('customer.store') }}" method="{{ 'POST' }}">
    @csrf
    <label for="User">Nome</label>
    <input type="text" id="User" name="nome">
    <input type="submit" value="Save">
</form> --}}
<h2 class="form-title">Cadastrar cliente</h2>
<form class="cmsform" action="{{$update ? route('customer.update', $id) : route('customer.store')}}" method="POST">
    @csrf
    @if($update)
    @method('PUT')
    @endif
    <div class="cms-textinput">
        <input type="text" id="fname" name="fname" value="{{$fname}}">
        <label for="fname">First name</label>
    </div>
    <div class="cms-textinput">
        <input type="text" id="mname" name="mname" value="{{$mname}}">
        <label for="mname">Middle name</label>
    </div>
    <div class="cms-textinput">
        <input type="text" id="lname" name="lname" value="{{$lname}}">
        <label for="lname">Last name</label>
    </div>
    <div class="cms-textinput">
        <input type="text" id="dob" name="dob" value="{{$dob}}">
        <label for="dob">Date of birth</label>
    </div>
    <div class="cms-radioinput">
        <span class="title">Sex</span>
        <div class="cms-options">
            <div class="cms-radioption">
                <input type="radio" id="male" name="sex" value="m" @if($sex == 'm') checked @endif>
                <label for="male">M</label>
            </div>
            <div class="cms-radioption">
                <input type="radio" id="female" name="sex" value="f" @if($sex == 'f') checked @endif>
                <label for="female">F</label>
            </div>
        </div>
    </div>
    <div class="options-row">
        <a class="cms-formbutton cancel" href="{{route('customer.index')}}">Cancelar</a>
        <input class="cms-formbutton ok" type="submit" value="Confirmar">
    </div>
</form>
@endsection