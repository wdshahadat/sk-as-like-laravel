<?php

namespace App\Http\Controllers;

use App\Http\Controllers\FileUpload;

class Controller
{
    use FileUpload;

    public function auth()
    {
        echo 'from controller class auth method';
    }
}
