<?php

namespace Vicens\Alidayu\Request;

/**
 * 流量直充分省
 * @link https://api.alidayu.com/docs/api.htm?apiId=26477
 * @method $this|string phoneNum(string | null $phoneNum = null)
 * @method $this|string grade(string | null $grade = null)
 * @method $this|string outRechargeId(string | null $outRechargeId = null)
 * @method $this|string reason(string | null $reason = null)
 */
class FlowChargeProvince extends AbstractRequest
{

    /**
     * FlowCharge constructor.
     * @param string $phoneNum 手机号
     * @param int $grade 充值数量
     * @param string $outRechargeId 唯一流水号
     * @param string $reason 充值原因
     */
    public function __construct($phoneNum, $grade, $outRechargeId, $reason = '')
    {
        $this->setParams([
            'phone_num' => $phoneNum,
            'grade' => $grade,
            'out_recharge_id' => $outRechargeId,
            'reason' => $reason
        ]);
    }

    /**
     * 返回接口名
     * @return string
     */
    public function getMethod()
    {
        return 'alibaba.aliqin.fc.flow.charge.province';
    }
}
