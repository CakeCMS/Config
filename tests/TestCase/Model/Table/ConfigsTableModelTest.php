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

use Core\Plugin;
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

    /**
     * Test fixtures.
     *
     * @var array
     */
    public $fixtures = ['plugin.config.configs'];

    /**
     * Setup the test case, backup the static object values so they can be restored.
     * Specifically backs up the contents of Configure and paths in App if they have
     * not already been backed up.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        Plugin::load('Config', [
            'path'      => ROOT . DS,
            'bootstrap' => true,
            'routes'    => true,
        ]);

        Plugin::routes('Config');
    }

    /**
     * Clears the state used for requests.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        Plugin::unload('Config');
    }

    public function testClassName()
    {
        $table = TableRegistry::get('Config.Configs');
        $this->assertInstanceOf('Config\Model\Table\ConfigsTable', $table);
        $this->assertSame(CMS_TABLE_CONFIGS, $table->table());
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
        $this->assertInstanceOf('Config\Model\Entity\Config', $result);
        $this->assertSame('from.test', $result->key);

        $this->assertInstanceOf('JBZoo\Data\JSON', $result->value);
        $this->assertSame('Simple entity', $result->value->get('name'));

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
        $this->assertInstanceOf('Config\Model\Entity\Config', $result);
        $this->assertSame('array.value', $result->key);
        $this->assertInstanceOf('JBZoo\Data\JSON', $result->value);
        $this->assertTrue(is_array($result->value->get('array-1')));
        $this->assertTrue(is_array($result->value->get('array-2')));
        $this->assertTrue(is_array($result->value->get('array-3')));
        $this->assertSame('Array 1', $result->value->find('array-1.name'));
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
        $this->assertFalse((bool) $result);
        $this->assertSame([
            'unique' => __d('config', 'The parameter with this key already exists')
        ], $entity->errors('key'));

        $entity = $table->newEntity([
            'value' => [
                'name' => 'Simple entity',
                'order' => 'DESC',
            ]
        ]);

        $this->assertSame([
            '_required' => __d('config', 'The key field id required')
        ], $entity->errors('key'));

        $entity = $table->newEntity([
            'key' => '',
            'value' => [
                'name' => 'Simple entity',
                'order' => 'DESC',
            ]
        ]);

        $this->assertSame([
            '_empty' => __d('config', 'Please, enter you config key')
        ], $entity->errors('key'));
    }
}
