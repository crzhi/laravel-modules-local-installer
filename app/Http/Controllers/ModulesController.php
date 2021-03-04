<?php


namespace App\Http\Controllers;
use Nwidart\Modules\Facades\Module;
use Illuminate\Http\Request;


class ModulesController
{
    public function index()
    {
        $modules = Module::all();
        return view('index', compact('modules'));
    }

    /**
     * 上传插件
     * @param Request $request
     * @param string $name 插件标识
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function upload(Request $request)
    {
        if($request->hasFile('file')&&$request->file('file')->isValid()){
            $file=$request->file('file');
            if ($file->getClientOriginalExtension() !== "zip") {
                return redirect('/')->with('error', '请上传zip格式的压缩包！');
            }else{
                $destinationPath = 'storage/uploads/';
                $extension = $file->getClientOriginalExtension();
                $fileName=md5(time().rand(1,1000)).'.'.$extension;
                $file->move($destinationPath,$fileName);
                $filePath = asset($destinationPath.$fileName);
                dd("文件路径：".asset($destinationPath.$fileName));
            }
        }else{
            return redirect('/')->with('error', '没有可上传的插件，请重试！');
        }
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
