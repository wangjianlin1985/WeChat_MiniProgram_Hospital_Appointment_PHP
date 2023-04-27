<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function uploadImg(Request $request)
    {
        $json = null;
        // 获取上传的文件对象
        $pic = $request->file('imageFile');
        if($pic){
            //dump($pic);
            //上传文件夹的路径
            $dirname = "/public/static/uploads/";
            $entension = $pic->getClientOriginalExtension();//上传文件的后缀
            $newName = date('YmdHis').mt_rand(100,900).'.'.$entension;//设置图片上传之后的名字。
            $fileName = "/static/uploads/".$newName;//文件路径，存放数据库
            $newPath = base_path().$dirname.$newName;//存储文件绝对路径
            $flag = move_uploaded_file($pic,$newPath);///PHP原生函数，存储文件到指定位置
            if ($flag){
                $json = $this->successJson($fileName);
            }else{
                $json = $this->failJson('上传过程发生异常');
            }
        }else{
            $json = $this->failJson('上传图片不能为空');
        }
        return response()->json($json);

    }

    public function uploadFile(Request $request)
    {
        $json = null;
        // 获取上传的文件对象
        $file = $request->file('file');
        if($file){
            //dump($file);
            //上传文件夹的路径
            $dirname = "/public/static/uploads/";
            $entension = $file->getClientOriginalExtension();//上传文件的后缀
            $newName = date('YmdHis').mt_rand(100,900).'.'.$entension;//设置文件上传之后的名字。
            $fileName = "/static/uploads/".$newName;//文件路径，存放数据库
            $newPath = base_path().$dirname.$newName;//存储文件绝对路径
            $flag = move_uploaded_file($file,$newPath);///PHP原生函数，存储文件到指定位置
            if ($flag){
                $json = $this->successJson($fileName);
            }else{
                $json = $this->failJson('上传过程发生异常');
            }
        }else{
            $json = $this->failJson('上传文件不能为空');
        }
        return response()->json($json);

    }
}
