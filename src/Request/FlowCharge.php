<?php

namespace Vicens\Alidayu\Request;

/**
 * 流量直充
 * @link https://api.alidayu.com/docs/api.htm?apiId=26306
 * @method $this|string phoneNum(string | null $phoneNum = null)
 * @method $this|string grade(string | null $grade = null)
 * @method $this|string outRechargeId(string | null $outRechargeId = null)
 * @method $this|int scope(int | null $scope = null)
 * @method $this|boolean isProvince(boolean | null $isProvince = null)
 * @method $this|string reason(string | null $reason = null)
 */
class FlowCharge extends AbstractRequest
{

    /**
     * FlowCharge constructor.
     * @param string $phoneNum 手机号
     * @param int $grade 充值数量
     * @param string $outRechargeId 唯一流水号
     * @param int $scope 0:全国漫游流量 1:省内流量
     * @param bool $isProvince 是否分省通道(scope为0时生效)
     * @param string $reason 充值原因
     */
    public function __construct($phoneNum, $grade, $outRechargeId, $scope = 0, $isProvince = false, $reason = '')
    {
        $this->setParams([
            'phone_num' => $phoneNum,
            'grade' => $grade,
            'out_recharge_id' => $outRechargeId,
            'scope' => $scope,
            'is_province' => $isProvince,
            'reason' => $reason
        ]);
    }

    /**
     * 返回接口所需参数
     * @return array
     */
    public function getParams()
    {
        $params = parent::getParams();

        $params['is_province'] = $params['is_province'] ? 'true' : 'false';

        return $params;
    }

    /**
     * 返回接口名
     * @return string
     */
    public function getMethod()
    {
        return 'alibaba.aliqin.fc.flow.charge';
    }
}
