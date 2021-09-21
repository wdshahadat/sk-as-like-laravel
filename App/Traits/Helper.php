<?php

$needReplace = str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname($_SERVER['SCRIPT_FILENAME']));
define("NEED_REPLACE", $needReplace);
define('JSON', 'Content-type: application/json; charset=UTF-8');
define('ROOT', dirname(dirname(__DIR__)));
define('BASE', str_replace('\\', '/', ROOT) . '/');
define('VIEW', BASE . 'resource/views/');

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

function base_url(): string
{
    $path = sprintf(
        "%s://%s%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        $_SERVER['PHP_SELF']
    );

    return dirname($path) . '/';
}
define("BASE_URL", base_url());
define("CURRENT_URI", $uri);
define("URI", str_replace(NEED_REPLACE, '', CURRENT_URI));

if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

use App\Http\Services\Route;
use App\Http\Controllers\Auth;
use App\Http\Services\Response;
use App\Http\Services\Content;
use App\Http\Services\Request;
use App\Traits\StoreCatch;

function pathToBladeFile($path)
{
    $path = str_replace(['&quo', 't;', '\'', '"'], '', $path);
    return str_replace(['.', '\\', '//', '///'], '/', $path) . '.blade.php';
}

function setTitle($title)
{
    Request::$pageTitle = $title;
}

function getTitle()
{
    echo Request::$pageTitle;
}

function fileNotExists()
{
}

function notFound()
{
}

function getSession($key = '')
{
    if (isset($_SESSION['tempSession'][$key])) {
        $session = $_SESSION['tempSession'][$key];
        unset($_SESSION['tempSession'][$key]);
        return $session;
    }
    return false;
}

function messageHandle($msKey, $alert, $toEcho = false)
{
    $message = $_SESSION;
    if (isset($msKey) && is_array($msKey)) {
        $message = $msKey;
        $msKey = array_key_first($message);
    }

    if (isset($message[$msKey]) && is_array($message[$msKey]) && $toEcho) {
        $alert = "<div  class=\"alert ml-2 mr-2 alert-{$alert}\">";
        foreach ($message[$msKey] as $key => $value) {
            $alert .= "<p><b>{$key}: </b>{$value}</p>";
        }
        echo $alert . '</div>';
        unset($message[$msKey]);
    } elseif (isset($message[$msKey])) {
        $alert = $message[$msKey];
        unset($message[$msKey]);
        return $alert;
    }
}

function notification()
{
    $toastr = getSession('toastr');
    if ($toastr) {
        return json_encode($toastr);
    }
}

function errorAlerts()
{
    if (isset($_SESSION['tempSession']['error'])) {
        $error = $_SESSION['tempSession']['error'];
        unset($_SESSION['tempSession']['error']);
        return  messageHandle(['error' => $error], 'danger', 1);
    }
}

function getOld($key = '')
{
    $old = StoreCatch::$old;
    return isset($old[$key]) ? $old[$key] : '';
}

function user($id = false)
{
    return Auth::user($id);
}

function nrc()
{
    return NEED_REPLACE;
}
function view($filePath, $data = [])
{
    $filePath = pathToBladeFile(VIEW . $filePath);
    if (!file_exists($filePath)) {
        return fileNotExists();
    }
    $htmlData =  file_get_contents($filePath);
    $mainLayout = preg_split('/@extends/', $htmlData);

    if (isset($mainLayout[1])) {
        $mainLayout = substr($mainLayout[1], 1, strpos($mainLayout[1], ')') - 1);
        Content::$mainLayout = pathToBladeFile(VIEW . $mainLayout);
    }
    return Content::viewController($filePath, $data);
}

function response($data)
{
    if (isset($data)) {
        return ['data' => $data];
    }
}

function redirect($to = null): Route
{
    $router = new Route();
    if ($to) {
        $router->to($to);
    }
    return $router;
}

function csrf()
{
    $token = sha1(md5(rand() . time()));
    $_SESSION['csrf_token'] = $token;
    echo '<input type="hidden" name="_token" value="' . $token . '">';
}

function csrfCheck()
{
    $data = Request::$requestData;
    $token = isset($data['_token']) ? $data['_token'] : false;
    if ($token && $_SESSION['csrf_token'] === $token) {
        return true;
    }
    return false;
}

function asset($filePath)
{
    $file = "public/{$filePath}";
    return  BASE_URL . str_replace('//', '/', $file);
}


function route($path, $routeParams = false, $questionParam = false)
{
    $path = strpos($path, '/') === 0 ? $path : "/{$path}";
    $checkRoute = Route::hasRoutParams($path);

    if ($checkRoute === null) {
        echo "<p style=\"color:#c30c0c\"><b>Sorry:</b> your given
        route is wrong { uri= <b style=\"color:red\">{$path}</b> }</p>";
        return false;
    }

    if ($checkRoute && !$routeParams) {
        echo "<p style=\"color:#c30c0c\"><b>Sorry:</b> you must provide a
        router perimeter { uri= <b style=\"color:red\">{$path}</b> }</p>";
        return false;
    }

    if ($checkRoute) {
        $checkRoute = explode('/', $checkRoute);
        $p_length = count($checkRoute);

        if ($p_length > 1 && (!is_array($routeParams) || (is_array($routeParams) && $p_length !== count($routeParams)))) {
            echo "<p style=\"color:#c30c0c\"><b>Sorry:</b> you must provide a router
            perimeter as an array and array length must be {$p_length}</p>";
            return false;
        }
        $routeParams = is_array($routeParams) ? implode('/', $routeParams) : implode('/', [$routeParams]);
        $path = "{$path}{$routeParams}";
    }

    if ($questionParam) {
        if (is_string($questionParam)) {
            $questionParam = "?{$questionParam}";
        } elseif (is_object($questionParam)) {
            $questionParam = "?id={$questionParam->id}";
        } elseif (is_array($questionParam)) {
            $param_ = $questionParam;
            $questionParam = '?';
            foreach ($param_ as $key => $value) {
                $questionParam .= "{$key}={$value}";
            }
        }
        $path = "{$path}{$questionParam}";
    }
    $path = BASE_URL . (strpos($path, '/') === 0 ? substr($path, 1, strlen($path)) : $path);
    $path = str_replace(' ', '', $path);
    return $path;
}


function _($str)
{
    echo isset($str) && (is_string($str) || is_bool($str)) ? trim($str) : '';
}

function frontendLoader($extension, $filePaths)
{
    $default = BASE . "/public/assets/{$extension}/";
    $filePaths = is_array($filePaths) ? $filePaths : [$filePaths];

    foreach ($filePaths as $file) {
        $file = "{$default}{$file}.{$extension}";

        $file = str_replace('//', '/', $file);

        if (file_exists($file)) {
            if ($extension === 'js') {
                _('<script defer src="' . $file . '"></script>');
            } else {
                _('<link rel="stylesheet" href=""' . $file . '"">');
            }
        } else {
            _('<b>File not exists-> </b> ' . BASE . '/' . $file);
        }
    }
}

function jsLoad($file)
{
    return frontendLoader('js', $file);
}

function cssLoad($file = '')
{
    return frontendLoader('css', $file);
}

function isLogged($redirect = false)
{
    if (!Auth::isLogged()) {
        return $redirect ? redirect($redirect) : false;
    }
    return true;
}
