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
            'I'  => 'Nunito-Italic.ttf',
            'L'  => 'Nunito-Light.ttf',// optional: italic fonts
            'BI' => 'Nunito-BoldItalic.ttf', // optional: bold-italic fonts
            'EL' => 'Nunito-ExtraLight.ttf'
            //'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
            //'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
        ],
        'manrope' => [
            'R'  => 'Manrope-Regular.ttf',    // regular fonts
            'B'  => 'Manrope-Bold.ttf',       // optional: bold fonts
            'I'  => 'Manrope-Italic.ttf',     // optional: italic fonts
            'L'  => 'Manrope-Light.ttf',     // optional: italic fonts
//            'BI' => 'Manrope-BoldItalic.ttf', // optional: bold-italic fonts
            //'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
            //'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
        ],
//        'windsong' => [
//                'R' => 'Windsong.ttf'
//            ]

        // ...add as many as you want.
    ]
];