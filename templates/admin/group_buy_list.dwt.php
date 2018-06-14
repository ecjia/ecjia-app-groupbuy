<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.groupbuy_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<!--  {if $priv_ru eq 1} -->
	<!-- <div class="row-fluid"> -->
	<!-- <div class="choose_list span12">  -->
	<ul class="nav nav-pills">
		<li class="{if $groupbuy_list.filter.ruidval eq '0'}active{/if}"><a class="data-pjax" href='{url path="groupbuy/admin/init" args="ruidval=0"}'>全部 <span class="badge badge-info">{$groupbuy_list.msg_count.count}</span></a></li>
		<li class="{if $groupbuy_list.filter.ruidval eq '1'}active{/if}"><a class="data-pjax" href='{url path="groupbuy/admin/init" args="ruidval=1"}'>自营 <span class="badge badge-info">{$groupbuy_list.msg_count.myself}</span></a></li>
		<li class="{if $groupbuy_list.filter.ruidval eq '2'}active{/if}"><a class="data-pjax" href='{url path="groupbuy/admin/init" args="ruidval=2"}'>入驻商<span class="badge badge-info">{$groupbuy_list.msg_count.other}</span></a></li>
	</ul>
	<!-- </div> -->
	<!-- </div> -->
<!--  {/if} -->
	
<!-- 批量操作和搜索 -->
<div class="row-fluid batch" >
	<form method="post" action="{$search_action}" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{t}批量操作{/t}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='groupbuy/admin/batch'}" data-msg="您确定要这么做吗？" data-noSelectMsg="请先选中要删除的团购商品！" data-name="act_id" href="javascript:;"><i class="fontello-icon-trash"></i>{t}删除团购{/t}</a></li>
			</ul>
		</div>
		<div class="choose_list f_r" >
			<input type="text" name="keywords" value="{$groupbuy_list.filter.keywords}" placeholder="请输入团购商品名称"/>
			<button class="btn search_groupgoods" type="button">{t}搜索{/t}</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<form method="POST" action="{$form_action}" name="listForm">
			<table class="table table-striped smpl_tbl dataTable table-hide-edit">
				<thead>
					<tr>
						<th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
						<th class="w350">{t}商品名称{/t}</th>
				    	<th class="w100">{t}保证金{/t}</th>
				    	<th class="w100">{t}限购{/t}</th>
				    	<th class="w100">{t}订购商品{/t}</th>
				    	<th class="w100">{t}订单{/t}</th>
				    	<th class="w100">{t}当前价格{/t}</th>
				    	<th class="w100">{t}结束时间{/t}</th>
				    	<th class="w100">{t}状态{/t}</th>
	                </tr>
				</thead>
				<tbody>
					<!-- {foreach from=$groupbuy_list.groupbuy item=list} -->
					<tr>
						<td>
							<span><input type="checkbox" name="checkboxes[]" class="checkbox" value="{$list.act_id}"/></span>
						</td>
						<td class="hide-edit-area">
							{$list.goods_name}<br>
							<!--  {if $priv_ru eq 1} -->
								{if $list.user_name}
      								<font style="color:#F00;">
      								来自于{$list.user_name}
      								</font>
      							{else}
								<font style="color:#0e92d0;">
									来自于{t}自营{/t}
									</font>
	      						{/if}
      							<!--  {/if} -->
							<div class="edit-list">
							{assign var=edit_url value=RC_Uri::url('groupbuy/admin/edit',"id={$list.act_id}")}
							<a class="data-pjax" href="{$edit_url}" title="{t}编辑{/t}">{t}编辑{/t}</a>&nbsp;|&nbsp;
							<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{t}您确定要删除团购商品[{$list.goods_name}]吗？{/t}" href='{RC_Uri::url("groupbuy/admin/remove","id={$list.act_id}")}' title="{t}删除{/t}">{t}删除{/t}</a> 
							</div>
						</td>
						<td>{$list.deposit}</td>
						<td>{$list.restrict_amount}</td>
						<td>{$list.valid_goods}</td>
						<td>{$list.valid_order}</td>
						<td>{$list.cur_price}</td>
						<td>{$list.end_time}</td>
						<td>{$list.cur_status}</td>
					</tr>
					<!-- {foreachelse} -->
					<tr><td class="no-records" colspan="10">{t}没有找到任何记录{/t}</td></tr>
				<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$groupbuy_list.page} -->
		</form>
	</div>
</div>
<!-- {/block} -->