<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Scriptrunner',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Modules
	'Scriptrunner\BackendModuleScriptrunner' => 'system/modules/scriptrunner/modules/BackendModuleScriptrunner.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'be_mod_scriptrunner' => 'system/modules/scriptrunner/templates/backend',
));
