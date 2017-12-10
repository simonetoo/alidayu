<?php

namespace Vicens\Alidayu\Request;

/**
 * 语音通知
 * @link https://api.alidayu.com/docs/api.htm?apiId=25445
 * @method $this|string calledNum(string | null $calledNum = null)
 * @method $this|string calledShowNum(string | null $calledShowNum = null)
 * @method $this|string voiceCode(string | null $voiceCode = null)
 * @method $this|string extend(string | null $extend = null)
 */
class SingleCall extends AbstractRequest
{

    /**
     * SingleCall constructor.
     * @param string $calledNum 被叫号码
     * @param string $calledShowNum 被叫号码侧的号码显示
     * @param string $voiceCode 语音文件ID
     * @param string $extend 回传参数
     */
    public function __construct($calledNum, $calledShowNum, $voiceCode, $extend = '')
    {
        $this->setParams([
            'called_num' => $calledNum,
            'called_show_num' => $calledShowNum,
            'voice_code' => $voiceCode,
            'extend' => $extend
        ]);
    }

    /**
     * 返回接口名
     * @return string
     */
    public function getMethod()
    {
        return 'alibaba.aliqin.fc.voice.num.singlecall';
    }
}
