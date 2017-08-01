<?php

namespace dosamigos\google\places;


use Da\Google\Places\Client\AbstractClient;
use Da\Google\Places\Client\PlaceClient;
use Da\Google\Places\Client\SearchClient;
use yii\base\Component;
use yii\base\InvalidConfigException;

abstract class AbstractComponent extends Component
{
    /**
     * @var string response format. Can be json or xml.
     */
    public $format = 'json';
    /**
     * @var string your API key
     */
    public $key;
    /**
     * @var AbstractClient|PlaceClient|SearchClient
     */
    protected $client;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (empty($key) || empty($format)) {
            throw new InvalidConfigException('"key" and/or "format" cannot be empty.');
        }

        parent::init();
    }

    /**
     * Wraps PlaceClient methods.
     *
     * @param string $name
     * @param array $params
     *
     * @return mixed
     */
    public function __call($name, $params)
    {
        if (method_exists($this->getClient(), $name)) {
            return call_user_func_array([$this->getClient(), $name], $params);
        }

        return parent::__call($name, $params);
    }

    /**
     * @return AbstractClient|PlaceClient|SearchClient
     */
    abstract public function getClient();
}
