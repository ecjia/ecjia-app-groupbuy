<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 团购商品列表
 * @author zrl
 *
 */
class list_module extends api_front implements api_interface {
	
	public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		/* 获取数量 */
		$size = $this->requestData('pagination.count', 15);
		$page = $this->requestData('pagination.page', 1);
		$location	 = $this->requestData('location', array());
		
		/*经纬度为空判断*/
		if ((is_array($location) && !empty($location['longitude']) && !empty($location['latitude']))) {
			$geohash = RC_Loader::load_app_class('geohash', 'store');
			$geohash_code = $geohash->encode($location['latitude'] , $location['longitude']);
			$store_id_arr = RC_Api::api('store', 'neighbors_store_id', array('geohash' => $geohash_code));
		} else {
			$data = array();
			$data['list'] = array();
			$data['pager'] = array(
					"total" => 0,
					"count" => 0,
					"more"	=> 0
			);
			return array('data' => $data['list'], 'pager' => $data['pager']);
		}
		
		$db_goods_activity = RC_DB::table('goods_activity as ga')
		->leftJoin('goods as g', RC_DB::raw('ga.goods_id'), '=', RC_DB::raw('g.goods_id'));
		
		$db_goods_activity
		->where(RC_DB::raw('ga.act_type'),GAT_GROUP_BUY)
		->where(RC_DB::raw('ga.start_time'),'<=', RC_Time::gmtime())
		->where(RC_DB::raw('ga.end_time'),'>=', RC_Time::gmtime())
		->whereRaw('g.goods_id is not null')
		->where(RC_DB::raw('g.is_delete'),0)
		->where(RC_DB::raw('g.is_on_sale'),1)
		->where(RC_DB::raw('g.is_alone_sale'),1);
		
		if (!empty($store_id_arr)) {
			$db_goods_activity->whereIn(RC_DB::raw('g.store_id'), $store_id_arr);
		}
		
		if (ecjia::config('review_goods') == 1) {
			$db_goods_activity->where(RC_DB::raw('g.review_status'), '>', 2);
		}
		
		$count = $db_goods_activity->count(RC_DB::raw('ga.act_id'));
		$page_row = new ecjia_page($count, $size, 6, '', $page);
    	
		$res = $db_goods_activity
		->selectRaw('ga.*,g.shop_price, g.market_price, g.goods_brief, g.goods_thumb, g.goods_img, g.original_img')
		->take($size)->skip($page_row->start_id - 1)->orderBy(RC_DB::raw('ga.act_id'),'desc')
		->get();
    	$list = array();
    	if (!empty($res)) {
    		foreach ($res as $val) {
    			$ext_info = unserialize($val['ext_info']);
    			$price_ladder = $ext_info['price_ladder'];
    			if (!is_array($price_ladder) || empty($price_ladder)) {
    				$price_ladder = array(array('amount' => 0, 'price' => 0));
    			} else {
    				foreach ($price_ladder AS $key => $amount_price) {
    					$price_ladder[$key]['formated_price'] = price_format($amount_price['price']);
    				}
    			}
    			$cur_price  = $price_ladder[0]['price'];    // 初始化
    			$list[] = array(
    					'id'					=> $val['goods_id'],
    					'name'					=> $val['goods_name'],
    					'market_price'			=> $val['market_price'],
    					'formated_market_price'	=> price_format($val['market_price'], false),
    					'shop_price'			=> $val['shop_price'],
    					'formated_shop_price'	=> price_format($val['shop_price'], false),
    					'promote_price'			=> $cur_price,
    					'formated_promote_price'=> price_format($cur_price, false),
    					'promote_start_date'	=> RC_Time::local_date('Y/m/d H:i:s', $val['start_time']),
    					'promote_end_date'		=> RC_Time::local_date('Y/m/d H:i:s', $val['end_time']),
				    	'img'					=> array(
						    							'small'	=> empty($val['goods_thumb']) ? '' : RC_Upload::upload_url($val['goods_thumb']),
														'thumb'	=> empty($val['goods_img']) ? '' : RC_Upload::upload_url($val['goods_img']),
														'url'	=> empty($val['original_img'])? '' : RC_Upload::upload_url($val['original_img'])						    					),
    					'goods_activity_id'		=> $val['act_id'],
    					'activity_type'			=> 'GROUPBUY_GOODS'
    			);
    		}
    	}
    	
    	
    	$pager = array(
    			"total" => $page_row->total_records,
    			"count" => $page_row->total_records,
    			"more"	=> $page_row->total_pages <= $page ? 0 : 1,
    	);

    	return array('data' => $list, 'pager' => $pager);
    	
    }
}


// end