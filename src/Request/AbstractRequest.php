<?php

namespace Vicens\Alidayu\Request;

use Vicens\Alidayu\Alidayu;
use Vicens\Alidayu\Response;

abstract class AbstractRequest
{

    /**
     * 接口所需的请求参数
     * @var array
     */
    protected $params = [];

    /**
     * 返回Api名
     * @return mixed
     */
    abstract public function getMethod();

    /**
     * 返回请求参数
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * 设置请求参数
     * @param array $params
     * @return $this
     */
    public function setParams(array $params = [])
    {
        $this->params = array_merge($this->params, $params);

        return $this;
    }

    /**
     * 发送请求
     * @return Response
     */
    public function send()
    {
        return Alidayu::send($this);
    }

    /**
     * 辅助函数: 获取或设置参数
     * @param $key
     * @param mixed|null $value
     * @return $this|mixed
     */
    protected function getOrSetParam($key, $value = null)
    {
        if (is_null($value)) {
            return $this->params[$key];
        }

        $this->params[$key] = $value;

        return $this;
    }

    /**
     * 解析数据
     * @param array $response
     * @return mixed
     */
    public function parseData(array $response)
    {
        $key = str_replace('.', '_', $this->getMethod()) . '_response';
        return array_key_exists($key, $response) ? $response[$key] : null;
    }

    /**
     * 自动设置参数
     * @param $name
     * @param $arguments
     * @return $this|string|mixed|null
     */
    public function __call($name, $arguments)
    {

        // 将驼峰字符串转换成下划线
        $key = preg_replace('/\s+/u', '', ucwords($name));
        $key = preg_replace('/(.)(?=[A-Z])/u', '$1' . '_', $key);
        $key = mb_strtolower($key, 'UTF-8');

        if (count($arguments) === 0) {
            return isset($this->params[$key]) ? $this->params[$key] : null;
        }

        $this->params[$key] = $arguments[0];

        return $this;
    }
}
