<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function convertImageToString($image)
    {
        $binary = file_get_contents($image->getRealPath());

        $json = [
            'base64' => base64_encode($binary),
            'mimeType' => $image->getMimeType(),
        ];

        return 'data: '. $json['mimeType'] . ';base64,' . $json['base64'];
    }
}
