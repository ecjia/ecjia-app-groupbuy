<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
defined('IN_ECJIA') or exit('No permission resources.');

class admin extends ecjia_admin {
	private $db_goods_activity;
	private $db_order_info;
	private $db_order_goods;
	private $dbview;
	private $db_goods;
	public function __construct() {
		parent::__construct();

		RC_Lang::load('groupbuy');
		RC_Loader::load_app_func('common', 'goods');
		RC_Loader::load_app_func('category', 'goods');
		RC_Loader::load_app_func('goods', 'goods');
		RC_Loader::load_app_func('order', 'orders');
	
		$this->db_goods_activity = RC_Loader::load_app_model('goods_activity_model', 'goods');
		$this->db_order_goods = RC_Loader::load_app_model('order_goods_model', 'orders');
		$this->db_order_info = RC_Loader::load_app_model('order_info_model', 'orders');
		$this->dbview = RC_Model::model('orders/order_info_viewmodel');
		$this->db_goods = RC_Loader::load_app_model('goods_model', 'goods');
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'), array(), false, false);
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'), array(), false, false);
		RC_Script::enqueue_script('media-editor', RC_Uri::vendor_url('tinymce/tinymce.min.js'), array(), false, true);
		RC_Script::enqueue_script('bootstrap-datetimepicker.min', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.js'));
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Script::enqueue_script('bootstrap-timepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-timepicker.min.js'));
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.css'));
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('bootstrap-placeholder', RC_Uri::admin_url('statics/lib/dropper-upload/bootstrap-placeholder.js'), array(), false, true);
		
		RC_Script::enqueue_script('groupbuy', RC_App::apps_url('statics/js/groupbuy.js', __FILE__), array(), false, true);
		RC_Script::localize_script('groupbuy', 'js_lang', RC_Lang::get('groupbuy::group_buy.js_lang'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('团购活动列表'), RC_Uri::url('groupbuy/admin/init')));
	}
	
	/**
	 * 团购活动列表
	 */
	public function init() {
		$this->admin_priv('groupbuy_manage', ecjia::MSGTYPE_JSON);
				
		$this->assign('ur_here', '团购活动列表');
		$this->assign('action_link', array('href' => RC_Uri::url('groupbuy/admin/add'), 'text' => '添加团购活动'));
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('团购活动列表')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> __('概述'),
			'content'	=>
			'<p>' . __('欢迎访问ECJia智能后台团购活动列表页面，系统中所有的团购活动都会显示在此列表中。') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . __('更多信息:') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:团购活动" target="_blank">关于团购活动帮助文档</a>') . '</p>'
		);
		
		$groupbuy_list = $this->group_buy_list();
		$this->assign('groupbuy_list', $groupbuy_list);
		
		$adminru = $this->get_admin_ru_id();
		if ($adminru['ru_id'] == 0) {
			$this->assign('priv_ru', 1);
		} else {
			$this->assign('priv_ru', 0);
		}
		$this->assign('search_action', RC_Uri::url('groupbuy/admin/init'));
		$this->assign_lang();
		
