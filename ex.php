<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

spl_autoload_register(function($class_name) {
    require_once("Draw/$class_name.php");
});

$item = [
    "type" => "group",
    "layout" => "absolute",
    "width" => 640,
    "height" => 160,
    "items" => [
        [
            "type" => "image",
            "value" => "wwiiol-air.png"
        ],
        [
            "type" => "group",
            "layout" => "vertical",
            "posHorizontalAlign" => "right",
            "posHorizontalOffset" => 30,
            "posVerticalOffset" => 30,
            "items" => [
                [
                    "type" => "text",
                    "color" => "#D43838",
                    "fontFamily" => "12tonsushi",
                    "fontSize" => 30,
                    "value" => "longer text goes here"
                ],
                [
                    "type" => "group",
                    "layout" => "vertical",
                    "items" => [
                        [
                            "type" => "group",
                            "layout" => "absolute",
                            "height" => 26,
                            "items" => [
                                [
                                    "type" => "image",
                                    "value" => "ace.png"
                                ],
                                [
                                    "type" => "text",
                                    "backgroundColor" => "#FFFF0099",
                                    "color" => "#D43838",
                                    "fontFamily" => "12tonsushi",
                                    "fontSize" => 17,
                                    "value" => "Top Left",
                                    "posHorizontalOffset" => 16
                                ],
                                [
                                    "type" => "image",
                                    "posHorizontalAlign" => "right",
                                    "value" => "year1.png"
                                ]
                            ]
                        ],
                        [
                            "type" => "group",
                            "layout" => "horizontal",
                            "items" => [
                                [
                                    "type" => "text",
                                    "backgroundColor" => "#FFFF0099",
                                    "color" => "#D43838",
                                    "fontFamily" => "12tonsushi",
                                    "fontSize" => 17,
                                    "value" => "Top Left"
                                ],
                                [
                                    "type" => "image",
                                    "posHorizontalAlign" => "right",
                                    "value" => "ace.png"
                                ],
                                [
                                    "type" => "image",
                                    "posHorizontalAlign" => "right",
                                    "value" => "year1.png"
                                ]
                            ]
                        ],
                        [
                            "type" => "text",
                            "color" => "#000000",
                            "fontFamily" => "12tonsushi",
                            "fontSize" => 17,
                            "posHorizontalAlign" => "center",
                            "value" => "Middle text"
                        ],
                        [
                            "type" => "group",
                            "layout" => "horizontal",
                            "items" => [
                                [
                                    "type" => "image",
                                    "value" => "ace.png",
                                    "width" => 26
                                ],
                                [
                                    "type" => "image",
                                    "posHorizontalAlign" => "right",
                                    "value" => "ace.png"
                                ],
                                [
                                    "type" => "image",
                                    "value" => "year1.png"
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];

$drawer = Item::create($item);	/* Create items recursively */
$img = $drawer->finalize();	/* Returns Imagick instance */
$img->writeImage('out.png');

?>
