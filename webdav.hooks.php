<?php
/**
 * Save a digest suitable for webdav digest authentication (htdigest style)
 */
function webdav_auth_setpassword($w,$data) {
	$webdavConfig=Config::get('webdav');
	$realm=$webdavConfig['authenticationRealm'];
	if (empty($realm)) {
			$realm='CmFive';
	}
	$key=$data[1]->login.":".$realm.":".$data[0];
	$data[1]->password_digest=md5($key);
}
