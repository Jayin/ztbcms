
                    <form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:sort_list('order_sn');">订单编号</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0);">商品名称</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:sort_list('type');">类型</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:sort_list('addtime');">申请日期</a>
                                    </td>
                                    <td class="text-center"><a href="javascript:void(0);">状态</a></td>
                                    <td class="text-center">操作</td>
                                </tr>
                                </thead>
                                <tbody>
                                <volist name="list" id="items">
                                    <tr>
                                        <td class="text-center"><a href="{:U('Shop/Order/detail',array('order_id'=>$items['order_id']))}">{$items.order_sn}</a></td>
                                        <td class="text-center">{$goods_list[$items['goods_id']]|getSubstr=0,50}</td>
                                        <td class="text-center">
                                        	<if condition="$items[type] eq 0">退货</if>
                                        	<if condition="$items[type] eq 1">换货</if>                                            
                                        </td>
                                        <td class="text-center">{$items.addtime|date='Y-m-d H:i',###}</td>
                                        <td class="text-center">
                                        	<if condition="$items[status] eq 0">未处理</if>
                                        	<if condition="$items[status] eq 1">处理中</if>
                                        	<if condition="$items[status] eq 2">已完成</if>                                        
                                        </td>
                                        <td class="text-center">
                                            <a href="{:U('Shop/Order/return_info',array('id'=>$items['id']))}" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="查看详情"><i class="fa fa-eye"></i></a>
                                            <!--<a href="javascript:void(0);" onclick="if(confirm('确定要删除吗?')) location.href='{:U('Shop/Order/return_del',array('id'=>$items['id']))}';" id="button-delete6" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="删除"><i class="fa fa-trash-o"></i></a>-->
                                            </td>
                                    </tr>
                                </volist>
                                </tbody>
                            </table>
                        </div>
                    </form>
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