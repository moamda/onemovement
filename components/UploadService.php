<?php

namespace app\components;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class UploadService
{
    /**
     * Upload a file.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @return string
     */
    public static function upload(UploadedFile $file, string $folder): string
    {
        $path = Yii::getAlias("@app/data/uploads/{$folder}");

        FileHelper::createDirectory($path);

        $filename = Yii::$app->security->generateRandomString(40)
            . '.' . $file->extension;

        $file->saveAs($path . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }

    /**
     * Get absolute path.
     *
     * @param string $folder
     * @param string $filename
     * @return string
     */
    public static function path(string $folder, string $filename): string
    {
        return Yii::getAlias("@app/data/uploads/{$folder}/{$filename}");
    }

    /**
     * Delete file.
     *
     * @param string $folder
     * @param string|null $filename
     * @return bool
     */
    public static function delete(string $folder, ?string $filename): bool
    {
        if (empty($filename)) {
            return false;
        }

        $path = self::path($folder, $filename);

        if (is_file($path)) {
            return unlink($path);
        }

        return false;
    }
}
