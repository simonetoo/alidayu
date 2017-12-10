<?php

namespace Vicens\Alidayu\Request;

/**
 * 短信发送记录
 * @link https://api.alidayu.com/docs/api.htm?apiId=26039
 * @method $this|string recNum(string | null $recNum = null)
 * @method $this|int currentPage(int | null $currentPage = null)
 * @method $this|int pageSize(int | null $pageSize = null)
 * @method $this|string queryDate(string | null $queryDate = null)
 * @method $this|string bizId(string | null $bizId = null)
 */
class SmsQuery extends AbstractRequest
{

    protected $params = [];

    /**
     * SmsQuery constructor.
     * @param string $recNum 短信接收号码
     * @param int $currentPage 当前页码
     * @param int $pageSize 每页显示条数
     * @param string|null $queryDate 查询日期
     * @param string|null $bizId 短信发送流水
     */
    public function __construct($recNum, $currentPage = 1, $pageSize = 10, $queryDate = null, $bizId = '')
    {
        $this->setParams([
            'rec_num' => $recNum,
            'current_page' => $currentPage,
            'page_size' => $pageSize,
            'query_date' => $queryDate ?: date('Ymd'),
            'biz_id' => $bizId
        ]);
    }

    /**
     * 返回接口名
     * @return string
     */
    public function getMethod()
    {
        return 'alibaba.aliqin.fc.sms.num.query';
    }
}

