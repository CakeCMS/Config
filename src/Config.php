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
     * Hold config instance.
     *
     * @var Config
     */
    protected static $_instance;

    /**
     * Config store.
     *
     * @var Data
     */
    protected $_store;

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
     * Update or save config data by config name.
     *
     * @param string $name
     * @param array $data
     * @return bool|\Cake\Datasource\EntityInterface|\Config\Model\Entity\Config
     */
    public function save($name, array $data = [])
    {
        $table  = $this->_getTable();
        $entity = $table->findByName($name)->first();

        $newData = [
            'name'   => $name,
            'params' => $data
        ];

        if ($entity !== null && $entity->get('name') === $name) {
            $entity = $table->patchEntity($entity, $newData);
        } else {
            $entity = $table->newEntity($newData);
        }

        return $table->save($entity);
    }

    /**
     * Get config table.
     *
     * @return ConfigsTable
     */
    protected function _getTable()
    {
        return TableRegistry::get('Config.Configs');
    }

    /**
     * Setup config store.
     *
     * @return JSON
     */
    protected function _setStore()
    {
        $tmp  = [];
        $rows = $this->_getTable()->find();
        /** @var \Config\Model\Entity\Config $row */
        foreach ($rows as $row) {
            $tmp[$row->name] = $row->get('params');
        }

        return new JSON($tmp);
    }
}
