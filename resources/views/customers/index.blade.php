@extends('layouts.main', ['title'=>'Clientes', 'create'=>true, 'createRoute'=>route('customer.create')])
@section('content')
<form id="customer-form-filter" class="cms-filter-form" action="" style="
    width: 80%;
    background-color: #f5f5f5;
    border: 1px solid #aaa;
    margin: 10px auto;
    padding: 5px;
    border-radius: 10px;
">
    <div style="display: flex; align-items: center;">
        <div class="cms-textinput" style="margin: 0;">
            <input id="name" name="name" type="text">
            <label for="name">Nome</label>
        </div>
    
        <div style="display: flex; flex-direction: column-reverse; margin-left: 10px;">
            <select class="cms-form-select" name="activity" id="activity">
                <option value="true" selected>Ativos</option>
                <option value="false">Inativos</option>
                <option value="all">Todos</option>
            </select>
            <label for="activity" style="margin-left: 5px;">Atividade</label>
        </div>

        <div style="display: flex; flex-direction: column-reverse; margin-left: 10px;">
            <select name="sex" id="sex" class="cms-form-select">
                <option value="m">Masculino</option>
                <option value="f">Feminino</option>
                <option value="both" selected>Ambos</option>
            </select>
            <label for="sex" style="margin-left: 5px;">Sexo</label>
        </div>

        <div class="cms-age-filter">
            <div style="display: flex; flex-direction: column-reverse;">
                <select class="cms-form-select" name="age-option" id="age-option" onchange="{
                    var val = this.value;
                    var inputs = this.parentElement.parentElement.getElementsByClassName('cms-age-filter-el');
                    for(let i=inputs.length-1; i>=0; i--) {
                        inputs[i].remove();
                    }
                    switch(val) {
                        case 'between':
                            var input2 = document.createElement('input');
                            var and = document.createElement('span');
                            input2.type = 'number';
                            input2.classList.add('cms-input-number', 'cms-age-filter-el');
                            and.classList.add('cms-age-filter-el');
                            and.innerText = 'e';
                            this.parentElement.parentElement.append(input2, and);
                        case 'greater':
                        case 'less':
                        case 'equal':
                            var input1 = document.createElement('input');
                            input1.type = 'number';
                            input1.classList.add('cms-input-number', 'cms-age-filter-el');
                            this.parentElement.parentElement.append(input1);
                            break;
                        default:
                            break;
                    }
                }">
                    <option value="" selected>-- selecionar --</option>
                    <option value="greater">Maior ou igual à</option>
                    <option value="less">Menor ou igual à</option>
                    <option value="between">Entre</option>
                    <option value="equal">Igual à</option>
                </select>
                <label for="age-option">Idade</label>
            </div>
        </div>

        <input type="submit" value="Filtrar" style="margin-left: 10px;">
    </div>
</form>
@if(count($list) > 0)
@component('components.crudlist', ['list'=>$list, 'meta'=>$meta, 'formId'=>'customer-form-filter', 'maxPages'=>$maxPages, 'page'=>$page])
@endcomponent
@else
<h2>Nenhum cliente encontrado</h2>
@endif
@endsection
