<?php

namespace App\Services\Erp\V1;

use Intervention\Image\Facades\Image;

class UploadService
{
    public function uploadHeadImage($request)
    {
        $dir = $request->input('dir');
        $height = $request->input('height');
        $width = $request->input('width');
        if (empty($width) || empty($height)) {
            $width = 150;
            $height = 150;
        }
        //判断文件在请求中是否存在
        if (!$request->hasFile('file')) {
            return ['code' => 1, 'msg' => '上传文件不存在'];
        }
        //验证文件是否上传成功
        if (!$request->file('file')->isValid()) {
            return ['code' => 1, 'msg' => '上传文件失败'];
        }
        $ext = $request->file->extension();
        $filename = date('YmdHis') . uniqid() . '.' . $ext;
        $savePath = empty($dir) ? 'images/' . date('YmdHis') : 'images/' . $dir . '/' . date('YmdHis');
        $path = $request->file->storeAs($savePath, $filename, 'public');
        // 修改指定图片的大小
        $imageUrl = storage_path('app/public') . '/' . $path;
        $img = Image::make($imageUrl);
        $img->fit($width, $height);
        $img->save($imageUrl);
        $img->destroy();
        return ['code' => 0, 'msg' => '上传成功', 'path' => '/storage/' . $path];
    }
}