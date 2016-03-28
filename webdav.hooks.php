/**
 * Save a digest suitable for webdav digest authentication (htdigest style)
 */
function auth_setpassword($w,$data) {
	$realm=Config::get('webdav.authenticationrealm');
	if (empty($realm)) {
			$realm='CmFive';
	}
	$key=$data[1]->login.":".$realm.":".$data[0];
	$data->password_digest=md5($key);
}
