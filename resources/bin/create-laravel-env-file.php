#!/usr/bin/env php
<?php
$Outputs = require('configure-instance-resources.php');
$RDS_USERNAME = getenv('RDS_USERNAME');
$RDS_PASSWORD = getenv('RDS_PASSWORD');
$RDS_HOSTNAME = getenv('RDS_HOSTNAME');
$RDS_PORT = getenv('RDS_PORT');
$RDS_DB_NAME = getenv('RDS_DB_NAME');


if ($Outputs['SiteCDNDomainName']) {
    $envMap['CDN'] = $Outputs['SiteCDNDomainName'];
}


if ($Outputs['ElastiCacheAddress'] && $Outputs['ElastiCachePort']) {
    $envMap['CACHE_DRIVER'] = 'memcached';
    $envMap['MEMCACHED_PERSISTENT_ID'] = getenv('MEMCACHED_PERSISTENT_ID');
    $envMap['MEMCACHED_USERNAME'] = '';
    $envMap['MEMCACHED_PASSWORD'] = '';
    $envMap['MEMCACHED_HOST'] = $Outputs['ElastiCacheAddress'];
    $envMap['MEMCACHED_PORT'] = $Outputs['ElastiCachePort'];

}


if ($RDS_USERNAME) {
    $envMap['DB_CONNECTION'] = getenv('DB_CONNECTION');
    $envMap['DB_HOST'] = $RDS_HOSTNAME;
    $envMap['DB_PORT'] = $RDS_PORT;
    $envMap['DB_DATABASE'] = $RDS_DB_NAME;
    $envMap['DB_USERNAME'] = $RDS_USERNAME;
    $envMap['DB_PASSWORD'] = $RDS_PASSWORD;

}




$envFile = "";
foreach ($envMap as $key => $value) {
    $envFile .= "$key=$value\n";
}


file_put_contents($envFile, getenv('APP_DIR') . '/.env');