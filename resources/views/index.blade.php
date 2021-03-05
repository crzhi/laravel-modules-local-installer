<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>插件市场</title>
    <style>
        body{
            font-size: 10px;
        }
        * {
            margin: 0;
        }
        a {
            color: #72beff;
        }
        .navbar {
            max-width: 100%;
            width: 900px;
            margin: 40px auto 20px;
        }
        .nav {
            font-size: 1.5rem;
            color: #1365ad;
            text-decoration: none;
        }
        .main {
            max-width: 100%;
            width: 900px;
            margin: 20px auto;
        }
        .upload {
            position: relative;
            width: 80px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            border-radius: 3px;
            background: #72beff;
            cursor: pointer;
            outline: none;
            color: white;
            font-size: 17px;
            float: right;
        }
        .upload:hover {
            background: #5599FF;
        }
        .btn{
            width: 80px;
            height: 30px;
            cursor: pointer;
            position: absolute;
            font-size: 18px;
            right: 0;
            top: 0;
            opacity: 0;
            padding-left: 0;
        }
        .title {
            margin: 10px 0;
        }
        .table {
            display: grid;
            grid-template-columns: 100px 100px 100px 1fr 100px 100px 100px;
        }
        .table .table-cell {
            border-bottom: 1px solid #bebebe;
            padding: 8px;
        }
        .table .table-cell:nth-child(-n+7) {
            border-top: 1px solid #bebebe;
        }
    </style>
</head>
<body>
<header>
    <div class="navbar">
        <a href="{{ route('modules.index') }}" class="nav">插件列表</a>
        <form action="{{ route('modules.upload') }}" method="post" enctype="multipart/form-data" style="display: inline">
            {{csrf_field()}}
            <span class="upload">上传插件<input type="file" name="file" id="upload-input" class="btn"></span>
            <button type="submit" id="submit" style="display: none"></button>
        </form>
    </div>
</header>
<main class="main">
    <div class="table">
        <div class="table-cell">插件</div>
        <div class="table-cell">文件夹</div>
        <div class="table-cell">作者</div>
        <div class="table-cell">描述</div>
        <div class="table-cell">版本</div>
        <div class="table-cell">状态</div>
        <div class="table-cell">操作</div>
        @foreach($modules as $i => $module)
            <div class="table-cell">{{ $module->get('alias') }}</div>
            <div class="table-cell">{{ $module->getName() }}</div>
            <div class="table-cell">{{ $module->get('author') }}</div>
            <div class="table-cell">{{ $module->getDescription() }}</div>
            <div class="table-cell">{{ $module->get('version') }}</div>
            <div class="table-cell">
                @if($module->isEnabled())
                    <a href="/{{ $module->getLowerName() }}" target="_blank"><span style="color: green">启用</span></a>
                @endif
                @if($module->isDisabled())
                    <span style="color: red">未启用</span>
                @endif
            </div>
            <div class="table-cell">
                @if($module->isEnabled())
                    <a href="{{ route('modules.disable', ['name' => $module->getName()]) }}">禁用</a>
                @endif
                @if($module->isDisabled())
                    <a href="{{ route('modules.enable', ['name' => $module->getName()]) }}">启用</a>
                    <a href="{{ route('modules.remove', ['name' => $module->getName()]) }}">卸载</a>
                @endif
            </div>
        @endforeach
    </div></main>
<footer></footer>
<script src="/statics/js/coco-message.js"></script>
<script>
    @if (Session::has('success'))
        cocoMessage.success(3000, "{{ Session::get('success') }}");
    @endif
    @if (Session::has('error'))
        cocoMessage.error(3000, "{{ Session::get('error') }}");
    @endif
    var upload = document.getElementById('upload-input');
    upload.oninput = function() {
        // var fileType = this.files[0].type;
        // if(fileType !== 'application/x-zip-compressed'){
        //     cocoMessage.error(1500, "请上传zip格式的压缩包！");
        //     return;
        // }
        document.getElementById('submit').click();
    }
</script>
</body>
</html>
