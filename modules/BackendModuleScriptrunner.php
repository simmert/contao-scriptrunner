<?php

namespace Scriptrunner;


class BackendModuleScriptrunner extends \Contao\BackendModule
{
    protected $strTemplate = 'be_mod_scriptrunner';

    protected function compile()
    {
        if (\Contao\Input::get('run') !== null && ($script = self::getScriptByHash(\Contao\Input::get('run')))) {
            $this->Template->result = self::run($script);
        }

        $this->Template->scripts = self::getScripts();
    }


    public static function run(array $script)
    {
        include_once($script['rel_path']);

        $scriptObject = new $script['name'];

        if (!is_a($scriptObject, '\Contao\Backend')) {
            \Contao\Message::addError(sprintf('Script %s must be of type \Contao\Backend.', $script['name']));
            return false;
        }

        $result = $scriptObject->run();

        if ($result !== false) {
            \Contao\Message::addConfirmation(sprintf($GLOBALS['TL_LANG']['scriptrunner']['exec']['success'], $script['name']));
        }

        return $result;
    }


    public static function getScripts()
    {
        $files = glob($moduleDir   = TL_ROOT . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . '*' . DIRECTORY_SEPARATOR . 'scriptrunner' . DIRECTORY_SEPARATOR . '*.php');

        $scripts = array();
        foreach ($files as &$file) {
            $parts = explode(DIRECTORY_SEPARATOR, $file);
            $length = count($parts);
            $extension = $parts[$length-3];

            if (!isset($scripts[$extension])) {
                $scripts[$extension] = array();
            }

            $scripts[$extension][] = array(
                'name'      => basename($parts[$length-1], '.php'),
                'extension' => $parts[$length-3],
                'abs_path'  => $file,
                'rel_path'  => '..' . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $extension . DIRECTORY_SEPARATOR . 'scriptrunner' . DIRECTORY_SEPARATOR . basename($parts[$length-1]),
                'hash'      => md5($file),
            );
        }

        return $scripts;
    }


    public static function getScriptByHash($hash)
    {
        $scripts = self::getScripts();

        foreach ($scripts as &$extension) {
            foreach ($extension as &$script) {
                if ($script['hash'] == $hash) {
                    return $script;
                }
            }
        }

        return null;
    }
}
