<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

/**
 * @namespace
 */
namespace Zend\Mvc\Router\Console;

use Traversable;
use Zend\Console\RouteMatcher\DefaultRouteMatcher;
use Zend\Console\Request as ConsoleRequest;
use Zend\Console\RouteMatcher\RouteMatcherInterface;
use Zend\Filter\FilterChain;
use Zend\Mvc\Router\Exception;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\RequestInterface as Request;
use Zend\Validator\ValidatorChain;

/**
 * Segment route.
 *
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @see        http://guides.rubyonrails.org/routing.html
 */
class Simple implements RouteInterface
{
    /**
     * List of assembled parameters.
     *
     * @var array
     */
    protected $assembledParams = [];

    /**
     * @var RouteMatcherInterface
     */
    protected $matcher;

    /**
     * Create a new simple console route.
     *
     * @param  string|RouteMatcherInterface             $routeOrRouteMatcher
     * @param  array                                    $constraints
     * @param  array                                    $defaults
     * @param  array                                    $aliases
     * @throws Exception\InvalidArgumentException
     */
    public function __construct(
        $routeOrRouteMatcher,
        array $constraints = [],
        array $defaults = [],
        array $aliases = []
    ) {
        if (is_string($routeOrRouteMatcher)) {
            $this->matcher = new DefaultRouteMatcher($routeOrRouteMatcher, $constraints, $defaults, $aliases);
        } elseif ($routeOrRouteMatcher instanceof RouteMatcherInterface) {
            $this->matcher = $routeOrRouteMatcher;
        } else {
            throw new Exception\InvalidArgumentException(
                "routeOrRouteMatcher should either be string, or class implementing RouteMatcherInterface. "
                . gettype($routeOrRouteMatcher) . " was given."
            );
        }
    }

    /**
     * factory(): defined by Route interface.
     *
     * @see    \Zend\Mvc\Router\RouteInterface::factory()
     * @param  array|Traversable $options
     * @throws Exception\InvalidArgumentException
     * @return self
     */
    public static function factory($options = [])
    {
        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        } elseif (!is_array($options)) {
            throw new Exception\InvalidArgumentException(__METHOD__ . ' expects an array or Traversable set of options');
        }

        if (!isset($options['route'])) {
            throw new Exception\InvalidArgumentException('Missing "route" in options array');
        }

        foreach ([
            'constraints',
            'defaults',
            'aliases',
        ] as $opt) {
            if (!isset($options[$opt])) {
                $options[$opt] = [];
            }
        }

        if (!isset($options['validators'])) {
            $options['validators'] = null;
        }

        if (!isset($options['filters'])) {
            $options['filters'] = null;
        }

        return new static(
            $options['route'],
            $options['constraints'],
            $options['defaults'],
            $options['aliases']
        );
    }

    /**
     * match(): defined by Route interface.
     *
     * @param   Request             $request
     * @param   null|int            $pathOffset
     *
     * @return  void
     *@see     Route::match()
     */
    public function match(Request $request, $pathOffset = null)
    {
        if (!$request instanceof ConsoleRequest) {
            return;
        }

        $params  = $request->getParams()->toArray();
        $matches = $this->matcher->match($params);

        if (null !== $matches) {
            return new RouteMatch($matches);
        }
        return;
    }

    /**
     * assemble(): Defined by Route interface.
     *
     * @see    \Zend\Mvc\Router\RouteInterface::assemble()
     * @param  array $params
     * @param  array $options
     * @return mixed
     */
    public function assemble(array $params = [], array $options = [])
    {
        $this->assembledParams = [];
    }

    /**
     * getAssembledParams(): defined by Route interface.
     *
     * @see    RouteInterface::getAssembledParams
     * @return array
     */
    public function getAssembledParams()
    {
        return $this->assembledParams;
    }
}
