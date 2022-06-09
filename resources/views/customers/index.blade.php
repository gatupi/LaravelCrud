@extends('layouts.main', ['title'=>'Clientes', 'create'=>true, 'createRoute'=>route('customer.create')])
@section('content')
<form id="customer-form-filter" class="cms-filter-form" action="{{route('customer.index')}}" style="
    display: inline-block;
    position: relative;
    transform: translateX(-50%);
    left: 50%;
    background-color: #f5f5f5;
    border: 1px solid #aaa;
    margin: 10px auto;
    padding: 5px;
    border-radius: 10px;
">
        
    <div style="display: flex; align-items: baseline; justify-content: space-evenly; margin-bottom: 10px;">
        <div class="cms-label-input-box" style="margin: 0;">
            <input value="{{substr($request->name, 1, strlen($request->name)-2)}}" id="name" name="name" type="text">
            <label for="name">Nome</label>
        </div>
    
        <div class="cms-label-input-box" style="margin-left: 10px;">
            <select class="cms-form-select filter-form-input" name="activity" id="activity">
                <option value="1">Ativos</option>
                <option value="0">Inativos</option>
                <option value="" selected>Todos</option>
            </select>
            <label for="activity" style="margin-left: 5px;">Status</label>
        </div>

        <div class="cms-label-input-box" style="margin-left: 10px;">
            <select name="sex" id="sex" class="cms-form-select filter-form-input">
                <option value="m">Masculino</option>
                <option value="f">Feminino</option>
                <option value="" selected>Ambos</option>
            </select>
            <label for="sex" style="margin-left: 5px;">Sexo</label>
        </div>

        <div class="cms-age-filter">
            <div class="cms-label-input-box">
                <select class="cms-form-select filter-form-input" name="age_opt" id="age_opt" onchange="onChangeAgeSelect(this)">
                    <option value="" selected>-- selecionar --</option>
                    <option value="greater">Maior ou igual à</option>
                    <option value="less">Menor ou igual à</option>
                    <option value="between">Entre</option>
                    <option value="equal">Igual à</option>
                </select>
                <label for="age-option">Idade</label>
            </div>
        </div>
    </div>

    <div style="display: flex; align-items: flex-end; justify-content: space-between; /*background-color: rgb(201, 243, 237);*/">
        <div class="birth-filter slct-filter" style="background-color: rgb(207, 207, 245); margin: 0;">
            <div class="cms-label-input-box">
                <select id="birth_opt" name="birth_opt" class="cms-form-select filter-form-input" onchange="onChangeBirthSelect(this)">
                    <option value="" selected>-- selecionar --</option>
                    <option value="date">Data</option>
                    <option value="month">Mês</option>
                    <option value="year">Ano</option>
                    <option value="month-and-year">Mês e ano</option>
                    <option value="month-and-day">Mês e dia</option>
                    <option value="birthday">Aniversariantes</option> <!-- expandir radio 'mês' e 'dia' -->
                </select>
                <label for="">Nascimento</label>
            </div>
        </div>

        <div style="display: flex; flex-direction: column;">
            <button type="button" style="margin-bottom: 5px; border: 1px solid #555; border-radius: 5px;" onclick="{
                var additional = document.getElementsByClassName('cms-slct-filter-el');
                for(let i=additional.length-1; i>=0; i--)
                    additional[i].remove();
            }">Limpar</button>
            <input style="background-color: rgb(235, 198, 219); border: 1px solid #555; border-radius: 5px;" type="submit" value="Filtrar">
        </div>
    </div>
</form>
@if(count($list) > 0)
@component('components.crudlist', ['list'=>$list, 'meta'=>$meta, 'formId'=>'customer-form-filter', 'maxPages'=>$maxPages, 'page'=>$page])
@endcomponent
@else
<h2>Nenhum cliente encontrado</h2>
@endif
@endsection
