<?php
//support psr-4
$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return[

    'Vendor\\Blade\\' =>[
        "autoload_files"=>$vendorDir . '/blade/src/helpers.php',
        "autoload_src"=>$vendorDir . '/blade/src/',
    ]
];
