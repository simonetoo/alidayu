<?php

namespace Vicens\Alidayu;

/**
 * 阿里大于外观
 * @method static Request\Sms sms(string $phone, string $templateId, string $signName, array $smsParam = [], string $extend = '')
 * @method static Request\SmsQuery smsQuery(string $phone, int $page = 1, int $pageSize = 10, string $queryDate = null)
 * @method static Request\DoubleCall doubleCall(string $callerNum, string $callerShowNum, string $calledNum, string $calledShowNum, string $extend = '')
 * @method static Request\SingleCall singleCall(string $calledNum, string $calledShowNum, string $voiceCode, string $extend = '')
 * @method static Request\TtsSingleCall ttsSingleCall(string $calledNum, string $calledShowNum, string $ttsCode, array $ttsParams = [], string $extend = '')
 * @method static Request\FlowQuery flowQuery(string | null $outId)
 * @method static Request\FlowGrade flowGrade(string | null $phoneNum)
 * @method static Request\FlowCharge flowCharge(string $phoneNum, string $grade, string $outRechargeId, int $scope = 0, boolean $isProvince = false, string $reason = '')
 * @method static Request\FlowChargeProvince flowChargeProvince(string $phoneNum, string $grade, string $outRechargeId, string $reason = '')
 * @method static Response send(Request\AbstractRequest $request)
 */
class Alidayu
{

    /**
     * Client实例
     * @var Client|null
     */
    protected static $client = null;

    /**
     * 阿里大于配置
     * @var array
     */
    protected static $config = [];


    /**
     * 设置配置
     * @param array $config
     * @return string
     */
    public static function setConfig(array $config = [])
    {
        static::$config = $config;

        if (!is_null(static::$client)) {
            static::$client->setConfig($config);
        }

        return static::class;
    }


    /**
     * 自动调用Client方法
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {

        if (is_null(static::$client)) {
            static::$client = new Client(static::$config);
        }

        return call_user_func_array([static::$client, $name], $arguments);
    }
}