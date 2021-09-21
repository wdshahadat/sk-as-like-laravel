<?php

namespace App\Http\Controllers;

/**
 *
 */
trait FileUpload
{

    // Get file from table by condition
    public function fileManage($file = [], $strFile = false)
    {
        $errorMessage = [];
        $fileKey = array_key_first($file);

        if (!empty($file) && !empty($_FILES[$fileKey]['name'])) {
            $filePath = $file[$fileKey];
            $filePath = strpos($filePath, '/') === 0 ? substr($filePath, 1, strlen($filePath)) : $filePath;
            $filePath = "public/{$filePath}";
            $fileMovePath = BASE . "/{$filePath}";
            if (!file_exists($fileMovePath)) {
                @mkdir($fileMovePath, 0777, true);
            }
            $filename = $_FILES[$fileKey]['name'];

            // Valid image file extensions
            $valid_extensions = array("jpg", "jpeg", "png", "pdf");

            // File extension
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            if (in_array(strtolower($extension), $valid_extensions)) {
                $filename = md5(round(time())) . '.' . $extension;
                $fileMovePath = str_replace('//', '/', "{$fileMovePath}/{$filename}");
                $filename = str_replace('//', '/', "{$filePath}/{$filename}");
                if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $fileMovePath)) {
                    $oldPath = BASE . "/{$strFile}";
                    if ($strFile && file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                    // return [$filename, $oldPath];
                    return $filename;
                } else {
                    $errorMessage = ['Action Failed' => 'Sorry! Please retry.'];
                }
            } else {
                $errorMessage = ['Invalid' => 'Sorry! Please select a valid file.'];
            }
        } elseif (isset($file['required'])) {
            $errorMessage = ucfirst(str_replace(['_', '-'], ' ', $fileKey));
            $errorMessage = [$errorMessage => "{$errorMessage} is required!"];
        }
        if (!empty($errorMessage)) {
            return redirect()->back()->with(['error' => $errorMessage]);
        }
        return $strFile;
    }
}
