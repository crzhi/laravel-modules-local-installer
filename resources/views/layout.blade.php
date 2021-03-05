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
    </style>
    @yield('style')
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
<main class="main">@yield('main')</main>
<footer></footer>
<script src="/statics/js/coco-message.js"></script>
@if (Session::has('success'))
    <script>
        cocoMessage.success(3000, "{{ Session::get('success') }}");
    </script>
@endif
@if (Session::has('error'))
    <script>
        cocoMessage.error(3000, "{{ Session::get('error') }}");
    </script>
@endif
<script>
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
@yield('script')
</body>
</html>
