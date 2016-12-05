<include file="Public/min-header"/>
<div class="wrapper">
    <include file="Public/breadcrumb"/>
    <section class="content">
        <!-- Main content -->
        <div class="container-fluid">
            <div class="pull-right">
                <a href="javascript:history.go(-1)" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="返回"><i class="fa fa-reply"></i></a>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-list"></i> 品牌详情</h3>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_tongyong" data-toggle="tab">商品类型</a></li>
                    </ul>
                    <!--表单数据-->
                    <form method="post" id="addEditBrandForm" onsubmit="return checkName();">             
                        <!--通用信息-->
                    <div class="tab-content">                 	  
                        <div class="tab-pane active" id="tab_tongyong">
                           
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td>品牌名称:</td>
                                    <td>
                                        <input type="text" value="{$brand.name}" name="name" class="form-control" style="width:200px;"/>
                                        <span id="err_name" style="color:#F00; display:none;">品牌名称不能为空</span>                                        
                                    </td>
                                </tr>                                
                                <tr>
                                    <td>品牌网址:</td>
                                    <td>
                                        <input type="text" value="{$brand.url}" name="url" class="form-control" style="width:250px;"/>
                                        <span id="err_url" style="color:#F00; display:none;"></span>                                        
                                    </td>
                                </tr>                                                                
                                <tr>
                                    <td>所属分类:</td>
                                    <td>
                                        <div class="col-sm-3">
	                                        <select name="parent_cat_id" id="parent_id_1" onchange="get_category(this.value,'parent_id_2','0');" class="form-control" style="width:250px;margin-left:-15px;">
                                                    <option value="0">请选择分类</option> 
	                                            <foreach name="cat_list" item="v" >	                                                                                    
	                                                <option value="{$v[id]}"  <if condition="$v[id] eq $brand[parent_cat_id]"> selected="selected" </if>>{$v[name]}</option>
	                                            </foreach>                                            
						</select>
	                                    </div>                                    
	                                    <div class="col-sm-3">
	                                      <select name="cat_id" id="parent_id_2"  class="form-control" style="width:250px;">
	                                        <option value="0">请选择分类</option>
	                                      </select>  
	                                    </div>     
                                    </td>
                                </tr>                                
                                <tr>
                                    <td>品牌logo:</td>
                                    <td>  
                                    	<div class="col-sm-3">                                                                              
                                        	<input type="text" value="{$brand.logo}" name="logo" id="logo" class="form-control" style="width:350px;margin-left:-15px;"/>
                                        </div>
                                        <div class="col-sm-3">
                                        	<input onclick="GetUploadify(1,'logo','brand');" type="button" class="btn btn-default" value="上传logo"/>
                                        </div>
                                    </td>
                                </tr> 
                                <tr>
                                    <td>品牌排序:</td>
                                    <td>
                                        <input type="text" value="{$brand.sort}" name="sort" class="form-control" style="width:200px;" placeholder="50"/>                                
                                    </td>
                                </tr>                                                                 
                                <tr>
                                    <td>品牌描述:</td>
                                    <td>
										<textarea rows="4" cols="60" name="desc">{$brand.desc}</textarea>
                                        <span id="err_desc" style="color:#F00; display:none;"></span>                                        
                                    </td>
                                </tr>                                  
                                </tbody>                                
                                </table>
                        </div>                           
                    </div>              
                    <div class="pull-right">
                        <input type="hidden" name="id" value="{$brand.id}">
                        <input type="hidden" name="p" value="{$_GET[p]}">
                        <button class="btn btn-primary" data-toggle="tooltip" type="submit" data-original-title="保存">保存</button>
                    </div>
			    </form><!--表单数据-->
                </div>
            </div>
        </div>    <!-- /.content -->
    </section>
</div>
<script>
// 判断输入框是否为空
function checkName(){
	var name = $("#addEditBrandForm").find("input[name='name']").val();
    if($.trim(name) == '')
	{
		$("#err_name").show();
		return false;
	}
	return true;
}

window.onload = function(){
	if({$brand.cat_id} > 0 ){
		get_category($("#parent_id_1").val(),'parent_id_2',{$brand.cat_id});	 
	}		
}
</script>
</body>
</html>