@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'biography',
        'label' => 'Biography',
        'maxlength' => 100
    ])
@stop
