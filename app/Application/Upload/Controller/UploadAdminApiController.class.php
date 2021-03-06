<?php
/**
 * User: jayinton
 * Date: 2019/3/5
 * Time: 14:55
 */

namespace Upload\Controller;


use Admin\Controller\AdminApiBaseController;
use Admin\Service\User;
use Attachment\Model\AttachmentModel;
use Upload\Service\WatermarkService;

/**
 * 后台上传管理接口
 * @package Upload\Controller
 */
class UploadAdminApiController extends AdminApiBaseController
{

    const isadmin = 1; //后台上传

    //模块
    const MODULE_IMAGE = 'module_upload_images';
    const MODULE_FILE = 'module_upload_files';

    /**
     * @param $module  string 文件所属模块
     * @return array
     */
    private function _upload($module)
    {
        if (IS_POST) {
            //回调函数
            $Callback = false;
            $userInfo = User::getInstance()->getInfo();
            $upuserid = $userInfo['id'];
            //取得栏目ID
            $catid = I('post.catid', 0, 'intval');
            //获取附件服务
            $Attachment = service("Attachment", array('module' => $module, 'catid' => $catid, 'isadmin' => self::isadmin, 'userid' => $upuserid));

            //开始上传
            $info = $Attachment->upload($Callback);
            if ($info) {
                $data = [
                    'name' => $info[0]['name'],//名称
                    'type' => $info[0]['type'],//类型 eg:image/png
                    'size' => $info[0]['size'],// 容量,单位 byte eg: 1KB=1024byte
                    'extension' => $info[0]['extension'],// eg:png
                    'savepath' => $info[0]['savepath'],// eg:"/root/project/ztbcms/d/file/module_upload_images/2019/09/"
                    'savename' => $info[0]['savename'],// eg:image/png
                    'hash' => $info[0]['hash'],// hash
                    'aid' => $info[0]['aid'],// 附件ID
                    'url' => $info[0]['url'],//上传文件路径, e.g: http://ztbcms.biz:8888/d/file/module_upload_images/2019/09/5d89d09186329.jpeg 、 或 /d/file/module_upload_images/2019/09/5d89d09186329.jpeg
                ];
                return self::createReturn(true, $data, '上传成功');
            } else {
                //上传失败，返回错误
                $msg = $Attachment->getErrorMsg();
                $msg = empty($msg) ? '上传失败' : $msg;
                return self::createReturn(false, null, $msg);
            }
        } else {
            return self::createReturn(false, null, '上传失败');
        }
    }

    /**
     * 上传图片
     */
    function uploadImage()
    {
        $watermark_enable = I('enable', 0);
        $result = $this->_upload(self::MODULE_IMAGE);
        if (!$result['status']) {
            $this->ajaxReturn($result);
            return;
        }
        $upload_file_info = $result['data'];
        //处理水印
        //是否添加水印
        if($watermark_enable == WatermarkService::ENABLE_YES){
            $watermarkService = new WatermarkService();
            $watermark_config = $watermarkService->getWatermarkConfig()['data'];
            $source_image_path = $upload_file_info['url'];
            $save_image_path = $upload_file_info['savepath'] . $upload_file_info['savename'];
            $watermarkService->addWaterMark($source_image_path, $save_image_path, $watermark_config);
        }
        $this->ajaxReturn($result);

    }

    /**
     * 批量删除文件
     */
    function deleteFiles()
    {
        $files = I('post.files');
        $db = M('Attachment');
        foreach ($files as $file) {
            $db->where(['aid' => ['EQ', $file['aid']]])->save(['delete_status' => AttachmentModel::DELETE_STATUS_YES]);
        }
        $this->ajaxReturn(self::createReturn(true, null, '操作成功'));
    }

    /**
     * 上传文件
     */
    function uploadFile()
    {
        $result = $this->_upload(self::MODULE_FILE);
        $this->ajaxReturn($result);
    }

    /**
     * 获取图像
     */
    function getGalleryList()
    {
        $page = I('page', 1);
        $limit = I('limit', 20);
        $userInfo = User::getInstance()->getInfo();
        $userid = $userInfo['id'];

        $db = M('Attachment');
        $where = [
            'module' => self::MODULE_IMAGE,
            'userid' => $userid,
            'isadmin' => 1,
            'delete_status' => AttachmentModel::DELETE_STATUS_NO
        ];
        $total_items = $db->where($where)->count();
        $total_page = ceil($total_items / $limit);
        $list = $db->where($where)->page($page)->limit($limit)->order(array("uploadtime" => "DESC"))->select();

        $return_list = [];
        foreach ($list as $index => $item) {
            $return_list [] = [
                'aid' => $item['aid'],
                'name' => $item['filename'],
                'url' => cache('Config.sitefileurl') . $item['filepath'],
                'filepath' => $item['filepath'],
            ];
        }

        $this->ajaxReturn($this->createReturnList(true, $return_list, $page, $limit, $total_items, $total_page));
    }

    /**
     * 获取水印配置
     */
    function getWatermarkConfig(){
        $system_configs = M('Config')->where([
            'varname' => ['IN', 'watermarkenable,watermarkminwidth,watermarkminheight,watermarkimg,watermarkpct,watermarkquality,watermarkpos']
        ])->select();
        $config = [];
        foreach ($system_configs as $i => $v) {
            $config[$v['varname']] = $v['value'];
        }
        $this->ajaxReturn(self::createReturn(true, $config));
    }

    /**
     * 保存水印配置
     */
    function saveWatermarkConfig(){
        $post = I('post.');

        $fileds = ['watermarkenable','watermarkminwidth','watermarkminheight','watermarkimg','watermarkpct','watermarkquality','watermarkpos'];
        foreach ($post as $key => $value){
            if(in_array($key, $fileds)){
                M('Config')->where(['varname' => $key])->save(['value' => $value]);
            }
        }

        $this->ajaxReturn(self::createReturn(true, null, '操作完成'));
    }
}