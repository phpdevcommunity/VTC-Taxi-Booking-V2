<?php

namespace App\Upload;


interface UploadInterface
{

    /**
     * @return string
     */
  public function getUploadDirectory();

    /**
     * @return array
     */
  public function getMediasType();

    /**
     * @return int
     */
  public function getMaxSize();

}
