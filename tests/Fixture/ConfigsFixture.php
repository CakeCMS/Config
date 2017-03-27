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

namespace Config\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * Class ConfigsFixture
 *
 * @package Config\Test\Fixture
 */
class ConfigsFixture extends TestFixture
{

    /**
     * Table fields.
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 12, 'null' => false],
        'key' => ['type' => 'string', 'length' => 255, 'null' => false],
        'value' => 'text',
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']]
        ]
    ];

    /**
     * ConfigsFixture constructor.
     */
    public function __construct()
    {
        $this->records = [
            [
                'id'    => 1,
                'key'   => 'test.custom',
                'value' => json_encode([
                    'test'   => [
                        'id'      => '_test',
                        'name'    => 'Test',
                        'options' => true,
                    ],
                    'custom' => [
                        'id'      => '_custom',
                        'name'    => 'Custom',
                        'options' => false,
                    ]
                ], JSON_PRETTY_PRINT)
            ]
        ];

        parent::__construct();
    }
}
