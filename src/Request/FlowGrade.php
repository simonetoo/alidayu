<?php

namespace Vicens\Alidayu\Request;

/**
 * 流量直充档位表
 * @link https://api.alidayu.com/docs/api.htm?apiId=26312
 * @method $this|string phoneNum(string | null $phoneNum = null)
 */
class FlowGrade extends AbstractRequest
{

    /**
     * FlowGrade constructor.
     * @param string|null $phoneNum 手机号
     */
    public function __construct($phoneNum = null)
    {
        $this->setParams([
            'phone_num' => $phoneNum
        ]);
    }

    /**
     * 返回接口名
     * @return string
     */
    public function getMethod()
    {
        return 'alibaba.aliqin.fc.flow.grade';
    }
}
