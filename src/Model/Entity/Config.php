<?php
/**
 * CakeCMS Config
 *
 * This file is part of the of the simple cms based on CakePHP 3.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package   Config
 * @license   MIT
 * @copyright MIT License http://www.opensource.org/licenses/mit-license.php
 * @link      https://github.com/CakeCMS/Config".
 * @author    Sergey Kalistratov <kalistratov.s.m@gmail.com>
 */

namespace Config\Model\Entity;

use JBZoo\Data\Data;
use JBZoo\Data\JSON;
use Core\ORM\Entity\Entity;

/**
 * Class Config
 *
 * @package Config\Model\Entity
 * @property Data $value
 * @property string $key
 */
class Config extends Entity
{

    /**
     * Get current value.
     *
     * @param string $value
     * @return JSON
     */
    protected function _getValue($value)
    {
        return new JSON($value);
    }
}
