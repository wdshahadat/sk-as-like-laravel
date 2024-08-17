<?php

namespace App\Http\Controllers;

class Controller
{
    use FileUpload;

    public function auth()
    {
        echo 'from controller class auth method';
    }
}
