<?php

namespace Vicens\Alidayu;

use GuzzleHttp\Client as GuzzleHttp;
use function GuzzleHttp\Psr7\build_query;
use Vicens\Alidayu\Request\AbstractRequest;
use Vicens\Alidayu\Request\DoubleCall;
use Vicens\Alidayu\Request\FlowCharge;
use Vicens\Alidayu\Request\FlowChargeProvince;
use Vicens\Alidayu\Request\FlowGrade;
use Vicens\Alidayu\Request\FlowQuery;
use Vicens\Alidayu\Request\SingleCall;
use Vicens\Alidayu\Request\Sms;
use Vicens\Alidayu\Request\SmsQuery;
use Vicens\Alidayu\Request\TtsSingleCall;

class Client
{

    /**
     * 正式环境http请求地址
     */
    const HTTP_URL = 'http://gw.api.taobao.com/router/rest';

    /**
     * 正式环境的https请求地址
     */
    const HTTPS_URL = 'https://eco.taobao.com/router/rest';

    /**
     * 沙箱环境的http请求地址
     */
    const SANDBOX_HTTP_URL = 'http://gw.api.tbsandbox.com/router/rest';

    /**
     * 沙箱环境的https请求地址
     */
    const SANDBOX_HTTPS_URL = 'https://gw.api.tbsandbox.com/router/rest';

    /**
     * 是否是沙箱环境
     * @var bool
     */
    protected $sandbox = false;

    /**
     * 是否使用https接口
     * @var bool
     */
    protected $secure = false;

    /**
     * 阿里大于App Key
     * @var string
     */
    protected $appKey = null;

    /**
     * 阿里大于App Secret
     * @var string
     */
    protected $appSecret = null;

    /**
     * Alidayu constructor.
     * @param array $config 阿里大于配置
     */
    public function __construct(array $config = [])
    {
        if (!empty($config)) {
            $this->setConfig($config);
        }

    }

    /**
     * 设置配置
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config = [])
    {
        // 设置App Key
        $this->appKey = isset($config['appKey']) ? $config['appKey'] : '';

        // 设置App Secret
        $this->appSecret = isset($config['appSecret']) ? $config['appSecret'] : '';

        // 沙箱环境
        $this->sandbox = isset($config['sandbox']) ? (bool)$config['sandbox'] : false;

        return $this;
    }

    /**
     * 发送请求
     * @param AbstractRequest $request
     * @return Response
     */
    public function send(AbstractRequest $request)
    {
        $params = array_merge($request->getParams(), [
            'app_key' => $this->appKey,
            'sign_method' => 'md5',
            'timestamp' => date('Y-m-d H:i:s'),
            'format' => 'json',
            'v' => '2.0',
            'method' => $request->getMethod()
        ]);

        // 生成签名
        $params['sign'] = $this->buildSignature($params, $this->appSecret);

        $client = new GuzzleHttp();

        // 发起请求
        $response = $client->get($this->getUrl() . '?' . build_query($params));

        return new Response($response);
    }

    /**
     * 返回发送短信通知
     * @param string $recNum 短信接收号码
     * @param string $smsTemplateCode 模板ID
     * @param string $smsFreeSignName 短信签名
     * @param array $smsParam 短信模板变量参数
     * @param string $extend 回传参数
     * @return Sms
     */
    public function sms($recNum, $smsTemplateCode, $smsFreeSignName, array $smsParam = [], $extend = '')
    {
        return new Sms($recNum, $smsTemplateCode, $smsFreeSignName, $smsParam, $extend);
    }

    /**
     * 查询短信发送记录
     * @param string $recNum 短信接收号码
     * @param int $currentPage 当前页码
     * @param int $pageSize 每页多少条数据
     * @param string $queryDate 查询时间
     * @param string $bizId 短信发送流水
     * @return SmsQuery
     */
    public function smsQuery($recNum, $currentPage = 1, $pageSize = 10, $queryDate = null, $bizId = '')
    {
        return new SmsQuery($recNum, $currentPage, $pageSize, $queryDate, $bizId);
    }

