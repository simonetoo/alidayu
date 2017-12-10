<?php

namespace Vicens\Alidayu\Request;

/**
 * 多方通话接口类
 * @link https://api.alidayu.com/docs/api.htm?apiId=25443
 * @method $this|string callerNum(string | null $callerNum = null)
 * @method $this|string callerShowNum(string | null $callerShowNum = null)
 * @method $this|string calledNum(string | null $calledNum = null)
 * @method $this|string calledShowNum(string | null $calledShowNum = null)
 * @method $this|string extend(string | null $extend = null)
 * @method $this|int sessionTimeOut(int | null $sessionTimeOut = null)
 */
class DoubleCall extends AbstractRequest
{

    /**
     * DoubleCall constructor.
     * @param string $callerNum 主叫号码
     * @param string $callerShowNum 主叫号码侧的号码显示
     * @param string $calledNum 被叫号码
     * @param string $calledShowNum 被叫号码侧的号码显示
     * @param string $extend 回传参数
     * @param int $sessionTimeOut 超时时间
     */
    public function __construct($callerNum, $callerShowNum, $calledNum, $calledShowNum, $extend = '', $sessionTimeOut = 120)
    {
        $this->setParams([
            'caller_num' => $callerNum,
            'caller_show_num' => $callerShowNum,
            'called_num' => $calledNum,
            'called_show_num' => $calledShowNum,
            'extend' => $extend,
            'session_time_out' => $sessionTimeOut
        ]);
    }


    /**
     * 返回API名
     * @return string
     */
    public function getMethod()
    {
        return 'alibaba.aliqin.fc.voice.num.doublecall';
    }
}
