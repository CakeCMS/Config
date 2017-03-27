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

namespace Config\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Config\Model\Entity\Config;
use Config\Model\Table\ConfigsTable;
use Core\TestSuite\IntegrationTestCase;

/**
 * Class ConfigsTableModelTest
 *
 * @package Config\Test\TestCase\Model\Table
 */
class ConfigsTableModelTest extends IntegrationTestCase
{

    public $fixtures = ['plugin.config.configs'];

    protected $_plugin = 'Core';
    protected $_corePlugin = 'Config';

    public function testClassName()
    {
        $table = TableRegistry::get('Config.Configs');
        self::assertInstanceOf('Config\Model\Table\ConfigsTable', $table);
        self::assertSame(CMS_TABLE_CONFIGS, $table->table());
    }
    
    public function testSave()
    {
        $entity = new Config([
            'key'   => 'from.test',
            'value' => [
                'name' => 'Simple entity',
                'order' => 'DESC',
            ]
        ]);

        /** @var ConfigsTable $table */
        $table = TableRegistry::get('Config.Configs');
        $table->save($entity);

        /** @var \Config\Model\Entity\Config $result */
        $result = $table->findByKey('from.test')->first();
        self::assertInstanceOf('Config\Model\Entity\Config', $result);
        self::assertSame('from.test', $result->key);

        self::assertInstanceOf('JBZoo\Data\JSON', $result->value);
        self::assertSame('Simple entity', $result->value->get('name'));

        $entity = new Config([
            'key'   => 'array.value',
            'value' => [
                'array-1' => [
                    'name' => 'Array 1',
                ],
                'array-2' => [
                    'name' => 'Array 2',
                ],
                'array-3' => [
                    'name' => 'Array 3',
                ],
            ]
        ]);

        $table->save($entity);
        /** @var \Config\Model\Entity\Config $result */
        $result = $table->findByKey('array.value')->first();
        self::assertInstanceOf('Config\Model\Entity\Config', $result);
        self::assertSame('array.value', $result->key);
        self::assertInstanceOf('JBZoo\Data\JSON', $result->value);
        self::assertTrue(is_array($result->value->get('array-1')));
        self::assertTrue(is_array($result->value->get('array-2')));
        self::assertTrue(is_array($result->value->get('array-3')));
        self::assertSame('Array 1', $result->value->find('array-1.name'));
    }

    public function testSaveDuplicate()
    {
        /** @var ConfigsTable $table */
        $table  = TableRegistry::get('Config.Configs');
        $entity = $table->newEntity([
            'key'   => 'test.custom',
            'value' => [
                'name' => 'Simple entity',
                'order' => 'DESC',
            ]
        ]);
        /** @var \Config\Model\Entity\Config $result */
        $result = $table->save($entity);
        self::assertFalse((bool) $result);
        self::assertSame([
            'unique' => __d('config', 'The parameter with this key already exists')
        ], $entity->errors('key'));

        $entity = $table->newEntity([
            'value' => [
                'name' => 'Simple entity',
                'order' => 'DESC',
            ]
        ]);

        self::assertSame([
            '_required' => __d('config', 'The key field id required')
        ], $entity->errors('key'));

        $entity = $table->newEntity([
            'key' => '',
            'value' => [
                'name' => 'Simple entity',
                'order' => 'DESC',
            ]
        ]);

        self::assertSame([
            '_empty' => __d('config', 'Please, enter you config key')
        ], $entity->errors('key'));
    }
}
