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

    protected $_plugin = 'Core';
    protected $_corePlugin = 'Config';

    public function testGetInstance()
    {
        $config = Config::getInstance();
        self::assertInstanceOf('Config\Config', $config);
    }

    public function testGet()
    {
        $config = Config::getInstance();
        $result = $config->find('test.custom');

        self::assertInstanceOf('JBZoo\Data\JSON', $result);
        self::assertSame(['id' => '_test', 'name' => 'Test', 'options' => true], $result->get('test'));
        self::assertSame('_test', $result->find('test.id'));
    }
}
