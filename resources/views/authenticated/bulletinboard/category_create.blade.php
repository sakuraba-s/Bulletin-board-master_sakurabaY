@extends('layouts.app')

@section('content')
<div class="post_create_container d-flex">
    <div class="post_create_area border w-50 m-5 p-5">

        <!-- 新規メインカテゴリー追加 -->
        <div class="">
            <!-- バリデーション -->
            @if($errors->first('main_category_name'))
                <span class="error_message">{{ $errors->first('main_category_name') }}</span>
            @endif
            <p class="m-0 mt-4">新規メインカテゴリー</p>

            <form action="{{ route('main.category.create') }}" method="post">
                <input type="text" class="w-100 box" name="main_category_name">
                <input type="submit" value="登録" class="w-100 btn btn-primary p-0">
                @csrf
            </form>
        </div>
        <!-- 新規サブカテゴリー追加 -->
        <div class="">
            <!-- バリデーション -->
            @if($errors->first('sub_category_name'))
                <span class="error_message">{{ $errors->first('sub_category_name') }}</span>
            @endif
            <p class="m-0 mt-4">新規サブカテゴリー</p>
            <form action="{{ route('sub.category.create') }}" method="post">
                <!-- メインカテゴリを選択 -->
                <select class="w-100 box" name="main_category_id">
                    @foreach($main_categories as $main_category)
                    <option value="{{ $main_category->id}}">{{ $main_category->main_category}}</option>
                    @endforeach
                </select>
                <input type="text" class="w-100 box" name="sub_category_name">
                <input type="submit" value="登録" class="w-100 btn btn-primary p-0">
                @csrf
            </form>
        </div>

        <p class="w-75 m-auto">カテゴリ一覧</p>
        @foreach($main_categories as $main_category)
        <optgroup label="{{ $main_category->main_category }}"></optgroup>
            @foreach($main_category->subCategories as $subcategory)
            <option value="{{ $subcategory->id}}">{{ $subcategory->sub_category }}</option>
            @endforeach
        @endforeach


    </div>
</div>
@endsection