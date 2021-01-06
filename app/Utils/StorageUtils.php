<?php

namespace App\Utils;

use Config;

class StorageUtils
{
    /**
     * Constantes de visibilidade
     * @var String
     */
    const PUBLIC_VISIBILITY = "public";
    const PRIVATE_VISIBILITY = "private";

    /**
     * Defines the file name
     * @return String
     */
    public static function defineFileName()
    {
        return DateUtils::getUnderscoredCurrentDate() . uniqid();
    }

    /**
     * Obtém a extensão do arquivo
     * @param File $file
     * @return String $fileExtension
     */
    public static function getFileExtension($file)
    {
        return $file->getClientOriginalExtension();
    }

    /**
     * Obtém o nome do diretório através do caminho
     * @param String $pathToFind
     * @return String
     */
    public static function getDirNameFromPath($pathToFind)
    {
        return pathinfo($pathToFind, PATHINFO_DIRNAME);
    }

    /**
     * Obtém o nome do arquivo através do caminho
     * @param String $pathToFind
     * @return String
     */
    public static function getFileNameFromPath($pathToFind)
    {
        return pathinfo($pathToFind, PATHINFO_FILENAME);
    }

    /**
     * Obtém o nome da base através do caminho
     * @param String $pathToFind
     * @return String
     */
    public static function getBaseNameFromPath($pathToFind)
    {
        return pathinfo($pathToFind, PATHINFO_BASENAME);
    }

    /**
     * Obtém a extensão do arquivo através do caminho
     * @param String $pathToFind
     * @return String
     */
    public static function getFileExtensionFromPath($pathToFind)
    {
        return pathinfo($pathToFind, PATHINFO_EXTENSION);
    }

    /**
     * Obtém o sistema de arquivos padrão
     * @return String $fileSystemDriver
     */
    public static function getFileSystemDriver()
    {
        return  Config::get('filesystems.default');
    }
}
