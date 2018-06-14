<?php
/**
 * ECJIA 管理中心团购商品语言文件
 */

/* 当前页面标题及可用链接名称 */
$LANG['group_buy_list'] = '团购活动列表';
$LANG['add_group_buy'] = '添加团购活动';
$LANG['edit_group_buy'] = '编辑团购活动';

/* 活动列表页 */
$LANG['goods_name'] = '商品名称';
$LANG['start_date'] = '开始时间';
$LANG['end_date'] = '结束时间';
$LANG['deposit'] = '保证金';
$LANG['restrict_amount'] = '限购';
$LANG['gift_integral'] = '赠送积分';
$LANG['valid_order'] = '订单';
$LANG['valid_goods'] = '订购商品';
$LANG['current_price'] = '当前价格';
$LANG['current_status'] = '状态';
$LANG['view_order'] = '查看订单';

/* 添加/编辑活动页 */
$LANG['goods_cat'] = '商品分类';
$LANG['all_cat'] = '所有分类';
$LANG['goods_brand'] = '商品品牌';
$LANG['all_brand'] = '所有品牌';

$LANG['label_goods_name'] = '团购商品：';
$LANG['notice_goods_name'] = '请先搜索商品,在此生成选项列表...';
$LANG['label_start_date'] = '活动开始时间：';
$LANG['label_end_date'] = '活动结束时间：';
$LANG['notice_datetime'] = '（年月日－时）';
$LANG['label_deposit'] = '保证金：';
$LANG['label_restrict_amount'] = '限购数量：';
$LANG['notice_restrict_amount']= '达到此数量，团购活动自动结束。0表示没有数量限制。';
$LANG['label_gift_integral'] = '赠送积分数：';
$LANG['label_price_ladder'] = '价格阶梯：';
$LANG['notice_ladder_amount'] = '数量达到';
$LANG['notice_ladder_price'] = '享受价格';
$LANG['label_desc'] = '活动说明：';
$LANG['label_status'] = '活动当前状态：';
$LANG['gbs'][GBS_PRE_START] = '未开始';
$LANG['gbs'][GBS_UNDER_WAY] = '进行中';
$LANG['gbs'][GBS_FINISHED] = '结束未处理';
$LANG['gbs'][GBS_SUCCEED] = '成功结束';
$LANG['gbs'][GBS_FAIL] = '失败结束';
$LANG['label_order_qty'] = '订单数 / 有效订单数：';
$LANG['label_goods_qty'] = '商品数 / 有效商品数：';
$LANG['label_cur_price'] = '当前价：';
$LANG['label_end_price'] = '最终价：';
$LANG['label_handler'] = '操作：';
$LANG['error_group_buy'] = '您要操作的团购活动不存在';
$LANG['error_status'] = '当前状态不能执行该操作！';
$LANG['button_finish'] = '结束活动';
$LANG['notice_finish'] = '（修改活动结束时间为当前时间）';
$LANG['button_succeed'] = '活动成功';
$LANG['notice_succeed'] = '（更新订单价格）';
$LANG['button_fail'] = '活动失败';
$LANG['notice_fail'] = '（取消订单，保证金退回帐户余额，失败原因可以写到活动说明中）';
$LANG['cancel_order_reason'] = '团购失败';
$LANG['js_languages']['succeed_confirm'] = '此操作不可逆，您确定要设置该团购活动成功吗？';
$LANG['js_languages']['fail_confirm'] = '此操作不可逆，您确定要设置该团购活动失败吗？';
$LANG['button_mail'] = '发送邮件';
$LANG['notice_mail'] = '（通知客户付清余款，以便发货）';
$LANG['mail_result'] = '该团购活动共有 %s 个有效订单，成功发送了 %s 封邮件。';
$LANG['invalid_time'] = '您输入了一个无效的团购时间。';

$LANG['add_success'] = '添加团购活动成功。';
$LANG['edit_success'] = '编辑团购活动成功。';
$LANG['back_list'] = '返回团购活动列表。';
$LANG['continue_add'] = '继续添加团购活动。';

/* 添加/编辑活动提交 */
$LANG['error_goods_null'] = '您没有选择团购商品！';
$LANG['error_goods_exist'] = '您选择的商品目前有一个团购活动正在进行！';
$LANG['error_price_ladder'] = '您没有输入有效的价格阶梯！';
$LANG['error_restrict_amount'] = '限购数量不能小于价格阶梯中的最大数量';

$LANG['js_languages']['error_goods_null'] = '您没有选择团购商品！';
$LANG['js_languages']['error_deposit'] = '您输入的保证金不是数字！';
$LANG['js_languages']['error_restrict_amount'] = '您输入的限购数量不是整数！';
$LANG['js_languages']['error_gift_integral'] = '您输入的赠送积分数不是整数！';
$LANG['js_languages']['search_is_null'] = '没有搜索到任何商品，请重新搜索';

/* 删除团购活动 */
$LANG['js_languages']['batch_drop_confirm'] = '您确定要删除选定的团购活动吗？';
$LANG['error_exist_order'] = '该团购活动已经有订单，不能删除！';
$LANG['batch_drop_success'] = '成功删除了 %s 条团购活动记录（已经有订单的团购活动不能删除）。';
$LANG['no_select_group_buy'] = '您现在没有团购活动记录！';

/* 操作日志 */
$LANG['log_action']['group_buy'] = '团购商品';

//end