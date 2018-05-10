<?php

namespace App\Upload;


use Psr\Http\Message\UploadedFileInterface;

/**
 * Class ImageUpload
 * @package App\Upload
 */
class ImageUpload implements UploadInterface
{

    /**
     * @var UploadedFileInterface
     */
    private $uploadFile;

    /**
     * @var array
     */
    private $errors = [];

    /**
     * @var null|string
     */
    private $fileName = null;

    /**
     * ImageUpload constructor.
     * @param UploadedFileInterface $uploadedFile
     */
    public function __construct(UploadedFileInterface $uploadedFile)
    {
        $this->uploadFile = $uploadedFile;
        $this->validation();

    }

    /**
     * @param $filename
     * @return bool
     */
    public function move($filename = null)
    {
        $this->generateName($filename);

        if ($this->isValid()) {
            $this->uploadFile->moveTo($this->getUploadDirectory() . $this->getFileName());
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return empty($this->errors);
    }



    private function validation()
    {
        $file = $this->uploadFile;

        if (!in_array($file->getClientMediaType(), $this->getMediasType())) {
            $this->addError('Type de fichier invalide');
        }

        if ($file->getSize() > $this->getMaxSize()) {
            $this->addError(sprintf('Le fichier ne doit pas dépasser %s MB', $this->getMaxSize()));
        }
    }

    /**
     * @return ImageUpload
     */
    private function generateName($name = null)
    {

        $this->fileName = sprintf(
            '%s.%s',
            $name ?: uniqid(),
            pathinfo(
                $this->uploadFile->getClientFilename(),
                PATHINFO_EXTENSION
            )
        );
        return $this;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }


    /**
     * @param string $error
     * @return $this
     */
    private function addError(string $error)
    {
        $this->errors[] = $error;
        return $this;
    }

    /**
     * @return string
     */
    public function getUploadDirectory()
    {
        return 'public/images/';
    }

    /**
     * @return array
     */
    public function getMediasType()
    {
        return [
            'image/jpeg'
        ];
    }

    /**
     * @return int
     */
    public function getMaxSize()
    {
        return 1000000;
    }

    /**
     * @return string
     */
    public function getFileName()
    {

        if (is_null($this->fileName)) {
            $this->generateName();
        }
        return $this->fileName;

    }


}
