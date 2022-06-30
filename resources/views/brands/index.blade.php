@extends('layouts.main', ['title'=>'Marcas', 'create'=>true, 'createRoute'=>null])
@section('content')
<table class="simple-table">
    <thead>
        <tr>
            <th style="text-align: center;" colspan="3">Marcas</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 0; $i < intdiv(count($brands), 3); $i++)
            <tr>
                @for($j=0; $j<3; $j++)
                <td onclick="onClickBrand({name:'{{$brands[$i*3+$j]->name}}', id: {{$brands[$i*3+$j]->id}}})">
                    {{$brands[$i*3+$j]->name}}
                </td>
                @endfor
            </tr>
        @endfor
        @if(count($brands)%3 > 0)
        <tr>
            <td>{{ $brands[intdiv(count($brands), 3)*3+0]->name }}</td>
            <td>{{ $brands[intdiv(count($brands), 3)*3+1]->name ?? null }}</td>
            <td></td>
        </tr>
        @endif
    </tbody>

    <div id="brandModal" class="modal">
        <div class="modal-content">
            <div class="brand-modal-info">
                <div>
                    <div class="modal-key-value">
                        <span>ID:</span>
                        <span id="brandIdValue">123</span>
                    </div>
                    <div class="modal-key-value">
                        <span>Nome:</span>
                        <span id="brandNameValue">Sadia</span>
                    </div>
                </div>
                <div>
                    <img class="modal-icon" src="{{asset('img/edit-icon-2.png')}}" alt="edit-icon">
                    <img class="modal-icon" src="{{asset('img/delete-icon.png')}}" alt="delete-icon">
                </div>
            </div>
            <span class="close">&times;</span>
        </div>
    </div>
</table>
@endsection