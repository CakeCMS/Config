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

namespace Config;

use JBZoo\Data\Data;
use JBZoo\Data\JSON;
use Cake\ORM\TableRegistry;
use Config\Model\Table\ConfigsTable;

/**
 * Class Config
 *
 * @package Config
 */
class Config
{

    /**
     * Config store.
     *
     * @var Data
     */
    protected $_store;

    /**
     * Hold config instance.
     *
     * @var Config
     */
    protected static $_instance;

    /**
     * Get config instance.
     *
     * @return Config
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new Config();
            if (self::$_instance->_store === null) {
                self::$_instance->_store = self::$_instance->_setStore();
            }
        }

        return self::$_instance;
    }

    /**
     * Find config param.
     *
     * @param string $key
     * @param null|string|array $default
     * @param mixed $filter
     * @return mixed|Data
     */
    public function find($key, $default = null, $filter = null)
    {
        return $this->_store->get($key, $default, $filter);
    }

    /**
     * Setup config store.
     *
     * @return JSON
     */
    protected function _setStore()
    {
        /** @var ConfigsTable $table */
        $table = TableRegistry::get('Config.Configs');
        $rows = $table->find();

        $tmp = [];
        /** @var \Config\Model\Entity\Config $row */
        foreach ($rows as $row) {
            $tmp[$row->key] = $row->get('value');
        }

        return new JSON($tmp);
    }
}
