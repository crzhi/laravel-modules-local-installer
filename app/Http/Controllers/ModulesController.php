<?php

namespace App\Http\Controllers;

use Chumper\Zipper\Facades\Zipper;
use Nwidart\Modules\Facades\Module;
use Illuminate\Http\Request;


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
        $zipper->extractTo(base_path('/Modules/'));
        return redirect('/')->with('success', '上传成功');
    }

    /**
     * 启用插件
     * @param string $name 插件标识
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function enable($name)
    {
        $module = Module::find($name);
        $module->enable();
        return redirect('/')->with('success', '启用成功');
    }

    /**
     * 禁用插件
     * @param string $name 插件标识
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function disable($name)
    {
        $module = Module::find($name);
        $module->disable();
        return redirect('/')->with('success', '禁用成功');
    }

    /**
     * 卸载插件
     * @param string $name 插件标识
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function remove($name)
    {
        $module = Module::find($name);
        $module->delete();
        return redirect('/')->with('success', '卸载成功');
    }
}