    /**
     * 语音通知
     * @param string $calledNum 被叫号码
     * @param string $calledShowNum 被叫号码侧的号码显示
     * @param string $voiceCode 语音文件ID
     * @param string $extend 回传参数
     * @return SingleCall
     */
    public function singleCall($calledNum, $calledShowNum, $voiceCode, $extend = '')
    {
        return new SingleCall($calledNum, $calledShowNum, $voiceCode, $extend);
    }

    /**
     * 多方通话
     * @param string $callerNum 主叫号码
     * @param string $callerShowNum 主叫号码侧的号码显示
     * @param string $calledNum 被叫号码
     * @param string $calledShowNum 被叫号码侧的号码显示
     * @param string $extend 回传参数
     * @return DoubleCall
     */
    public function doubleCall($callerNum, $callerShowNum, $calledNum, $calledShowNum, $extend = '')
    {
        return new DoubleCall($callerNum, $callerShowNum, $calledNum, $calledShowNum, $extend);
    }

    /**
     * 文本转语音通知
     * @param string $calledNum 被叫号码
     * @param string $calledShowNum 被叫号码侧的号码显示
     * @param string $ttsCode 模板ID
     * @param array $ttsParams 模板变量
     * @param string $extend 回传参数
     * @return  TtsSingleCall
     */
    public function ttsSingleCall($calledNum, $calledShowNum, $ttsCode, array $ttsParams = [], $extend = '')
    {
        return new TtsSingleCall($calledNum, $calledShowNum, $ttsCode, $ttsParams, $extend);
    }

    /**
     * 流量直充查询
     * @param string|null $outId 唯一流水号
     * @return FlowQuery
     */
    public function flowQuery($outId = null)
    {
        return new FlowQuery($outId);
    }

    /**
     * 流量直充档位表
     * @param string|null $phoneNum 手机号
     * @return FlowGrade
     */
    public function flowGrade($phoneNum = null)
    {
        return new FlowGrade($phoneNum);
    }

    /**
     * 流量直充
     * @param string $phoneNum 手机号
     * @param int $grade 充值数量
     * @param string $outRechargeId 唯一流水号
     * @param int $scope 0:全国漫游流量 1:省内流量
     * @param bool $isProvince 是否分省通道(scope为0时生效)
     * @param string $reason 充值原因
     * @return FlowCharge
     */
    public function flowCharge($phoneNum, $grade, $outRechargeId, $scope = 0, $isProvince = false, $reason = '')
    {
        return new FlowCharge($phoneNum, $grade, $outRechargeId, $scope, $isProvince, $reason);
    }

    /**
     * 流量直充分省
     * @param string $phoneNum 手机号
     * @param int $grade 充值数量
     * @param string $outRechargeId 唯一流水号
     * @param string $reason 充值原因
     * @return FlowChargeProvince
     */
    public function flowChargeProvince($phoneNum, $grade, $outRechargeId, $reason = '')
    {
        return new FlowChargeProvince($phoneNum, $grade, $outRechargeId, $reason);
    }

    /**
     * 返回接口请求地址
     * @return string
     */
    protected function getUrl()
    {

        if (!($this->secure && $this->sandbox)) {
            return static::HTTP_URL;
        } else if (!$this->secure && $this->sandbox) {
            return static::SANDBOX_HTTP_URL;
        } else if ($this->secure && $this->sandbox) {
            return static::SANDBOX_HTTPS_URL;
        } else {
            return static::HTTPS_URL;
        }
    }

    /**
     * 生成签名
     * @param array $parameters
     * @param $appSecret
     * @return string
     */
    static private function buildSignature(array $parameters, $appSecret)
    {
        // 将参数Key按字典顺序排序
        ksort($parameters);

        $paramArray = [];
        foreach ($parameters as $key => $value) {
            $paramArray[] = $key . $value;
        }

        $string = $appSecret . implode('', $paramArray) . $appSecret;

        return strtoupper(md5($string));
    }
}
