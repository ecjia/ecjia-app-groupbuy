<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.groupbuy_info.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        {if $action_link}
        <a class="btn btn-primary data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fa fa-reply"></i> {$action_link.text}</a>
        {/if}
        </h2>
    </div>
</div>

<form class="cmxform form-horizontal tasi-form" name="theForm" method="post" action="{$form_action}">
	<div class="row">
	  	<div class="col-lg-12">
	      	<section class="panel">
	      		<div class="panel-body">
					<div class="form-group">
                          <label class="control-label col-lg-2">商品关键字：</label>
                           <div class="col-lg-6">
                              <input class="form-control" type="text" name="keywords" />
                          </div>
                           <button class="btn btn-primary searchGoods" data-url='{url path="/merchant/search_goods"}' type="button"><i class='fa fa-search'></i> 搜索</button>
               		</div> 
               		
					<div class="form-group">
						<label class="control-label col-lg-2">{t}团购商品：{/t}</label>
						<div class="col-lg-6">
							<select name="goods_id" class="col-lg-12 goods_list" >
							  <!--  {if $action eq 'insert'} -->
						        <option value="0">{t}请先搜索商品,在此生成选项列表...{/t}</option>
						      <!-- {else} -->
						     <option value="{$group_buy.goods_id}">{$group_buy.goods_name}</option>
						      <!-- {/if} -->
						    </select>   
						</div>
					</div>
							
					<div class="form-group" >
						<label class="control-label col-lg-2">{t}保证金：{/t}</label>
						<div class="col-lg-6">
							<input class="form-control" type="text" name="deposit" id="deposit" value="{$group_buy.deposit|default:0}" />
						</div>
					</div>
				
					<div class="form-group" >
						<label class="control-label col-lg-2">{t}限购数量：{/t}</label>
						<div class="col-lg-6">
							<input class="form-control" type="text" name="restrict_amount" id="restrict_amount" value="{$group_buy.restrict_amount|default:0}" />
							<span class="help-block">{t}达到此数量，团购活动自动结束。0表示没有数量限制。{/t}</span>
						</div>
					</div>
								
					<div class="form-group" >
						<label class="control-label col-lg-2">{t}赠送积分数：{/t}</label>
						<div class="col-lg-6">
							<input class="form-control" type="text" name="gift_integral" id="gift_integral" value="{$group_buy.gift_integral|default:0}" />
						</div>
					</div>
								
					<div class="form-group">
						<label class="control-label col-lg-2">{t}价格阶梯：{/t}</label>
						<div class="col-lg-10">
							<!-- {foreach from=$group_buy.price_ladder key=key item=item} -->
	 							<!-- {if $key eq 0} -->
							  	<div class="time-picker">
									{t}数量达到{/t}&nbsp;<input type="text" name="ladder_amount[]" value="{$item.amount}" class="w70 form-control" />&nbsp;&nbsp;
								    {t}享受价格{/t}&nbsp;<input type="text" name="ladder_price[]"  value="{$item.price}"  class="w70 form-control" />
									<a class="no-underline" data-toggle="clone-obj" data-parent=".time-picker" href="javascript:;"><i class="fa fa-plus"></i></a>    
								</div>
							 	<!-- {else} -->
							 	<div class="time-picker">
									{t}数量达到{/t}&nbsp;<input type="text" name="ladder_amount[]" value="{$item.amount}" class="w70 form-control" />&nbsp;&nbsp;
									{t}享受价格{/t}&nbsp;<input type="text" name="ladder_price[]"  value="{$item.price}"  class="w70 form-control" />
									<a class="no-underline" data-toggle="remove-obj" data-parent=".time-picker" href="javascript:;"><i class="fa fa-times"></i></a>
								</div>
							  	<!-- {/if} -->
						  	<!-- {/foreach} -->
						</div>
					</div>
								
					<div class="form-group">
						<label class="control-label col-lg-2">{t}活动开始时间：{/t}</label>
						<div class="col-lg-6">
							<input name="start_time" class="date form-control" type="text" placeholder="{t}请选择活动开始时间{/t}" value="{$group_buy.start_time}"/>
						</div>
					</div>
						
					<div class="form-group">
						<label class="control-label col-lg-2">{t}活动结束时间：{/t}</label>
						<div class="col-lg-6">
							<input name="end_time" class="date form-control" type="text" placeholder="{t}请选择活动结束时间{/t}" value="{$group_buy.end_time}"/>
						</div>
					</div>
					
					<div class="page-header panel-body m_b0">
						<div class="pull-left">
							<h3>团购活动介绍</h3>
						</div>
						<div class="clearfix">
						</div>
					</div>
					<div class="row-fluid panel-body">
						<div class="span12">
							{ecjia:editor content=$group_buy.act_desc textarea_name='act_desc'}
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-offset-2 col-lg-10">
							<input name="act_id" type="hidden" id="act_id" value="{$group_buy.act_id}">
						    <input type="submit" name="submit" value="{lang key='system::system.button_submit'}" class="btn btn-info" />
						    {if $group_buy.status eq 1}
						    <input type="submit" name="finish" value="{lang key='groupbuy::groupbuy.button_finish'}" class="btn btn-info all" />
						    {elseif $group_buy.status eq 2}
						    <input type="submit" name="succeed" value="{lang key='groupbuy::groupbuy.button_succeed'}" class="btn btn-info all" />{$lang.notice_succeed}
						    <input type="submit" name="fail" value="{lang key='groupbuy::groupbuy.button_fail'}" class="btn btn-info all" />{$lang.notice_fail}
						    {elseif $group_buy.status eq 3}
						    <input type="submit" name="mail" value="{lang key='groupbuy::groupbuy.button_mail'}" class="btn btn-info all"  />
						    {/if}
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</form>
<!-- {/block} -->