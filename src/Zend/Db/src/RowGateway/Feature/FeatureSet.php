<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Db\RowGateway\Feature;

use Zend\Db\RowGateway\AbstractRowGateway;

class FeatureSet
{
    const APPLY_HALT = 'halt';

    /**
     * @var AbstractRowGateway
     */
    protected $rowGateway = null;

    /**
     * @var AbstractFeature[]
     */
    protected $features = [];

    /**
     * @var array
     */
    protected $magicSpecifications = [];

    /**
     * @param array $features
     */
    public function __construct(array $features = [])
    {
        if ($features) {
            $this->addFeatures($features);
        }
    }

    /**
     * @param AbstractRowGateway $rowGateway
     * @return self Provides a fluent interface
     */
    public function setRowGateway(AbstractRowGateway $rowGateway)
    {
        $this->rowGateway = $rowGateway;
        foreach ($this->features as $feature) {
            $feature->setRowGateway($this->rowGateway);
        }
        return $this;
    }

    public function getFeatureByClassName($featureClassName)
    {
        $feature = false;
        foreach ($this->features as $potentialFeature) {
            if ($potentialFeature instanceof $featureClassName) {
                $feature = $potentialFeature;
                break;
            }
        }
        return $feature;
    }

    /**
     * @param array $features
     * @return self Provides a fluent interface
     */
    public function addFeatures(array $features)
    {
        foreach ($features as $feature) {
            $this->addFeature($feature);
        }
        return $this;
    }

    /**
     * @param AbstractFeature $feature
     * @return self Provides a fluent interface
     */
    public function addFeature(AbstractFeature $feature)
    {
        $this->features[] = $feature;
        $feature->setRowGateway($feature);
        return $this;
    }

    public function apply($method, $args)
    {
        foreach ($this->features as $feature) {
            if (method_exists($feature, $method)) {
                $return = call_user_func_array([$feature, $method], $args);
                if ($return === self::APPLY_HALT) {
                    break;
                }
            }
        }
    }

    /**
     * @return bool
     */
    public function canCallMagicGet()
    {
        return false;
    }

    /**
     * @return mixed
     */
    public function callMagicGet()
    {
        $return = null;
        return $return;
    }

    /**
     * @return bool
     */
    public function canCallMagicSet()
    {
        return false;
    }

    /**
     * @return mixed
     */
    public function callMagicSet()
    {
        $return = null;
        return $return;
    }

    /**
     * @return bool
     */
    public function canCallMagicCall()
    {
        return false;
    }

    /**
     * @return mixed
     */
    public function callMagicCall()
    {
        $return = null;
        return $return;
    }
}
