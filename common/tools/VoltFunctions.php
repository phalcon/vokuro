<?php
namespace Vokuro\Tools;

/**
 * PHP Functions in Volt
 */
class VoltFunctions
{
    /**
     * Compile any function call in a template
     *
     * @param string $name      function name
     * @param mixed  $arguments function args
     *
     * @return string compiled function
     */
    public function compileFunction($name, $arguments)
    {
        if (function_exists($name)) {
            return $name . '(' . $arguments . ')';
        }

        switch ($name) {
            case 'getUrlAvatar':
                return '\Vokuro\Tools\ZFunction::getUrlAvatar('. $arguments .')';
                break;
            case 'getHumanDate':
                return '\Vokuro\Tools\ZFunction::getHumanDate('. $arguments .')';
                break;
            case 'getImageSrc':
                return '\Vokuro\Tools\ZFunction::getImageSrc('. $arguments .')';
                break;
            default:
                // code...
                break;
        }
    }

    /**
     * Compile some filters
     *
     * @package las
     * @version 1.0
     *
     * @param string $name      filter name
     * @param mixed  $arguments filter args
     *
     * @return string compiled filter
     */
    public function compileFilter($name, $arguments)
    {
        if ($name == 'isset') {
            return '(isset(' . $arguments . ') ? ' . $arguments . ' : null)';
        }
        if ($name == 'long2ip') {
            return 'long2ip(' . $arguments . ')';
        }
        if ($name == 'truncate') {
            return '\Vokuro\Tools\ZFunction::truncate(' . $arguments . ')';
        }
        if ($name == 'strlen') {
            return '\Vokuro\Tools\ZFunction::strlen(' . $arguments . ')';
        }
    }
}
