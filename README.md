#Webdav module

## Summary
The webdav module provides access to Attachments stored in the system using a Webdav filesystem client.
The filesystem tree reflects the objects that contain the attachments.

eg
DB
	TaskGroups
		Dev Team 1
			Files
				contract.txt
			Tasks
				README.txt
				screen.png
			
The tree is not editable but the files inside are.

By default, Attachments can be associated with any Object regardless of the Cmfive UI.



## Config
The config.php file for the module controls what objects appear at the root of the filesystem.

`Config::set('webdav', array(
	......
	'availableObjects' => ['Wiki'=>[],'TaskGroup'=>[],'Task'=>[],'User'=>[] ],
));`



## Technical
The sabre/dav library is used to implement the webdav protocol.

### Single action
A single cmfive action is available the /webdav/webdav.actions.php which includes the function default_ALL().
[A patch to core is required to support default/fallback action for a module]


### Classes

DBRootINode - root container with configured list of available objects as children
ClassInode - container for an Object which lists all records inside.
DBObjectINode - container for a record which lists all attachments inside and potentially other related records.
AttachmentInode - file

WebdavAuthentication - cmfive integration plugin

WikiINode - DBObjectINode extension adds wiki pages as children
WikiPageINode - plain DBObjectINode extension
TaskGroupINode - DBObjectINode extension adds tasks as children
TaskINode - plain DBObjectINode extension
UserINode - plain DBObjectINode extension

INodeService - shared service class


## Authentication
Cmfive based authentication is implemented by extending a cmfive user to include a password_digest field.

The AuthUserPasswordDigest migration adds the password_digest field to the database.
[** TODO find a solution for adding the field to the user object or swapping out the user object. Currently hacked digest field into User.php]

webdav.hooks.php updates the digest field when a user password is saved.
[requiring an auth_setpassword hook to be added to User.php]

WebdavAuthentication.php implements the correct functions to be provided to the sabre webdav server as an authentication plugin.


