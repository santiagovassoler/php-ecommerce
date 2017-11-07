<?php
class Image {

  //default settings
  public $destination = '/images/';
  public $fileName = 'file.txt';
  public $maxSize = '1048576'; // bytes (1048576 bytes = 1 meg)
  public $allowedExtensions = array('image/jpeg','image/png','image/gif'); // mime types
  public $printError = TRUE;
  public $error = '';


  public function getName() {
    $this->fileName = $fileName;
  }
  //START: Functions to Change Default Settings
  public function setDestination($newDestination) {
    $this->destination = $newDestination;
  }
  public function setFileName($newFileName) {
      $this->fileName = $newFileName;
  }
  public function setPrintError($newValue) {
    $this->printError = $newValue;
  }
  public function setMaxSize($newSize) {
    $this->maxSize = $newSize;
  }
  public function setAllowedExtensions($newExtensions) {
    if (is_array($newExtensions)) {
      $this->allowedExtensions = $newExtensions;
    }
    else {
      $this->allowedExtensions = array($newExtensions);
    }
  }
  //END: Functions to Change Default Settings

  //START: Process File Functions
  public function upload($file) {

    $this->validate($file);

    if ($this->error) {
      if ($this->printError) print $this->error;
    }
    else {
      //var_dump($this->destination.$file['name']);
      move_uploaded_file($file['tmp_name'], $this->destination.$this->fileName) or $this->error .= 'Destination Directory Permission Problem.<br />';
      if ($this->error && $this->printError) print $this->error;
    }
  }
  public function delete($file) {

    if (file_exists($file)) {
      unlink($file) or $this->error .= 'Destination Directory Permission Problem.<br />';
    }
    else {
      $this->error .= 'File not found! Could not delete: '.$file.'<br />';
    }

    if ($this->error && $this->printError) print $this->error;
  }
  //END: Process File Functions

  //START: Helper Functions
  public function validate($file) {

    $error = '';

    if (empty($file['name'])) $error .= ' No file found ';
    //check allowed extensions
    if (!in_array($this->getExtension($file),$this->allowedExtensions)) $error .= ' Extension is not allowed';
    //check file size
    if ($file['size'] > $this->maxSize) $error .= 'Max File Size Exceeded. Limit: '.$this->maxSize.' bytes.';

    $this->error = $error;
  }
  public function getExtension($file) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $ext = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    return $ext;
  }
  //END: Helper Functions

}
