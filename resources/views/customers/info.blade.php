@extends('layouts.main')
@section('content')
<div class="title-row">
    <span class="title list-title">Perfil do cliente</span>
</div>
<div class="content-area">
    <div class="cms-usrprofile">
        <div class="cms-profileheader">
            <img class="cms-usrphoto" src="{{asset('img/user-profile-icon.png')}}" alt="user photo">
            <div class="name-section">
                <span class="usr-fullname">{{$c->getFullName()}}</span>
                <span class="usr-age">{{$c->getAge()}} anos</span>
                <span class="usr-sex">{{$c->getSex() == 'm' ? 'Masculino' : ($c->getSex() == 'f' ? 'Feminino' : 'Não informado')}}</span>
            </div>
        </div>
        <div class="cms-profilebody">
            <div>
                <span class="cms-profilekey">Primeiro nome: </span>
                <span>{{$c->getFirstName()}}</span>
            </div>
            <div>
                <span class="cms-profilekey">Nome do meio: </span>
                <span>{{$c->getMiddleName()}}</span>
            </div>
            <div>
                <span class="cms-profilekey">Último nome: </span>
                <span>{{$c->getLastName()}}</span>
            </div>
            <div>
                <span class="cms-profilekey">Nascimento: </span>
                <span>{{$c->getDateOfBirth()}}</span>
            </div>
            <div>
                <span class="cms-profilekey">Sexo: </span>
                <span>{{$c->getSex()}}</span>
            </div>
        </div>
    </div>
</div>
@endsection