<?php
return [
    'format'           => 'A4-L',
    'subject'          => 'This Document will explain the whole universe.',
    'keywords'         => 'PDF, Laravel, Package, Peace', // Separate values with comma
    'creator'          => 'Laravel Pdf',
    'display_mode'     => 'fullpage',
    'font_path' => base_path('resources/fonts/'),
    'font_data' => [
        'nunito' => [
            'R'  => 'Nunito-Regular.ttf',    // regular fonts
            'B'  => 'Nunito-Bold.ttf',       // optional: bold fonts
            'I'  => 'Nunito-Italic.ttf',     // optional: italic fonts
            'BI' => 'Nunito-BoldItalic.ttf', // optional: bold-italic fonts
            'EL' => 'Nutino-ExtraLight.ttf'
            //'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
            //'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
        ]
        // ...add as many as you want.
    ]
];
