<?php

namespace Vicens\Alidayu\Request;

/**
 * 文本转语音通知
 * @link https://api.alidayu.com/docs/api.htm?apiId=25444
 * @method $this|string calledNum(string | null $calledNum = null)
 * @method $this|string calledShowNum(string | null $calledShowNum = null)
 * @method $this|string ttsCode(string | null $ttsCode = null)
 * @method $this|array ttsParam(array | null $ttsParam = null)
 * @method $this|string extend(string | null $extend = null)
 */
class TtsSingleCall extends AbstractRequest
{

    /**
     * TtsSingleCall constructor.
     * @param string $calledNum 被叫号码
     * @param string $calledShowNum 被叫号码侧的号码显示
     * @param string $ttsCode 模板ID
     * @param array $ttsParam 模板变量
     * @param string $extend 回传参数
     */
    public function __construct($calledNum, $calledShowNum, $ttsCode, array $ttsParam = [], $extend = '')
    {
        $this->setParams([
            'called_num' => $calledNum,
            'called_show_num' => $calledShowNum,
            'tts_code' => $ttsCode,
            'tts_param' => $ttsParam,
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

        if (is_array($params['tts_param'])) {
            $params['tts_param'] = json_encode($params['tts_param']);
        }

        return $params;
    }

    /**
     * 返回接口名
     * @return string
     */
    public function getMethod()
    {
        return 'alibaba.aliqin.fc.tts.num.singlecall';
    }
}