		$this->display('group_buy_list.dwt');
	}
		
	/**
	 * 添加团购活动页面
	 */
	public function add() {
		$this->admin_priv('groupbuy_add', ecjia::MSGTYPE_JSON);
		
		$this->assign('ur_here', '添加团购商品');
		$this->assign('ur_here2', '设置团购信息');
		$this->assign('action_link', array('href' => RC_Uri::url('groupbuy/admin/init'), 'text' => '团购活动列表'));
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加团购活动')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> __('概述'),
			'content'	=>
			'<p>' . __('欢迎访问ECJia智能后台添加团购活动页面，可以在此页面添加团购活动信息。') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . __('更多信息:') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:团购活动#.E6.B7.BB.E5.8A.A0.E5.9B.A2.E8.B4.AD.E6.B4.BB.E5.8A.A8" target="_blank">关于添加团购活动帮助文档</a>') . '</p>'
		);
		
		$group_buy = array (
			'start_time'    => date('Y-m-d', time() + 86400),
			'end_time'      => date('Y-m-d', time() + 4 * 86400),
			'act_type'      => GAT_GROUP_BUY,
			'price_ladder'  => array(array('amount' => 0, 'price' => 0))
		);
		$this->assign('group_buy', $group_buy);
		$this->assign('cat_list', cat_list());
		$this->assign('brand_list',	get_brand_list());
		$this->assign('action', 'insert');
		$this->assign('form_action', RC_Uri::url('groupbuy/admin/insert'));
		$this->assign_lang();
		
		$this->display('group_buy_info.dwt');
	}
	
	/**
	 * 添加团购活动处理
	 */
	public function insert() {
		$this->admin_priv('groupbuy_add', ecjia::MSGTYPE_JSON);
		
		$goods_id  = intval($_POST['goods_id']);
		$info = $this->goods_group_buy($goods_id);
		if ($info && $info['goods_id'] == $goods_id) {
			$this->showmessage('您选择的商品目前有一个团购活动正在进行,请选择其他商品！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$goods_name = $this->db_goods->where(array('goods_id' => $goods_id))->get_field('goods_name');
		$act_name = $goods_name;
		
		$act_desc = !empty($_POST['act_desc']) ? trim($_POST['act_desc']) : '';
		$price_ladder 	 = !empty($_POST['price_ladder']) 	 ? $_POST['price_ladder'] 	 : '';
		$restrict_amount = !empty($_POST['restrict_amount']) ? $_POST['restrict_amount'] : '';
		$gift_integral	 = !empty($_POST['gift_integral']) 	 ? $_POST['gift_integral'] 	 : '';
		$deposit = !empty($_POST['deposit']) ? $_POST['deposit'] : '';
		
		$price_ladder = array();
		$count = count($_POST['ladder_amount']);
		for ($i = $count - 1; $i >= 0; $i--) {
			$amount = intval($_POST['ladder_amount'][$i]);
			if ($amount <= 0) {
				continue;
			}
			$price = round(floatval($_POST['ladder_price'][$i]), 2);
			if ($price <= 0) {
				continue;
			}
			$price_ladder[$amount] = array('amount' => $amount, 'price' => $price);	
		}
		if (count($price_ladder) < 1) {
			$this->showmessage('请输入有效的价格阶梯！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$amount_list = array_keys($price_ladder);
		if ($restrict_amount > 0 && max($amount_list) > $restrict_amount) {
			$this->showmessage('限购数量不能小于价格阶梯中的最大数量！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		ksort($price_ladder);
		$price_ladder = array_values($price_ladder);
		
		$start_time = !empty($_POST['start_time']) ? RC_Time::local_strtotime($_POST['start_time']) : '';
		$end_time = !empty($_POST['end_time']) ? RC_Time::local_strtotime($_POST['end_time']) : '';
		
		if ($start_time >= $end_time) {
			$this->showmessage('请输入一个有效的团购时间！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$adminru = $this->get_admin_ru_id();
		$data = array(
			'act_name'   	=> $act_name,
			'act_desc'   	=> $act_desc,
			'act_type'   	=> GAT_GROUP_BUY,
			'goods_id'   	=> $goods_id,
			'goods_name' 	=> $goods_name,
			'user_id'   	=> $adminru['ru_id'],
			'start_time'    => $start_time,
			'end_time'      => $end_time,
			'ext_info'   	=> serialize(array(
				'price_ladder'      => $price_ladder,
				'restrict_amount'   => intval($restrict_amount),
				'gift_integral'     => intval($gift_integral),
				'deposit'           => intval($deposit)
			))
		);

		$groupbuy_id = $this->db_goods_activity->insert($data);
		
		$links[] = array('text' => __('返回团购活动列表'), 'href'=> RC_Uri::url('groupbuy/admin/init'));
		$links[] = array('text' => '继续添加团购活动', 'href'=> RC_Uri::url('groupbuy/admin/add'));
		ecjia_admin::admin_log($goods_name, 'add', 'group_buy');
		$this->showmessage('添加团购活动成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('groupbuy/admin/edit', array('id' => $groupbuy_id))));
	}
	
	/**
	 * 编辑团购活动页面
	 */
	public function edit() {
		$this->admin_priv('groupbuy_update', ecjia::MSGTYPE_JSON);

		$this->assign('ur_here', '更新团购商品');
		$this->assign('ur_here2', '更新团购信息');
		$this->assign('action_link', array('href' => RC_Uri::url('groupbuy/admin/init'), 'text' => '团购活动列表'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('更新团购活动')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> __('概述'),
			'content'	=>
			'<p>' . __('欢迎访问ECJia智能后台编辑团购活动页面，可以在此页面编辑相应的团购活动信息。') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . __('更多信息:') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:团购活动#.E7.BC.96.E8.BE.91.E5.9B.A2.E8.B4.AD.E6.B4.BB.E5.8A.A8" target="_blank">关于编辑团购活动帮助文档</a>') . '</p>'
		);
		
		$act_id = intval($_GET['id']) ;
		$group_buy = group_buy_info($act_id);
		
		$this->assign('group_buy', $group_buy);
		$this->assign('form_action', RC_Uri::url('groupbuy/admin/update'));
		$this->assign_lang();
		
		$this->display('group_buy_info.dwt');
	}
	
	/**
	 * 编辑团购活动处理
	 */
	public function update() {
		$this->admin_priv('groupbuy_update', ecjia::MSGTYPE_JSON);
		
		$group_buy_id = !empty($_POST['act_id']) ? intval($_POST['act_id']) : 0;
		$group_buy = group_buy_info($group_buy_id);
		$submitname = isset($_POST['submitname']) ? $_POST['submitname'] : '';
		
		if ($submitname == 'finish') {
			if ($group_buy['status'] != GBS_UNDER_WAY) {
				$this->showmessage(RC_Lang::get('groupbuy::groupbuy.error_status'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
	
			$data =  array(
				'end_time' => RC_Time::gmtime(),
			);
		    $this->db_goods_activity->where(array('act_id' => $group_buy_id))->update($data);

			$links[] = array('text' => RC_Lang::get('groupbuy::groupbuy.back_list'),'href' => RC_Uri::url('groupbuy/admin/init'));
			$this->showmessage(RC_Lang::get('groupbuy::groupbuy.edit_success'), ecjia::MSGTYPE_JSON|ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('groupbuy/admin/edit', array('id' => $group_buy_id))));
		} elseif ($submitname == 'succeed') {
			if ($group_buy['status'] != GBS_FINISHED) {
				$this->showmessage(RC_Lang::get('groupbuy::groupbuy.error_status'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
	
			if ($group_buy['total_order'] > 0) {
				$order_id_list = $this->db_order_info->where('extension_code = "group_buy" AND extension_id = '.$group_buy_id.' AND (order_status = ' . OS_CONFIRMED . ' or order_status = ' . OS_UNCONFIRMED . ')')->get_field('order_id',true);
				$final_price = $group_buy['trans_price'];

				$data = array(
					'goods_price' => $final_price
				);
		        $this->db_order_goods->in(array('order_id'=>$order_id_list))->update($data);
		        $res = $this->db_order_goods->field('order_id, SUM(goods_number * goods_price) AS goods_amount')->in(array('order_id' => $order_id_list))->order('order_id asc')->select();
		        
				if (!empty($res)) {
					foreach ($res as $row) {
						$order_id = $row['order_id'];
						$goods_amount = floatval($row['goods_amount']);
			
						/* 取得订单信息 */
						$order = order_info($order_id);
						/* 判断订单是否有效：余额支付金额 + 已付款金额 >= 保证金 */
						if ($order['surplus'] + $order['money_paid'] >= $group_buy['deposit']) {
							$order['goods_amount'] = $goods_amount;
							if ($order['insure_fee'] > 0) {
								$shipping = shipping_info($order['shipping_id']);
								$order['insure_fee'] = shipping_insure_fee($shipping['shipping_code'], $goods_amount, $shipping['insure']);
							}
							// 重算支付费用
							$order['order_amount'] = $order['goods_amount'] + $order['shipping_fee']
							+ $order['insure_fee'] + $order['pack_fee'] + $order['card_fee']
							- $order['money_paid'] - $order['surplus'];
							if ($order['order_amount'] > 0) {
								$order['pay_fee'] = pay_fee($order['pay_id'], $order['order_amount']);
							} else {
								$order['pay_fee'] = 0;
							}
		
							$order['order_amount'] += $order['pay_fee'];
							if ($order['order_amount'] > 0) {
								$order['pay_status'] = PS_UNPAYED;
								$order['pay_time'] = 0;
							} else {
								$order['pay_status'] = PS_PAYED;
								$order['pay_time'] = RC_Time::gmtime();
							}
			
							if ($order['order_amount'] < 0) {
								// todo （现在手工退款）
							}
							$order['order_status'] = OS_CONFIRMED;
							$order['confirm_time'] = RC_Time::gmtime();
							update_order($order_id, $order);
						} else {
							$order['order_status'] = OS_CANCELED;
							$order['to_buyer'] = RC_Lang::get('groupbuy::groupbuy.cancel_order_reason');
							$order['pay_status'] = PS_UNPAYED;
							$order['pay_time'] = 0;
							$money = $order['surplus'] + $order['money_paid'];
							if ($money > 0) {
								$order['surplus'] = 0;
								$order['money_paid'] = 0;
								$order['order_amount'] = $money;
								order_refund($order, 1, RC_Lang::get('groupbuy::groupbuy.cancel_order_reason') . ':' . $order['order_sn']);
							}
							/* 更新订单 */
							update_order($order['order_id'], $order);
						}
					}
				}
			}

			$data = array(
				'is_finished' => GBS_SUCCEED
			);
			$this->db_goods_activity->where(array('act_id' => $group_buy_id ))->update($data);
			/* 提示信息 */
			$links[] = array('href' => RC_Uri::url('groupbuy/admin/init'), 'text' => RC_Lang::get('groupbuy::groupbuy.back_list'));
			$this->showmessage(RC_Lang::get('groupbuy::groupbuy.edit_success'), ecjia::MSGTYPE_JSON|ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('groupbuy/admin/edit', array('id' => $group_buy_id))));
		} elseif ($submitname == 'fail') {
			if ($group_buy['status'] != GBS_FINISHED) {
				$this->showmessage(RC_Lang::get('groupbuy::groupbuy.error_status'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			if ($group_buy['valid_order'] > 0) {
				$res = $this->db_order_info->where('extension_code = "group_buy" AND extension_id = '.$group_buy_id.' AND (order_status = ' . OS_CONFIRMED . ' OR order_status = ' . OS_UNCONFIRMED . ')')->select();
				if (!empty($res)) {
					foreach ($res as $order) {
						// 修改订单状态为已取消，付款状态为未付款
						$order['order_status'] = OS_CANCELED;
						$order['to_buyer'] = RC_Lang::get('groupbuy::groupbuy.cancel_order_reason');
						$order['pay_status'] = PS_UNPAYED;
						$order['pay_time'] = 0;
						/* 如果使用余额或有已付款金额，退回帐户余额 */
						$money = $order['surplus'] + $order['money_paid'];
						if ($money > 0)
						{
							$order['surplus'] = 0;
							$order['money_paid'] = 0;
							$order['order_amount'] = $money;
							// 退款到帐户余额
							order_refund($order, 1, RC_Lang::get('groupbuy::groupbuy.cancel_order_reason') . ':' . $order['order_sn'], $money);
						}
						/* 更新订单 */
						update_order($order['order_id'], $order);
					}
				}
			}

			$data = array(
				'is_finished' => GBS_FAIL,
				'act_desc'    => $_POST['act_desc']
			);
			$this->db_goods_activity->where(array('act_id' => $group_buy_id))->update($data);
			$this->showmessage(RC_Lang::get('groupbuy::groupbuy.edit_success'), ecjia::MSGTYPE_JSON|ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('groupbuy/admin/edit', array('id' => $group_buy_id))));
		} elseif ($submitname == 'mail') {
			if ($group_buy['status'] != GBS_SUCCEED) {
				$this->showmessage(RC_Lang::get('groupbuy::groupbuy.error_status'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			/* 取得邮件模板 */
			$tpl_name = 'group_buy';
			$tpl = RC_Api::api('mail', 'mail_template', $tpl_name);
			$count = 0;
			$send_count = 0;
			
 			$this->dbview->view = array(
	  			'order_goods' => array(
	  				'type'  =>Component_Model_View::TYPE_LEFT_JOIN,
	  				'alias' => 'g',
	  				'on'    => 'o.order_id = g.order_id',
  				)
  			);
			    
			$field = array('o.consignee, o.add_time, g.goods_number, o.order_sn, o.order_amount, o.order_id, o.email');
		    $where = "o.extension_code = 'group_buy' AND o.extension_id = '$group_buy_id' AND o.order_status = '" . OS_CONFIRMED . "'";
		    $res = $this->dbview->field($field)->where($where)->select();
		  
			if (!empty($res)) {
				$record_count = array('empty_mail' => 0, 'send_success' => 0, 'send_error' => 0, 'noeffect' => 0);
				foreach ($res as $order) {
					/* 邮件模板赋值 */
					$this->assign('consignee', $order['consignee']);
					$this->assign('add_time', RC_Time::local_date(ecjia::config('date_format'), $order['add_time']));
					$this->assign('goods_name', $group_buy['goods_name']);
					$this->assign('goods_number', $order['goods_number']);
					$this->assign('order_sn', $order['order_sn']);
					$this->assign('order_amount', price_format($order['order_amount']));
					$this->assign('shop_name', ecjia::config('shop_name'));
					$this->assign('send_date', RC_Time::local_date(ecjia::config('date_format')));
					$content = $this->fetch_string($tpl['template_content']);
					/* 取得模板内容，发邮件 */
					if (RC_Mail::send_mail('', $order['email'], $tpl['template_subject'], $content, $tpl['is_html'])) {
						$record_count['send_success'] ++;
					}
				}
			}
			$this->showmessage('邮件发送成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('groupbuy/admin/edit', array('id' => $group_buy_id))));
		} else {
			$goods_id = intval($_POST['goods_id']);
			$info = $this->goods_group_buy($goods_id);
			if ($info && $info['act_id'] != $group_buy_id) {
				$this->showmessage('您选择的商品目前有一个团购活动正在进行,请选择其他商品！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			
			$goods_name = $this->db_goods->where(array('goods_id' => $goods_id))->get_field('goods_name');
			$act_name = $goods_name;
			
			$act_desc 		 = !empty($_POST['act_desc']) 		 ? trim($_POST['act_desc'])  : '';
			$price_ladder 	 = !empty($_POST['price_ladder']) 	 ? $_POST['price_ladder'] 	 : '';
			$restrict_amount = !empty($_POST['restrict_amount']) ? $_POST['restrict_amount'] : '';
			$gift_integral	 = !empty($_POST['gift_integral']) 	 ? $_POST['gift_integral'] 	 : '';
			$deposit         = !empty($_POST['deposit']) 		 ? $_POST['deposit']  		 : '';
			
			$price_ladder = array();
			$count = count($_POST['ladder_amount']);
			for ($i = $count - 1; $i >= 0; $i--) {
				$amount = intval($_POST['ladder_amount'][$i]);
				if ($amount <= 0) {
					continue;
				}
				$price = round(floatval($_POST['ladder_price'][$i]), 2);
				if ($price <= 0) {
					continue;
				}
				$price_ladder[$amount] = array('amount' => $amount, 'price' => $price);
			}
			
			if (count($price_ladder) < 1) {
				$this->showmessage('请输入有效的价格阶梯！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			
			$amount_list = array_keys($price_ladder);
			if ($restrict_amount > 0 && max($amount_list) > $restrict_amount) {
				$this->showmessage('限购数量不能小于价格阶梯中的最大数量！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			ksort($price_ladder);
			$price_ladder = array_values($price_ladder);
			
			$start_time = !empty($_POST['start_time']) ? RC_Time::local_strtotime($_POST['start_time']) : '';
			$end_time = !empty($_POST['end_time']) ? RC_Time::local_strtotime($_POST['end_time']) : '';
			
			if ($start_time >= $end_time) {
				$this->showmessage('请输入一个有效的团购时间！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			
			$data = array(
				'act_name'   => $act_name,
				'act_desc'   => $act_desc,
				'act_type'   => GAT_GROUP_BUY,
				'goods_id'   => $goods_id,
				'goods_name' => $goods_name,
				'start_time' => $start_time,
				'end_time'   => $end_time,
				'ext_info'   => serialize(array(
					'price_ladder'      => $price_ladder,
					'restrict_amount'   => $restrict_amount,
					'gift_integral'     => $gift_integral,
					'deposit'           => $deposit
				))
			);
			$this->db_goods_activity->where(array('act_id' => $group_buy_id))->update($data);
			ecjia_admin::admin_log($goods_name, 'edit', 'group_buy');
			$this->showmessage('编辑团购商品成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('groupbuy/admin/edit', array('id' => $group_buy_id))));
		}
	}
	
	/**
	 * 批量操作
	 */
	public function batch() {
		$this->admin_priv('groupbuy_delete', ecjia::MSGTYPE_JSON);
		
		if (!empty($_SESSION['ru_id'])) {
			$this->showmessage(__('入驻商家没有操作权限，请登陆商家后台操作！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$group_buy_id = $_POST['act_id'];
		$group_buy = group_buy_info($group_buy_id);
		
		if ($group_buy['valid_order'] > 0) {
			$this->showmessage('该团购活动已经有订单，不能删除！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
            $arr = explode(',', $group_buy_id);
            foreach ($arr as $val) {
                $goods_name = $this->db_goods_activity->where(array('act_id' => $val))->get_field('goods_name');
                ecjia_admin::admin_log('团购商品是'.$goods_name, 'batch_remove', 'group_buy');
            }
			$this->db_goods_activity->in(array('act_id' => $group_buy_id))->delete();
			$this->showmessage('批量删除操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('groupbuy/admin/init')));
		}
	}
	
	/**
	 * 删除团购活动
	 */
	public function remove() {
		$this->admin_priv('groupbuy_delete', ecjia::MSGTYPE_JSON);
		
		$group_buy_id = intval($_GET['id']);
		$group_buy = group_buy_info($group_buy_id);
				
		if ($group_buy['valid_order'] > 0) {
			$this->showmessage('该团购活动已经有订单，不能删除！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			if ($this->db_goods_activity->where(array('act_id' => $group_buy_id))->delete()) {
				ecjia_admin::admin_log($group_buy['act_name'], 'remove', 'group_buy');
				$this->showmessage('删除成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			} else {
				$this->showmessage('删除失败！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
	}
	
	/**
	 * 获取团购商品列表
	 * @access  public
	 * @return void
	 */
	private  function  group_buy_list() {
		$db_goods_activity = RC_Loader::load_app_model('goods_activity_model','goods');
		
		$adminru = $this->get_admin_ru_id();
		if ($adminru['ru_id'] > 0) {
			$where['act_type'] =" and user_id = '" .$adminru['ru_id']. "'";
		}
		$filter = array();
		$filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
		$filter['ruidval'] = !empty($_GET['ruidval']) ? intval($_GET['ruidval']) : 0;
		
		$where = array();
		if ($filter['keywords']) {
			$where['act_name'] = array('like' => '%'.mysql_like_quote($filter['keywords']).'%');
		}
		
		//自营
		if ($filter['ruidval'] == 1) {
			$where['user_id'] = 0;
		}
		
		//商家
		if ($filter['ruidval'] == 2) {
			$where['user_id'] = array('gt' => 0);
		}
		
		$where['act_type'] = GAT_GROUP_BUY;
		
		$count = $db_goods_activity->where($where)->count();
		
		$field = "count(*) AS count,SUM(IF(user_id>0,1,0)) AS other,SUM(IF(user_id=0,1,0)) AS myself";
		$msg_count = $db_goods_activity->field($field)->where(array('act_type' => GAT_GROUP_BUY))->find();
		
		$msg_count = array(
			'count'		=> empty($msg_count['count']) ? 0 : $msg_count['count'],
			'other'	    => empty($msg_count['other']) ? 0 : $msg_count['other'],
			'myself'	=> empty($msg_count['myself']) ? 0 : $msg_count['myself'],
		);
		
		$page = new ecjia_page($count, 10, 5);
		$res = array();
		$where['act_type'] = GAT_GROUP_BUY;
		
		$data_content = $db_goods_activity->where($where)->order('act_id DESC')->limit($page->limit())->select();
		
		if (!empty($data_content)) {
			foreach ($data_content as $row) {
				$ext_info = unserialize($row['ext_info']);
				$stat = group_buy_stat($row['act_id'], $ext_info['deposit']);
				if (is_array($ext_info)) {
					$arr = array_merge($row, $stat, $ext_info);
				} else {
					$arr = array_merge($row, $stat);
				}
				$price_ladder = $arr['price_ladder'];
				if (!is_array($price_ladder) || empty($price_ladder)) {
					$price_ladder = array(array('amount' => 0, 'price' => 0));
				} else {
					foreach ($price_ladder AS $key => $amount_price) {
						$price_ladder[$key]['formated_price'] = price_format($amount_price['price']);
					}
				}
				
				$cur_price  = $price_ladder[0]['price'];    // 初始化
				$cur_amount = $stat['valid_goods'];         // 当前数量
				foreach ($price_ladder AS $amount_price) {
					if ($cur_amount >= $amount_price['amount']) {
						$cur_price = $amount_price['price'];
					} else {
						break;
					}
				}
				$arr['cur_price'] = $cur_price;
				$status = group_buy_status($arr);
			
				$arr['start_time']  = RC_Time::local_date(ecjia::config('date_format'), $arr['start_time']);
				$arr['end_time']    = RC_Time::local_date(ecjia::config('date_format'), $arr['end_time']);
				$arr['cur_status']  = RC_Lang::get('groupbuy::groupbuy.gbs.'.$status);
				
				$data = array('shoprz_brandName', 'shop_class_keyWords', 'shopNameSuffix');
				$shop_info = $this->get_table_date("user_id = '" .$row['user_id']. "'", $data);
				$arr['user_name'] = $shop_info['shoprz_brandName'].$shop_info['shopNameSuffix'];
				$res[] = $arr;
			}
		}
		$arr = array('groupbuy' => $res, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'msg_count' => $msg_count);
		return $arr;
	}
	
	/**
	 * 取得某商品的团购活动
	 * @param   int     $goods_id   商品id
	 * @return  array
	 */
	private function goods_group_buy($goods_id) {
		$db_goods_activity = RC_Loader::load_app_model('goods_activity_model', 'goods');
		return $db_goods_activity->find('goods_id = '.$goods_id.' AND act_type = "' . GAT_GROUP_BUY . '" AND start_time <= ' . RC_Time::gmtime().' AND end_time >= ' . RC_Time::gmtime().' ');
	}
	
	//获取入驻商家的前台会员ID
	private function get_admin_ru_id(){
		$db_admin_user = RC_Model::model('admin_user_model');
		return $db_admin_user->field('ru_id')->find(array('user_id'=> $_SESSION['admin_id']));
	}
	
	private function get_table_date($where = 1, $date = array(), $sqlType = 0) {
		$data = implode(',', $date);
		if (!empty($data)) {
			$db = RC_Loader::load_app_model('merchants_shop_information_model');
			if ($sqlType == 1) {
				return $db->field($data)->where($where)->select();
			} elseif ($sqlType == 2) {
				return $db->where($where)->get_field($data);
			} else {
				return $db->field($data)->where($where)->find();
			}
		}
	}
}
//end