@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'description',
        'label' => 'Description',
        'maxlength' => 100
    ])

    @formField('medias', [
        'name' => 'cover',
        'label' => 'Cover Image'
    ])

    @formField('browser', [
        'moduleName' => 'authors',
        'name' => 'authors',
        'label' => 'Authors',
        'max' => 5,
    ])

    @formField('block_editor', [
        'blocks' => ['text', 'image']
    ])
@stop
