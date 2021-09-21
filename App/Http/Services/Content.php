<?php

namespace App\Http\Services;

use App\Http\Services\Response;
use App\Traits\StoreCatch;

class Content
{
    public static string $mainLayout;

    public static function viewController($filePath, $data)
    {
        if (isset($_SESSION['old'])) {
            StoreCatch::old($_SESSION['old']);
            unset($_SESSION['old']);
        }

        $viewContent = self::loadOnlyViewContent($filePath, $data);
        $mainLayout = self::loadMainLayout($data);

        $sections = preg_split('/@section/', $viewContent);
        array_shift($sections);

        $output = '';
        if ($mainLayout) {
            foreach ($sections as $section) {
                $sectionKey = '@yield' . substr($section, 0, strpos($section, ')') + 1);
                $section = substr($section, strpos($section, ')') + 1, strpos($section, '@endsection') - 16);
                $mainLayout = str_replace($sectionKey, $section, $mainLayout);
            }
            $output = $mainLayout;
        } else {
            foreach ($sections as $section) {
                $sectionKey = '@section' . substr($section, 0, strpos($section, ')') + 1);
                $viewContent = str_replace([$sectionKey, '@endsection'], '', $viewContent);
            }
            $output = $viewContent;
        }
        return $output;
    }

    private static function loadMainLayout($data)
    {
        ob_start();
        if (isset(self::$mainLayout)) {
            extract($data);
            include_once(self::$mainLayout);
        }
        return ob_get_clean();
    }

    private static function loadOnlyViewContent($view, $data)
    {
        ob_start();
        extract($data);
        include($view);
        return ob_get_clean();
    }
}
