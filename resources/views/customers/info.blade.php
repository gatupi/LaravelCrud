@extends('layouts.main', ['title'=>'Perfil do cliente', 'create'=>false])
@section('content')
<div class="content-area">
    <div class="cms-usrprofile">
        <div class="cms-profileheader">
            <img class="cms-usrphoto" src="{{asset('img/user-profile-icon.png')}}" alt="user photo">
            <div class="name-section">
                <span class="usr-fullname">{{$customer['full_name']}}</span>
                <span class="usr-age">{{$customer['age']}} anos</span>
                <span class="usr-sex">
                    {{
                        strtolower($customer['sex']) == 'm' ? 'Masculino'
                        : (strtolower($customer['sex'] == 'f' ? 'Feminino' : 'Não informado'))
                    }}
                </span>
            </div>
        </div>
        <div class="cms-profilebody">
            <ul style="list-style-type: none; margin: 0; padding: 0;">
                @foreach(array_keys($attributes) as $key)
                <li>
                    <span style="color: rgb(77, 77, 190);">{{$attributes[$key][$lang]}}:</span>
                    <span>@if($key != 'active'){{$customer[$key]}}@else{{$customer['active'] ? 'Sim' : 'Não'}}@endif</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection