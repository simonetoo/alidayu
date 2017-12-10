<?php

namespace Vicens\Alidayu;

use \Psr\Http\Message\ResponseInterface;

class Response
{

    /**
     * 原响应实例
     * @var ResponseInterface
     */
    protected $response = null;

    /**
     * 响应内容
     * @var string
     */
    protected $content = null;

    /**
     * 响应的数据
     * @var array
     */
    protected $data = [];

    /**
     * 是否成功
     * @var bool
     */
    protected $success = false;

    /**
     * 错误消息
     * @var string|null
     */
    protected $error = null;

    /**
     * 错误代码
     * @var string|null
     */
    protected $errorCode = null;

    /**
     * Response constructor.
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;

        $this->content = $response->getBody()->getContents();

        $this->data = json_decode($this->content, true);

        $this->success = isset($this->data['result']['success']) && $this->data['result']['success'] === true;

        if ($this->fail()) {
            if (isset($this->data['result'])) {
                $this->error = $this->data['result']['msg'];
                $this->errorCode = $this->data['result']['err_code'];
            } else if (isset($this->data['error_response']['sub_msg'])) {
                $this->error = $this->data['error_response']['sub_msg'];
                $this->errorCode = $this->data['error_response']['sub_code'];
            }
        }
    }

    /**
     * 返回原响应实例
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * 是否成功
     * @return bool
     */
    public function success()
    {
        return $this->success;
    }

    /**
     * 是否失败
     * @return bool
     */
    public function fail()
    {
        return !$this->success();
    }

    /**
     * 返回响应内容
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * 返回响应数据
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * 返回错误消息
     * @return null|string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * 返回错误代码
     * @return null|string
     */
    public function getErrorCode()
    {

        return $this->errorCode;
    }
}
