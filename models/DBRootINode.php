<?php
use Sabre\DAV;
/**
 * Container listing configured available objects
 */
class DBRootINode extends Sabre\DAV\Collection {
	
	private $children;
	private $w;
	
	function __construct($w) {
		$webdavConfig=Config::get('webdav');
		$this->children = $webdavConfig['availableObjects'];
		$this->w=$w;
	}
	
	/**
	 * returns the file/directory name.
	 */
	function getName() {
		return 'DB';
	} 
	
	/**
	 *  Returns true if a child node exists.
	 */
	function childExists($name) {
		if (array_key_exists($name,$this->children)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Returns a File or Directory object for the child-node of the given name.
	 */
	function getChild($name) {
		$parts=explode('/',ROOT_PATH);
		if ($name==$parts[count($parts)-1]) {
			return new DAV\FS\Directory(ROOT_PATH);
		} if ($name=='attachments') {
			return new DAV\FS\Directory(ROOT_PATH.'/uploads/attachments');
		} 
		$iNode=new ClassINode($this->w,$name);
		return $iNode;
	} 
	
	/**
	 * Returns an array of File and/or Directory objects.
	 */
	function getChildren() {
		$result=[];
		foreach ($this->children as $name => $details) {
			$iNode=new ClassINode($this->w,$name);
			$result[]=$iNode;
		}
		//if (Config::get('webdav.allow??')) 
		$result[]=new DAV\FS\Directory(ROOT_PATH);
		$result[]=new DAV\FS\Directory(ROOT_PATH.'/uploads/attachments');
		
		//print_r($result);
		//throw new Exception('eee');
		return $result;
	} 
	
	/**
	 * returns the last modification time as a unix timestamp.
	 */
	function getLastModified() {
		return 0;
	}
	
	/********************************************
	 * NOT IMPLEMENTED for RO filesystem
	 *******************************************/
	//function delete() {} 
	//function setName($newName) {} 
	//function createFile($name,$data) {} 
	//function createDirectory($name) {}
	
}
