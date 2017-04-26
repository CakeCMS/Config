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

namespace Config\Test\TestCase;

use Config\Config;
use Core\TestSuite\IntegrationTestCase;

/**
 * Class ConfigTest
 *
 * @package Config\Test\TestCase
 */
class ConfigTest extends IntegrationTestCase
{

    public $fixtures = ['plugin.config.configs'];

    protected $_corePlugin = 'Config';
    protected $_plugin = 'Core';

    public function testGet()
    {
        $config = Config::getInstance();
        $result = $config->find('test.custom');

        self::assertInstanceOf('JBZoo\Data\JSON', $result);
        self::assertSame(['id' => '_test', 'name' => 'Test', 'options' => true], $result->get('test'));
        self::assertSame('_test', $result->find('test.id'));
    }

    public function testGetInstance()
    {
        $config = Config::getInstance();
        self::assertInstanceOf('Config\Config', $config);
    }

    public function testSaveFail()
    {
        $config = Config::getInstance();
        $result = $config->save('', []);
        self::assertFalse($result);
    }

    public function testSaveSuccess()
    {
        $config = Config::getInstance();
        $result = $config->save('test.app', [
            'user'  => 'test',
            'color' => '#000'
        ]);

        self::assertInstanceOf('Config\Model\Entity\Config', $result);
        self::assertSame('test.app', $result->name);
        self::assertInstanceOf('JBZoo\Data\JSON', $result->params);
        self::assertSame('#000', $result->params->get('color'));
    }

    public function testUpDate()
    {
        $config = Config::getInstance();
        $key = 'test.custom';
        $configs = $config->find($key);

        self::assertInstanceOf('JBZoo\Data\JSON', $configs);
        self::assertSame('Test', $configs->find('test.name'));

        $result = $config->save($key, []);
        self::assertNull($result->params->find('test.name'));
    }
}
