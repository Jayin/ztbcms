<div class="table-responsive">
   <form id="op" action="{:U('Comment/ask_handle')}" method="post">
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <td style="width: 1px;" class="text-center">
                <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);">
            </td>
            <td class="text-center">
                用户
            </td>
            <td class="text-center">
                咨询内容
            </td>
            <td class="text-center">
                商品
            </td>
            <td class="text-center">
                显示
            </td>
      <td class="text-center">
                咨询类型
            </td>
            <td class="text-center">
                咨询时间
            </td>

            <td class="text-center">操作</td>
        </tr>
        </thead>
        <tbody>
        <volist name="comment_list" id="list">
            <tr>
                <td class="text-center">
                    <input type="checkbox" name="selected[]" value="{$list.id}">
                </td>
                <td class="text-center">{$list.username}</td>
                <td class="text-left">{$list.content}</td>
                <td class="text-left">
                <!--<a target="_blank" href="{:U('Home/Goods/goodsInfo',array('id'=>$list[goods_id]))}">{$goods_list[$list[goods_id]]}</a>-->
                {$goods_list[$list[goods_id]]}
                </td>
                <td class="text-center">
                    <img width="20" height="20" src="{$config_siteurl}statics/shop/images/<if condition='$list[is_show] eq 1'>yes.png<else />cancel.png</if>" onclick="changeTableVal('goods_consult','id','{$list.id}','is_show',this)"/>
                </td>
                <td class="text-center">{$consult_type[$list[consult_type]]}</td>
				<td class="text-center">{$list.add_time|date='Y-m-d H:i:s',###}</td>
                <td class="text-center">
                    <a href="{:U('Comment/consult_info',array('id'=>$list[id]))}" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="编辑"><i class="fa fa-eye"></i></a>
                    <!--
                    <a href="javascript:void(0);" data-href="{:U('Comment/ask_handle',array('id'=>$list[id]))}" onclick="del('{$list[id]}',this)" id="button-delete6" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="删除"><i class="fa fa-trash-o"></i></a>
                    -->
                </td>
            </tr>
        </volist>

        </tbody>
    </table>
    <select name="type" id="operate">
        <option value="0">操作选择</option>
        <option value="show">显示</option>
        <option value="hide">隐藏</option>
        <option value="del">删除</option>
    </select>
    <button  type="submit">确定</button>        
    </form>
</div>
<div class="row">
    <div class="col-sm-6 text-left"></div>
    <div class="col-sm-6 text-right">{$page}</div>
</div>
<script>
    $(".pagination  a").click(function(){
        var page = $(this).data('p');
        ajax_get_table('search-form2',page);
    });
</script>