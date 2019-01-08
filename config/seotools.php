<?php

return [
    'meta'      => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => "PL Tutuorials || CE Course Materials BUET - P.L. Tutorials | The home of soft materials", // set false to total remove
            'description'  => 'PL Tutorials is a website dedicated for students of buet. At first it was only for the students of Civil Engineering Department, but now the site serves all student. It was launched on year May 2015 . A big number of student were helped by this site and currently this site is also serving for all current students of buet.', // set false to total remove
            'separator'    => ' - ',
            'keywords'     => ['PL Tutuorials','CE Course Materials BUET','P.L. Tutorials','The home of soft materials','pl tutorials buet','ce course materials', 'pl tutorials weebly','civil materials buet','buet civil engineering','pl-tutorials.com','pl tuts'],
            'canonical'    => null, // Set null for using Url::current(), set false to total remove
        ],

        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => 'PBMxea_eN0W8LipvPuiASvMq_DjiV5aV_8MlUE_hQ2k',
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
        ],
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'PL Tutuorials || CE Course Materials BUET - P.L. Tutorials | The home of soft materials', // set false to total remove
            'description' => 'PL Tutorials is a website dedicated for students of buet. At first it was only for the students of Civil Engineering Department, but now the site serves all student. It was launched on year May 2015 . A big number of student were helped by this site and currently this site is also serving for all current students of buet.', // set false to total remove
            'url'         => null, // Set null for using Url::current(), set false to total remove
            'type'        => false,
            'site_name'   => 'PL Tutorials',
            'images'      => [],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
          //'card'        => 'summary',
          //'site'        => '@LuizVinicius73',
        ],
    ],
];
