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

use Core\Plugin;
use Config\Config;
use Core\TestSuite\IntegrationTestCase;

/**
 * Class ConfigTest
 *
 * @package Config\Test\TestCase
 */
class ConfigTest extends IntegrationTestCase
{

    /**
     * Test fixtures.
     *
     * @var array
     */
    public $fixtures = ['plugin.config.configs'];

    /**
     * Default plugin name.
     *
     * @var string
     */
    protected $_plugin = 'Config';

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
        $options = [
            'path'      => ROOT . DS,
            'bootstrap' => true,
            'routes'    => true,
        ];

        Plugin::load($this->_plugin, $options);
        Plugin::routes($this->_plugin);
    }

    public function tearDown()
    {
        parent::tearDown();
        Plugin::unload($this->_plugin);
    }

    public function testGetInstance()
    {
        $config = Config::getInstance();
        $this->assertInstanceOf('Config\Config', $config);
    }

    public function testGet()
    {
        $config = Config::getInstance();
        $result = $config->find('test.custom');

        $this->assertInstanceOf('JBZoo\Data\JSON', $result);
        $this->assertSame(['id' => '_test', 'name' => 'Test', 'options' => true], $result->get('test'));
        $this->assertSame('_test', $result->find('test.id'));
    }
}
