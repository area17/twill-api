@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'description',
        'label' => 'Description',
        'maxlength' => 100,
        'translated' => true,
    ])

    @formField('medias', [
        'name' => 'cover',
        'label' => 'Cover Image',
    ])

    @formField('files', [
        'name' => 'attachment',
        'label' => 'Attachment',
    ])

    @formField('block_editor')
@stop
