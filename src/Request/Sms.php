<?php

namespace Vicens\Alidayu\Request;

/**
 * 发送短信通知类
 * @link https://api.alidayu.com/docs/api.htm?apiId=25450
 * @method $this|string recNum(string | null $recNum = null)
 * @method $this|string smsTemplateCode(string | null $smsTemplateCode = null)
 * @method $this|string smsFreeSignName(string | null $smsFreeSignName = null)
 * @method $this|array smsParam(array | null $smsParam = null)
 * @method $this|string extend(string | null $extend = null)
 */
class Sms extends AbstractRequest
{

    /**
     * Sms constructor.
     * @param string $recNum 接收方手机号
     * @param string $smsTemplateCode 模板ID
     * @param string $smsFreeSignName 签名
     * @param array $smsParam 模板变量
     * @param string $extend 回传参数
     */
    public function __construct($recNum, $smsTemplateCode, $smsFreeSignName, array $smsParam = [], $extend = '')
    {
        $this->setParams([
            'sms_type' => 'normal',
            'rec_num' => $recNum,
            'sms_template_code' => $smsTemplateCode,
            'sms_free_sign_name' => $smsFreeSignName,
            'sms_param' => $smsParam,
            'extend' => $extend
        ]);
    }

    /**
     * 返回接口参数
     * @return array
     */
    public function getParams()
    {
        $params = parent::getParams();

        if (is_array($params['sms_param'])) {
            $params['sms_param'] = json_encode($params['sms_param']);
        }

        return $params;
    }

    /**
     * 返回接口名
     * @return string
     */
    public function getMethod()
    {
        return 'alibaba.aliqin.fc.sms.num.send';
    }
}

