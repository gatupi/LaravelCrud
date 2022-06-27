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
                <option value="all">Todos</option>
            </select>
            <label for="activity" style="margin-left: 5px;">Status</label>
        </div>

        <div class="cms-label-input-box" style="margin-left: 10px;">
            <select name="sex" id="sex" class="cms-form-select filter-form-input">
                <option value="m">Masculino</option>
                <option value="f">Feminino</option>
                <option value="both">Ambos</option>
            </select>
            <label for="sex" style="margin-left: 5px;">Sexo</label>
        </div>

        <div class="cms-age-filter">
            <div class="cms-label-input-box">
                <select class="cms-form-select filter-form-input" name="age_filter_opt" id="age_filter_opt" onchange="{
                    var val = this.value;
                    var inputs = this.parentElement.parentElement.getElementsByClassName('cms-slct-filter-el');
                    for(let i=inputs.length-1; i>=0; i--) {
                        inputs[i].remove();
                    }
                    switch(val) {
                        case 'between':
                            var input1 = document.createElement('input');
                            var and = document.createElement('span');
                            input1.type = 'number';
                            input1.value = {{$request->age1}}
                            input1.id = input1.name = 'age1';
                            input1.classList.add('cms-input-number', 'cms-slct-filter-el');
                            and.classList.add('cms-slct-filter-el');
                            and.innerText = 'e';
                            this.parentElement.parentElement.append(input1, and);
                        case 'greater':
                        case 'less':
                        case 'equal':
                            var input2 = document.createElement('input');
                            input2.type = 'number';
                            input2.value = {{$request->age2}}
                            input2.id = input2.name = 'age2';
                            input2.classList.add('cms-input-number', 'cms-slct-filter-el');
                            this.parentElement.parentElement.append(input2);
                            break;
                        default:
                            break;
                    }
                }">
                    <option value="">-- selecionar --</option>
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
                <select id="birth_filter_opt" name="birth_filter_opt" class="cms-form-select filter-form-input" onchange="{
                    var val = this.value;
                    var filter_box = this.parentElement.parentElement;
                    var inputs = filter_box.getElementsByClassName('cms-slct-filter-el');
                    for(let i=inputs.length-1; i>=0; i--)
                        inputs[i].remove();

                    function createMonthSelect() {
                        var month_slct = document.createElement('select');
                        month_slct.classList.add('cms-slct-filter-el', 'cms-form-select', 'filter-form-input');
                        month_slct.id = month_slct.name = 'birth_month';
                        var months = [
                            { name: 'Janeiro', value: 'jan' }, { name: 'Fevereiro', value: 'feb' }, { name: 'Março', value: 'mar' }, { name: 'Abril', value: 'apr' },
                            { name: 'Maio', value: 'may' }, { name: 'Junho', value: 'jun' }, { name: 'Julho', value: 'jul' }, { name: 'Agosto', value: 'aug' },
                            { name: 'Setembro', value: 'sep' }, { name: 'Outubro', value: 'oct' }, { name: 'Novembro', value: 'nov' }, { name: 'Dezembro', value: 'dec' }
                        ];
                        for(let m of months) {
                            let month_opt = document.createElement('option');
                            month_opt.innerText = m.name;
                            month_opt.value = m.value;
                            month_slct.append(month_opt);
                        }
                        return month_slct;
                    }

                    function createYearInput() {
                        var input = document.createElement('input');
                        input.id = input.name = 'birth_year';
                        input.type = 'number';
                        input.classList.add('cms-slct-filter-el', 'cms-input-number');
                        input.style.width = '55px';
                        input.value = 1997;
                        input.min = 1950;
                        input.max = 2022;
                        return input;
                    }

                    function createDateInput() {
                        var input = document.createElement('input');
                        input.value = '1997-12-08';
                        input.type = 'date';
                        input.id = input.name = 'birth_date';
                        input.classList.add('cms-slct-filter-el');
                        return input;
                    }

                    function createRadioBox(id, inputId, groupName, labelTxt, value, checked = false) {
                        var radio_box = document.createElement('div');
                        var input = document.createElement('input');
                        var label = document.createElement('label');
                        input.type = 'radio';
                        input.value = value;
                        input.checked = checked;
                        label.htmlFor = input.id = inputId;
                        label.innerText = labelTxt;
                        input.name = groupName;
                        radio_box.append(input, label);
                        return radio_box;
                    }

                    function createBirthdayOptions() {
                        var month_radio_box = createRadioBox('birth_month_opt_box', 'birth_month_opt', 'birthday_option', 'Mês', 'm', true);
                        var day_radio_box = createRadioBox('birth_day_opt_box', 'birth_day_opt', 'birthday_option', 'Dia', 'd');
                        month_radio_box.classList.add('cms-slct-filter-el');
                        day_radio_box.classList.add('cms-slct-filter-el');

                        return [month_radio_box, day_radio_box];
                    }

                    switch(val) {
                        case 'month-and-year':
                            filter_box.append(createMonthSelect());
                            filter_box.append(createYearInput());
                            break;
                        case 'month':
                            filter_box.append(createMonthSelect());
                            break;
                        case 'year':       
                            filter_box.append(createYearInput());
                            break;
                        case 'date':                            
                            filter_box.append(createDateInput());
                            break;
                        case 'birthday':
                            var options = createBirthdayOptions();
                            for(let o of options)
                                filter_box.append(o);
                            break;
                        case 'month-and-day':
                            var dayInput = document.createElement('input');
                            dayInput.type = 'number';
                            dayInput.min = 1;
                            dayInput.max = 31;
                            dayInput.name = dayInput.id = 'birth_day';
                            dayInput.value = 1;
                            dayInput.classList.add('cms-slct-filter-el');
                            dayInput.style.width = '40px';
                            filter_box.append(createMonthSelect(), dayInput);
                            break;
                    }
                }">
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
