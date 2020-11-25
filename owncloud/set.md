```nginx
apt install php-apcu redis php-redis
systemctl enable redis-server
systemctl restart apache2
```
> Docroot/config/config.php
```php
<?php
$CONFIG = array (
  'updatechecker' => false,
  'instanceid' => 'fdsfdsfsfsfs',
  'passwordsalt' => 'sfsdffsfsgdfgdgfgdgf',
  'secret' => 'dssfgfsdgggsgfdsgfgfsdgds',
  'trusted_domains' => 
  array (
    0 => 'example.com',
  ),
  'datadirectory' => '/var/www/owncloud/data',
  'overwrite.cli.url' => 'http://example.com',
  'dbtype' => 'mysql',
  'version' => '10.5.0.10',
  'dbname' => 'owncloud',
  'dbhost' => 'localhost',
  'dbtableprefix' => 'oc_',
  'mysql.utf8mb4' => true,
  'dbuser' => 'owncloud',
  'dbpassword' => '123456',
  'logtimezone' => 'UTC',
  'installed' => true,
  'mail_domain' => 'sergeyem.ru',
  'mail_from_address' => 'admin',
  'mail_smtpmode' => 'smtp',
  'mail_smtpsecure' => 'ssl',
  'mail_smtpauth' => 1,
  'mail_smtphost' => 'smtp.gmail.com',
  'mail_smtpport' => '465',
  'mail_smtpname' => 'admin@user.ru',
  'mail_smtppassword' => '123456',
  'mail_smtpauthtype' => 'PLAIN',
  'theme' => '',
  'loglevel' => 2,
  'maintenance' => false,
  'memcache.local' => '\OC\Memcache\APCu',
  'filelocking.enabled' => true,
  'memcache.locking' => '\OC\Memcache\Redis',
  'redis' => array(
	'host' => 'localhost',
	'port' => 6379,
	'timeout' => 0.0,
	'password' => '', // Optional, if not defined no password will be used.
  ),
  'onlyoffice' => array ( 'verify_peer_off' => true )
);
```
