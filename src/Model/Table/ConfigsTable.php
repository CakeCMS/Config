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

namespace Config\Model\Table;

use Core\ORM\Table;
use Cake\Validation\Validator;

/**
 * Class ConfigsTable
 *
 * @package Config\Model\Table
 * @method \Cake\ORM\Query findByKey($key)
 */
class ConfigsTable extends Table
{

    /**
     * Initialize a table instance. Called after the constructor.
     *
     * @param array $config
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->table(CMS_TABLE_CONFIGS);
        $this->primaryKey();
    }

    /**
     * Default validate rules.
     *
     * @param Validator $validator
     * @return Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('key', true, __d('config', 'The key field id required'))
            ->notEmpty('key', __d('config', 'Please, enter you config key'))
            ->add('key', 'unique', [
                    'provider' => 'table',
                    'rule'     => 'validateUnique',
                    'message'  => __d('config', 'The parameter with this key already exists'),
                ]
            );

        return $validator;
    }
}
