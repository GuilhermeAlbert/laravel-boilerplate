<?php

namespace App\Services;

use App\Interfaces\Services\StorageInterface;
use App\Utils\{StorageUtils};
use Illuminate\Support\Facades\{Storage};

class FileStorageService implements StorageInterface
{
    // Protected variable context
    protected $storage;

    /**
     * Constructor method to instantiate a instance
     */
    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Realiza a instância do storage
     * @return Instance
     */
    public function instantiate()
    {
        $fileSystemDriver = StorageUtils::getFileSystemDriver();
        return $this->storage::disk($fileSystemDriver);
    }

    /**
     * Realiza o upload do arquivo para o bucket
     * @param String $pathToSave
     * @param File $file
     * @param String $visibility
     * @return string $filePath
     */
    public function upload($pathToSave, $file, $visibility)
    {
        $bucket = $this->instantiate();

        // Verifica se existe a pasta onde será salvo
        $dirName = StorageUtils::getDirNameFromPath($pathToSave);
        $hasPathToSave = $this->has($bucket, $dirName);

        // Cria a pasta se não existir
        if (!$hasPathToSave) $bucket->createDir($bucket, $dirName);

        // Salva o arquivo no bucket
        $this->put($bucket, $pathToSave, $file, $visibility);

        // Retorna o caminho de onde foi salvo
        return $this->url($bucket, $pathToSave);
    }

    /**
     * Verifica se o caminho existe
     * @param Bucket $bucket
     * @param String $pathToFind
     * @return Boolean
     */
    public function has($bucket, $pathToFind)
    {
        return $bucket->has($pathToFind);
    }

    /**
     * Cria um diretório no storage
     * @param Bucket $bucket
     * @param String $pathToCreate
     * @return Boolean
     */
    public function createDir($bucket, $pathToCreate)
    {
        return $bucket->createDir($pathToCreate);
    }

    /**
     * Verifica se o arquivo existe
     * @param Bucket $bucket
     * @param String $pathToFind
     * @return Boolean
     */
    public function exists($bucket, $pathToFind)
    {
        return $bucket->exists($pathToFind);
    }

    /**
     * Procura um arquivo pela URL informada
     * @param Bucket $bucket
     * @param String $pathToFind
     * @return String $url
     */
    public function url($bucket, $pathToFind)
    {
        return $bucket->url($pathToFind);
    }

    /**
     * Salva o conteúdo do arquivo no storage
     * @param Bucket $bucket
     * @param String $pathToSave
     * @param File $fileContent
     * @param String $visibility
     * @return Boolean
     */
    public function put($bucket, $pathToSave, $fileContent, $visibility)
    {
        return $bucket->put($pathToSave, $fileContent, $visibility);
    }

    /**
     * Realiza o append no documento
     * @param Bucket $bucket
     * @param String $pathToSave
     * @param File $fileContent
     * @param String $visibility
     * @return Boolean
     */
    public function append($bucket, $pathToSave, $fileContent)
    {
        return $bucket->append($pathToSave, $fileContent);
    }

    /**
     * Muda a visibilidade do arquivo no bucket
     * @param Bucket $bucket
     * @param String $pathToFind
     * @param String $visibility
     * @return Boolean
     */
    public function setVisibility($bucket, $pathToFind, $visibility)
    {
        return $bucket->setVisibility($pathToFind, $visibility);
    }

    /**
     * Deleta o arquivo do bucket
     * @param Bucket $bucket
     * @param String $pathToFind
     * @return Boolean
     */
    public function delete($bucket, $pathToFind)
    {
        if ($this->exists($bucket, $pathToFind)) return $bucket->delete($pathToFind);
    }

    /**
     * Obtém o prefixo do caminho do bucket
     * @param Bucket $bucket
     * @param String $pathToFind
     * @return String
     */
    public function getPathPrefix($bucket)
    {
        return $bucket->getAdapter()->getPathPrefix();
    }
}
