@extends('layout')

@section('style')
    <style>
        .title {
            margin: 10px 0;
        }
        .table {
            display: grid;
            grid-template-columns: 100px 100px 1fr 100px 100px 100px;
        }
        .table .table-cell {
            border-bottom: 1px solid #bebebe;
            padding: 8px;
        }
        .table .table-cell:nth-child(-n+6) {
            border-top: 1px solid #bebebe;
        }
    </style>
@endsection
@section('main')
    <div class="table">
        <div class="table-cell">名称</div>
        <div class="table-cell">作者</div>
        <div class="table-cell">描述</div>
        <div class="table-cell">版本</div>
        <div class="table-cell">状态</div>
        <div class="table-cell">操作</div>
        @foreach($modules as $i => $module)
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
    </div>
@endsection
