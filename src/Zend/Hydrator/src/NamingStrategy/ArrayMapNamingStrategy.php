<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Hydrator\NamingStrategy;

class ArrayMapNamingStrategy implements NamingStrategyInterface
{
    /**
     * @var string[]
     */
    private $extractionMap;

    /**
     * @var string[]
     */
    private $hydrationMap;

    /**
     * Constructor
     *
     * @param array $extractionMap A map of string keys and values for symmetric translation of hydrated
     *                             and extracted field names
     */
    public function __construct(array $extractionMap)
    {
        $this->extractionMap = $extractionMap;
        $this->hydrationMap  = array_flip($extractionMap);
    }

    /**
     * {@inheritDoc}
     */
    public function hydrate($name)
    {
        return $this->hydrationMap[$name] ?? $name;
    }

    /**
     * {@inheritDoc}
     */
    public function extract($name)
    {
        return $this->extractionMap[$name] ?? $name;
    }
}
