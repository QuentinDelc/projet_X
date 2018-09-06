<?php
Class UploadImage {

	public $message;
	public $pathSave = 'images';
	private $__maxSize;
	private $__availableExtensions = ['png', 'jpeg', 'jpg', 'gif'];


	public function __construct($maxSize = 2097152) {
		$this->__maxSize = $maxSize;
	}


	public function upload($file) {
		$extension = $this->__validateExtension($file['name']);
		$size      = $this->__validateSize($file['size']);
		$error     = $this->__validateError($file['error']);

		if ($extension && $size && $error) :
			$this->__createFolder();
			move_uploaded_file($file['tmp_name'], $this->pathSave . '/' . $file['name']);
			$this->message = 'Super';
		endif;
	}


	private function __createFolder() {
		if (!is_dir($this->pathSave)) :
			mkdir($this->pathSave);
		endif;
	}


	private function __validateExtension($filename) {
		$extension = new SplFileInfo($filename);
		$extension = $extension->getExtension();
		$extension = strtolower($extension);

		if (in_array($extension, $this->__availableExtensions)) :
			$result = true;
		else :
			$message = implode(', ', $this->__availableExtensions);
			$this->message = 'Merci de charger une image avec l\'une de ces extensions : ' . $message . '.';
			$result  = false;
		endif;

		return $result;
	}


	private function __validateSize($size) {
		if ($size <= $this->__maxSize) :
			$result = true;
		else :
			$size = $this->__convertSize($this->__maxSize);
			$this->message = 'Merci de charger une avec un poids inférieur à : ' . $size . '.';
			$result  = false;
		endif;

		return $result;
	}


	private function __validateError($error) {
		if ($error === 0) :
			$result = true;
		else :
			$this->message = 'Il y a eu une erreur.';
			$result = false;
		endif;

		return $result;
	}


	private function __convertSize($octet) {
		$unit = ['octets', 'ko', 'mo', 'go'];

		if ($octet < 1000) : // Octet
			$result = $octet . ' ' . $unit[0];
		elseif ($octet < 1000000) : // Ko
			$ko     = round($octet/1024, 2);
			$result = $ko . ' ' . $unit[1];
		elseif ($octet < 1000000000) : // Mo
			$mo     = round($octet/(1024*1024), 2);
			$result = $mo . ' ' . $unit[2];
		else : // Go
			$go     = round($octet/(1024*1024*1024), 2);
			$result = $go . ' ' . $unit[3];
		endif;

		return $result;
	}
}