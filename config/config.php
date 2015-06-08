<?php

/**
 * Back end modules
 */
$GLOBALS['BE_MOD']['devtools']['scriptrunner'] = array(
    'icon' => 'system/modules/scriptrunner/assets/icons/scriptrunner.png',
    'stylesheet' => array(
        'system/modules/scriptrunner/assets/css/be_scriptrunner.css',
    ),
    'callback' => '\Scriptrunner\BackendModuleScriptrunner',
);
