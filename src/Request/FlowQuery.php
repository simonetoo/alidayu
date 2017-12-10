<?php

namespace Vicens\Alidayu\Request;

/**
 * 流量直充查询
 * @link https://api.alidayu.com/docs/api.htm?apiId=26305
 * @method $this|string outId(string | null $outId = null)
 */
class FlowQuery extends AbstractRequest
{

    /**
     * FlowQuery constructor.
     * @param string|null $outId 唯一流水号
     */
    public function __construct($outId = null)
    {
        $this->setParams([
            'out_id' => $outId
        ]);
    }

    /**
     * 返回接口名
     * @return string
     */
    public function getMethod()
    {
        return 'alibaba.aliqin.fc.flow.query';
    }
}
