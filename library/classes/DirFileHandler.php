<?php
/**
 * FileHandler Class
 * @package		FileHandler Class
 * @link		http://zincksoft.com
 * @author		Zincksoft.com <info@zincksoft.com>
 * @copyright	2007 - 2014 Zincksoft.com <info@zincksoft.com>
 * @version		1.0.1
**/

class DirFileHandler {
	
	
	/**
     * Clear all text in a file.
	 */
	 
	public function ResetFile($file) {
        $new_file = "";
        if (!is_dir($file)) {
            $fp = @fopen($file, 'w');
            @fwrite($fp, $new_file);
            @fclose($fp);
        }
    }
	
	
	/**
     * Updates an existing file and will chmod it too if required.
	 */
	
	
	public function UpdateFile($path, $chmod = 0777, $string = "") {
        if (!file_exists($path))
            $this->ResetFile($path);
        $fp = @fopen($path, 'w');
        @fwrite($fp, $string);
        @fclose($fp);
        $this->SetFileSystemPermissions($path, $chmod);
        return true;
    }
	
	
	
	/**
     * Newline.
	 */
	
	
	public function NewLine() {
            $retval = "\n";
        return $retval;
    }
	
	
	 /**
     * Renames a file or a folder.
	 */
	 
	 public function RenameFileFolder($source, $target) {
        if (rename($source, $target))
            return true;
        return false;
    }
	
	/**
     * Checks that a folder exists or not.
	 */
	 
	 public function CheckFolderExists($path) {
        if (file_exists($path)) {
            if (is_dir($path))
                return true;
            return false;
        }
    }
	
	
	/**
     * Checks if a file exists or not.
	 */
	 
	 public function CheckFileExists($path) {
        if (file_exists($path)) {
            if (is_file($path))
                return true;
            return false;
        }
        return false;
    }
	
	
	/**
     * Sets file/directory permissions on a given path.
	 */
	 
	 public function SetFileSystemPermissions($path, $mode) {
        if (file_exists($path)) {
            @chmod($path, $mode);
            $retval = true;
        } else {
            $retval = false;
        }
        return $retval;
    }
	
	/**
     * Removes (Deletes) a directory and all folders/file within it.
	 */
	 
	 public function RemoveDirectory($path) {
        if (!$dh = @opendir($path))
            return false;
        while (false !== ($obj = readdir($dh))) {
            if ($obj == '.' || $obj == '..')
                continue;
            if (!@unlink($path . '/' . $obj))

            $this->RemoveDirectory($path . '/' . $obj, true);
        }
        closedir($dh);
        @rmdir($path);
        return true;
    }
	
	
	/**
     * Creates a directory if it doesn't already exist!
	 */
	 
	 public function CreateDirectory($path) {
        if (!file_exists($path)) {
            @mkdir($path, 0777, true);
            $this->SetFileSystemPermissions($path, 0777);
            $retval = true;
        } else {
            $retval = false;
        }
        return $retval;
    }
	
	
	/**
     * Takes a raw file size value (bytes) and converts it to human readable size with the correct abbreavation.
	 */
	 
	 public function ShowHumanFileSize($size) {
        if ($size / 1024000000 > 1) {
            $retval = round($size / 1024000000, 1) . ' GB';
        } elseif ($size / 1024000 > 1) {
            $retval = round($size / 1024000, 1) . ' MB';
        } elseif ($size / 1024 > 1) {
            $retval = round($size / 1024, 1) . ' KB';
        } else {
            $retval = round($size, 1) . ' bytes';
        }
        return $retval;
    }
	
	 /**
     * Remove double slashes.
	 */
	 
	 public function RemoveDoubleSlash($var) {
        $retval = str_replace("\\\\", "\\", $var);
        return $retval;
    }
	
	
	/**
     * Converts to proper slashes
	 */
	 
	 public function ConvertSlashes($string) {
        
		$retval = $this->SlashesToNIX($string);
        
        return $retval;
    }
	
	
	/**
     * Converts Windows slashes '\' to UNIX/PHP path slashes '/'.
	 */
	 
	public function SlashesToNIX($string) {
        return str_replace("\\", "/", $string);
    }
	
	
	
	/**
	 * Removes a Directory's contents (without removing the directory itself)
	 */
	 
	 public function RemoveDirectoryContents($dir) {
		$dir = $this->ConvertSlashes($dir);
		if (is_dir($dir)) {
			$files = dir($dir);
			if($files) {
				while ($file = $files->read()) {
					if ($file != '.' && $file != '..') {			
						if (is_dir($dir.$file)) {
							$this->RemoveDirectoryContents($this->ConvertSlashes($dir.$file.'/'));
							rmdir($dir.$file);
						} else
						unlink($dir.$file);
					}
				}
			}
			$files->close();
		}
	}
	
	
	/**
	 * Removes a Directory and its contents
	 */
	 
	 public function RemoveDirectoryNew($dir) {
		$dir = $this->ConvertSlashes($dir);
		if (is_dir($dir)) {
			$this->RemoveDirectoryContents($dir);
			rmdir($dir);
		}
	}
	
	
	/**
     * Copies and overwrites existing file
	 */
	 
	public function CopyFileWithOverwrite($src, $dest) {
            @copy($src, $dest);
    }
	
	
	/**
     * Copies without overwritting an existing file.
	* */
	
	public function CopyFile($src, $dest) {
        if (!file_exists($dest)) {
            @copy($src, $dest);
        }
    } 
	 
	
	/**
     * Clear all text in a file.
	 * */
	 
	public function BlankFile($file) {
        $new_file = "";
        if (!is_dir($file)) {
            $fp = @fopen($file, 'w');
            @fwrite($fp, $new_file);
            @fclose($fp);
        }
    }
	
	
	
	/**
     * Create blank or populated file with permissions, including the path.
     */
    static function CreateFile($path, $chmod = 0777, $string = "") {
        if (!is_file($path)) {
            preg_match('`^(.+)/([a-zA-Z0-9]+\.[a-z]+)$`i', $path, $matches);
            $directory = $matches[1];
            $file = $matches[2];
            if (!is_dir($directory)) {
                if (!mkdir($directory, $chmod, 1)) {
                    return FALSE;
                }
            }
            $fp = @fopen($path, 'w');
            @fwrite($fp, $string);
            @fclose($fp);
            $this->SetFileSystemPermissions($dest, $chmod);
        }
    }
	
	
	
}