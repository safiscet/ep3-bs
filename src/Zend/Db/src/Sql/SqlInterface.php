<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Db\Sql;

use Zend\Db\Adapter\Platform\PlatformInterface;

interface SqlInterface
{
    /**
     * Get SQL string for statement
     *
     * @param PlatformInterface|null $adapterPlatform
     *
     * @return string
     */
    public function getSqlString(?PlatformInterface $adapterPlatform = null);
}
