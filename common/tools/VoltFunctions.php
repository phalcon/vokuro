<?php
/**
 * Phanbook : Delightfully simple forum software
 *
 * Licensed under The GNU License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link    http://phanbook.com Phanbook Project
 * @since   1.0.0
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */
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
                return '\Phanbook\Tools\ZFunction::getUrlAvatar('. $arguments .')';
                break;
            case 'getHumanDate':
                return '\Phanbook\Tools\ZFunction::getHumanDate('. $arguments .')';
                break;
            case 'getImageSrc':
                return '\Phanbook\Tools\ZFunction::getImageSrc('. $arguments .')';
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
            return '\Phanbook\Tools\ZFunction::truncate(' . $arguments . ')';
        }
        if ($name == 'strlen') {
            return '\Phanbook\Tools\ZFunction::strlen(' . $arguments . ')';
        }
    }
}
