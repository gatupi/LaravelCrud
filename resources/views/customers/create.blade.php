@extends('layouts.main')
@section('content')
@section('title', 'Cadastro de cliente')
<form class="cmsform" action="{{$update ? route('customer.update', $id) : route('customer.store')}}" method="POST">
    @csrf
    @if($update)
    @method('PUT')
    @endif
    <div class="cms-textinput">
        <input type="text" id="cpf" name="cpf" value={{$cpf}}>
        <label for="cpf">CPF</label>
    </div>
    <div class="cms-textinput">
        <input type="text" id="first_name" name="first_name" value={{$first_name}}>
        <label for="first_name">First name</label>
    </div>
    <div class="cms-textinput">
        <input type="text" id="middle_name" name="middle_name" value={{$middle_name}}>
        <label for="middle_name">Middle name</label>
    </div>
    <div class="cms-textinput">
        <input type="text" id="last_name" name="last_name" value={{$last_name}}>
        <label for="last_name">Last name</label>
    </div>
    <div class="cms-textinput">
        <input type="text" id="date_of_birth" name="date_of_birth" value={{$date_of_birth}}>
        <label for="date_of_birth">Date of birth</label>
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