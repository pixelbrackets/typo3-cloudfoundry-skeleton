<?php

// Get database credentials from CloudStack env
$cloudFoundryDatabase = [];
if (false === empty(getenv('VCAP_SERVICES'))) {
    // Pick very first service in this skeleton - if more services are used
    // then tag the services and pick the database service by the given tag
    $cloudFoundryServices = (array)json_decode(getenv('VCAP_SERVICES'), true);
    $cloudFoundryDatabase = current($cloudFoundryServices)[0]['credentials'];
}
if (false === empty($cloudFoundryDatabase)) {
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['user'] = $cloudFoundryDatabase['username'];
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['password'] = $cloudFoundryDatabase['password'];
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['dbname'] = $cloudFoundryDatabase['name'];
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['host'] = $cloudFoundryDatabase['host'];
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['port'] = $cloudFoundryDatabase['port'];
}

if (false === empty(getenv('TYPO3__DB__database'))) {
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['user'] = getenv('TYPO3__DB__username');
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['password'] = getenv('TYPO3__DB__password');
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['dbname'] = getenv('TYPO3__DB__database');
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['host'] = getenv('TYPO3__DB__host');
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['port'] = getenv('TYPO3__DB__port');
}

if (false === empty(getenv('TYPO3__SYS__encryptionKey'))) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey'] = getenv('TYPO3__SYS__encryptionKey');
}
if (false === empty(getenv('TYPO3__BE__installToolPassword'))) {
    $GLOBALS['TYPO3_CONF_VARS']['BE']['installToolPassword'] = getenv('TYPO3__BE__installToolPassword');
}
