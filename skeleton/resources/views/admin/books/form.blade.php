@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'subtitle',
        'label' => 'Subtitle',
        'translated' => true,
        'maxlength' => 100,
        'required' => true,
    ])

    @formField('input', [
        'name' => 'description',
        'label' => 'Description',
        'translated' => true,
        'maxlength' => 250,
        'type' => 'textarea',
        'rows' => 3
    ])

    @formField('medias', [
        'name' => 'cover',
        'label' => 'Cover Image'
    ])

    @formField('medias', [
        'name' => 'preview',
        'label' => 'Preview Images',
        'max' => 5,
    ])

    @formField('files', [
        'name' => 'attachment',
        'label' => 'Attachment',
    ])

    @formField('files', [
        'name' => 'attachments',
        'label' => 'Attachments',
        'max' => 4,
    ])

    @formField('date_picker', [
        'name' => 'publication_date',
        'label' => 'Publication Date',
        'minDate' => '2017-09-10 12:00',
        'withTime' => false,
    ])

    @formField('input', [
        'name' => 'isbn',
        'label' => 'ISBN',
        'maxlength' => 100,
    ])

    @formField('select', [
        'name' => 'available',
        'label' => 'Availability',
        'placeholder' => 'Select one',
        'options' => [
            [
                'value' => 'available',
                'label' => 'Available'
            ],
            [
                'value' => 'back-order',
                'label' => 'Back-order'
            ],
            [
                'value' => 'out-of-print',
                'label' => 'Out-of-print'
            ]
        ]
    ])

    @formField('multi_select', [
        'name' => 'formats',
        'label' => 'Formats',
        'min' => 1,
        'max' => 3,
        'options' => [
            [
                'value' => 'epub',
                'label' => 'EPUB'
            ],
            [
                'value' => 'hardcover',
                'label' => 'Hardcover'
            ],
            [
                'value' => 'paperback',
                'label' => 'Paperback'
            ],
        ]
    ])

    @formField('checkbox', [
        'name' => 'forthcoming',
        'label' => 'Forthcoming'
    ])

    @formField('checkboxes', [
        'name' => 'topics',
        'label' => 'Topics',
        'min' => 1,
        'max' => 3,
        'inline' => true,
        'options' => [
            [
                'value' => 'arts',
                'label' => 'Arts & Culture'
            ],
            [
                'value' => 'finance',
                'label' => 'Banking & Finance'
            ],
            [
                'value' => 'civic',
                'label' => 'Civic & Public'
            ],
        ]
    ])

    @formField('browser', [
        'moduleName' => 'authors',
        'name' => 'authors',
        'label' => 'Authors',
        'max' => 5,
    ])

    @formField('wysiwyg', [
        'name' => 'summary',
        'label' => 'Summary',
        'note' => 'Rich-text summary',
        'translated' => true,
    ])

    @formField('block_editor')
@stop
