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

    public $fixtures       = ['plugin.config.configs'];
    protected $_corePlugin = 'Config';
    protected $_plugin     = 'Core';

    public function testClassName()
    {
        $table = TableRegistry::get('Config.Configs');
        self::assertInstanceOf('Config\Model\Table\ConfigsTable', $table);
        self::assertSame(CMS_TABLE_CONFIGS, $table->getTable());
    }
    
    public function testSave()
    {
        $entity = new Config([
            'name'   => 'from.test',
            'params' => [
                'name'  => 'Simple entity',
                'order' => 'DESC'
            ]
        ]);

        /** @var ConfigsTable $table */
        $table = TableRegistry::get('Config.Configs');
        $table->save($entity);

        /** @var \Config\Model\Entity\Config $result */
        $result = $table->findByName('from.test')->first();
        self::assertInstanceOf('Config\Model\Entity\Config', $result);
        self::assertSame('from.test', $result->name);

        self::assertInstanceOf('JBZoo\Data\JSON', $result->params);
        self::assertSame('Simple entity', $result->params->get('name'));

        $entity = new Config([
            'name'   => 'array.value',
            'params' => [
                'array-1' => [
                    'name' => 'Array 1'
                ],
                'array-2' => [
                    'name' => 'Array 2'
                ],
                'array-3' => [
                    'name' => 'Array 3'
                ]
            ]
        ]);

        $table->save($entity);
        /** @var \Config\Model\Entity\Config $result */
        $result = $table->findByName('array.value')->first();
        self::assertInstanceOf('Config\Model\Entity\Config', $result);
        self::assertSame('array.value', $result->name);
        self::assertInstanceOf('JBZoo\Data\JSON', $result->params);
        self::assertTrue(is_array($result->params->get('array-1')));
        self::assertTrue(is_array($result->params->get('array-2')));
        self::assertTrue(is_array($result->params->get('array-3')));
        self::assertSame('Array 1', $result->params->find('array-1.name'));
    }

    public function testSaveDuplicate()
    {
        /** @var ConfigsTable $table */
        $table  = TableRegistry::get('Config.Configs');
        $entity = $table->newEntity([
            'name'   => 'test.custom',
            'params' => [
                'name' => 'Simple entity',
                'order' => 'DESC'
            ]
        ]);
        /** @var \Config\Model\Entity\Config $result */
        $result = $table->save($entity);
        self::assertFalse((bool) $result);
        self::assertSame([
            'unique' => __d('config', 'The parameter with this key already exists')
        ], $entity->errors('name'));

        $entity = $table->newEntity([
            'params' => [
                'name'  => 'Simple entity',
                'order' => 'DESC'
            ]
        ]);

        self::assertSame([
            '_required' => __d('config', 'The key field id required')
        ], $entity->errors('name'));

        $entity = $table->newEntity([
            'name'   => '',
            'params' => [
                'name'  => 'Simple entity',
                'order' => 'DESC'
            ]
        ]);

        self::assertSame([
            '_empty' => __d('config', 'Please, enter you config key')
        ], $entity->errors('name'));
    }
}
