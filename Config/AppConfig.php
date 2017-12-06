<?php
return [

    'MYSQL'=>[

        "DEFAULT"=>[
            "DB_HOST"=>'127.0.0.1',
            "DB_NAME"=>'money',
            "DB_USER"=>'root',
            "DB_PASSPORT"=>'root',
            "DB_PORT"=>'3306',
            "DB_PERSISTENT"=>false,
        ],

    ],
    'REDIS'=>[

        'DEFAULT'=>[
            "REDIS_HOST"=>"",
            "REDIS_PORT"=>"",
            "REDIS_AUTH"=>"",
        ]

    ],
    'TIMEZONE'=>'Asia/Shanghai',
    'CHARSET'=>'UTF-8',
    'CACHE_DIR'=>'/tmp/',
    'LOG_DIR'=>'/tmp/',

];
