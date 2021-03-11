<?php

namespace App\Http\Controllers;

use Chumper\Zipper\Facades\Zipper;
use Nwidart\Modules\Facades\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class ModulesController
{
    /**
     * 插件首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $modules = Module::all();
        return view('index', compact('modules'));
    }

    /**
     * 上传插件
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function upload(Request $request)
    {
        if(!$request->hasFile('file') || !$request->file('file')->isValid()){
            return redirect('/')->with('error', '没有可上传的插件，请重试！');
        }
        $file=$request->file('file');
        if ($file->getClientOriginalExtension() !== "zip") {
            return redirect('/')->with('error', '请上传zip格式的压缩包！');
        }
        $zipper = Zipper::make($file);
        if(!count($zipper->listFiles())) {
            return redirect('/')->with('error', '请勿上传空压缩包！');
        }
        $firstFileName = $zipper->listFiles()[0];
        if(!strpos($firstFileName, '/')) {
            return redirect('/')->with('error', '请勿上传单文件压缩包！');
        }
        $folder = substr($firstFileName,0,strrpos($firstFileName,'/'));
        if(Module::has($folder)) {
            return redirect('/')->with('error', '插件已存在，请勿重复上传！');
        }
        $zipper->extractTo(base_path('Modules'));
        $zipper->delete();
        if(!Module::has($folder)) {
            File::deleteDirectory(base_path('Modules/' . $folder . '/'));
            return redirect('/')->with('error', '不是一个有效的模块插件！');
        }
        return redirect('/')->with('success', '上传成功');
    }

    /**
     * 启用插件
     * @param string $name 插件标识
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function enable($name)
    {
        Module::find($name)->enable();
        return redirect('/')->with('success', '启用成功');
    }

    /**
     * 禁用插件
     * @param string $name 插件标识
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function disable($name)
    {
        Module::find($name)->disable();
        return redirect('/')->with('success', '禁用成功');
    }

    /**
     * 卸载插件
     * @param string $name 插件标识
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function remove($name)
    {
        Module::find($name)->delete();
        return redirect('/')->with('success', '卸载成功');
    }
}
