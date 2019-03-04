<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/12
 * Time: 14:04
 */

namespace Ecjia\App\Groupbuy\StoreCleanHandlers;

use Ecjia\App\Store\StoreCleanAbstract;
use RC_Uri;
use RC_DB;
use RC_Api;
use ecjia_admin;

class StoreGroupbuyClear extends StoreCleanAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'store_favourable_clear';

    /**
     * 名称
     * @var string
     */
    protected $name = '团购活动';

    /**
     * 排序
     * @var int
     */
    protected $sort = 86;

    /**
     * 数据描述及输出显示内容
     */
    public function handlePrintData()
    {
        $count = $this->handleCount();

        $url = RC_Uri::url('groupbuy/admin/init');

        return <<<HTML

<span class="controls-info w300">店铺团购活动总共<span class="ecjiafc-red ecjiaf-fs3">{$count}</span>个</span>

<span class="controls-info"><a href="{$url}" target="__blank">查看全部>>></a></span>

HTML;

    }

    /**
     * 获取数据统计条数
     *
     * @return mixed
     */
    public function handleCount()
    {
        $count = RC_DB::table('goods_activity')->where('act_type', GAT_GROUP_BUY)->where('store_id', $this->store_id)->count();

        return $count;
    }


    /**
     * 执行清除操作
     *
     * @return mixed
     */
    public function handleClean()
    {
        $count = $this->handleCount();
        if (empty($count)) {
            return true;
        }

        $result = RC_DB::table('goods_activity')->where('act_type', GAT_GROUP_BUY)->where('store_id', $this->store_id)->delete();

        if ($result) {
            $this->handleAdminLog();
        }

        return $result;
    }

    /**
     * 返回操作日志编写
     *
     * @return mixed
     */
    public function handleAdminLog()
    {
        \Ecjia\App\Store\Helper::assign_adminlog_content();

        $store_info = RC_Api::api('store', 'store_info', array('store_id' => $this->store_id));

        $merchants_name = !empty($store_info) ? sprintf(__('店铺名是%s', 'article'), $store_info['merchants_name']) : sprintf(__('店铺ID是%s', 'article'), $this->store_id);

        ecjia_admin::admin_log($merchants_name, 'clean', 'store_groupbuy_activity');
    }

    /**
     * 是否允许删除
     *
     * @return mixed
     */
    public function handleCanRemove()
    {
        return $this->handleCount() != 0 ? true : false;
    }


}