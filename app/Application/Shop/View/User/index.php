<include file="Public/min-header"/>
<div class="wrapper">
  <include file="Public/breadcrumb"/>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-list"></i> 用户列表</h3>
                </div>
                <div class="panel-body">
                    <div class="navbar navbar-default">
                            <form action="" id="search-form2" class="navbar-form form-inline" method="post" onsubmit="return false">
                                <div class="form-group">
                                    <label class="control-label" for="input-mobile">手机号码</label>
                                    <div class="input-group">
                                        <input type="text" name="mobile" value="" placeholder="手机号码" id="input-mobile" class="form-control">
                                        <!--<span class="input-group-addon" id="basic-addon2"><i class="fa fa-search"></i></span>-->
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="input-email">email</label>
                                    <div class="input-group">
                                        <input type="text" name="email" value="" placeholder="email" id="input-email" class="form-control">
                                        <!--<span class="input-group-addon" id="basic-addon2"><i class="fa fa-search"></i></span>-->
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <input type="hidden" name="order_by" value="userid">
                                	<input type="hidden" name="sort" value="desc">
                                	<button type="submit" onclick="ajax_get_table('search-form2',1)" id="button-filter search-order" class="btn btn-primary pull-right"><i class="fa fa-search"></i> 筛选</button>
                                 </div>
                                <button type="button" onclick="send_message(0);" class="btn btn-primary"><i class="fa"></i> 发送站内信</button>
                                <!--<button type="button" onclick="send_mail(0);" class="btn btn-primary"><i class="fa"></i> 发送邮箱</button>-->
								 <a href="{:U('User/add_user')}" class="btn btn-info pull-right">添加会员</a>
                            </form>
                    </div>
                    <div id="ajax_return">

                    </div>
                </div>
            </div>
        </div>        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    $(document).ready(function(){
        ajax_get_table('search-form2',1);

    });

    // ajax 抓取页面
    function ajax_get_table(tab,page){
        cur_page = page; //当前页面 保存为全局变量
            $.ajax({
                type : "POST",
                url:"{:U('Shop/User/ajaxindex')}&p="+page,//+tab,
                data : $('#'+tab).serialize(),// 你的formid
                success: function(data){
                    $("#ajax_return").html('');
                    $("#ajax_return").append(data);
                }
            });
    }

    // 点击排序
    function sort(field)
    {
        $("input[name='order_by']").val(field);
        var v = $("input[name='sort']").val() == 'desc' ? 'asc' : 'desc';
        $("input[name='sort']").val(v);
        ajax_get_table('search-form2',cur_page);
    }

    //发送站内信
    function send_message(id)
    {
        var obj = $("input[name*='selected']");
        var url = "{:U('User/sendMessage')}";
        if(obj.is(":checked")){
            var check_val = [];
            for(var k in obj){
                if(obj[k].checked)
                    check_val.push(obj[k].value);
            }
            url += "&user_id_array="+check_val;
        }
        layer.open({
            type: 2,
            title: '站内信',
            shadeClose: true,
            shade: 0.8,
            area: ['580px', '480px'],
            content: url
        });
    }

    //发送邮件
    function send_mail(id)
    {
        var obj = $("input[name*='selected']");
        var url = "{:U('User/sendMail')}";
        if(obj.is(":checked")){
            var check_val = [];
            for(var k in obj){
                if(obj[k].checked)
                    check_val.push(obj[k].value);
            }
            url += "&user_id_array="+check_val;
            layer.open({
                type: 2,
                title: '发送邮箱',
                shadeClose: true,
                shade: 0.8,
                area: ['580px', '480px'],
                content: url
            });
        }else{
            layer.msg('请选择会员');
        }

    }

    /**
     * 回调函数
     */
    function call_back(v) {
        layer.closeAll();
        if (v == 1) {
            layer.msg('发送成功');
        } else {
            layer.msg('发送失败');
        }
    }


</script>
</body>
</html>