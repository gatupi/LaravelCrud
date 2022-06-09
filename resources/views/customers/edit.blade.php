@extends('layouts.main')
@section('content')
{{view('customers.create', compact('id', 'fname', 'mname', 'lname', 'dob', 'sex', 'update'))}}
@endsection