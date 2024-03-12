@extends('layouts.app')

@section('content')
<div class="post_create_container d-flex">
  <div class="post_create_area border w-50 m-5 p-5">

    <p class="w-75 m-auto">新規投稿画面</p>
    <div class="">
    <form action="{{ route('post.create') }}" method="post">
        <p class="mb-0">サブカテゴリー</p>
        <select class="w-100 box"  name="post_category_id">
          @foreach($main_categories as $main_category)
          <!-- ※ここのメインカテゴリはコントローラからもらった情報 -->
          <optgroup label="{{ $main_category->main_category }}"></optgroup>
            @foreach($main_category->subCategories as $subcategory)
              <!-- メインカテゴリのモデルに記載のリレーションを使ってサブカテゴリの情報にアクセスする
              ※サブカテゴリテーブルの中身の情報がサブカテゴリという変数の中に入っている状態 -->
              <option value="{{ $subcategory->id}}">{{ $subcategory->sub_category }}</option>

              <!-- メインカテゴリの下にサブカテゴリーを表示させる -->
              <!-- オプションタグで選択肢として表示 -->
              <!-- サブカテゴリテーブルの中身の情報がサブカテゴリという変数の中の、idカラムを取り出す -->
              <!-- サブカテゴリテーブルの中身の情報がサブカテゴリという変数の中の、sub_categoryカラムを取り出す -->
              <!-- ※バリューは選択項目の値
                    ※name属性で付けた名前と、選択されたvalue属性の値をセットにしてサーバへ送信
                    ※nameが取得するときの名札で、valueが取得される中身 -->
              <!-- ※白い二重カッコ内が選択項目の値-->
            @endforeach
          @endforeach
        </select>
        <div class="mt-3">

          <p class="mb-0">タイトル</p>
          <input type="text" class="w-100 box" name="post_title" value="{{ old('post_title') }}">
          @if($errors->first('post_title'))
            <span class="error_message">{{ $errors->first('post_title') }}</span>
          @endif
        </div>
        <div class="mt-3">
          <p class="mb-0">投稿内容</p>
          <textarea class="w-100" name="post_body">{{ old('post_body') }}</textarea>
          @if($errors->first('post_body'))
          <span class="error_message">{{ $errors->first('post_body') }}</span>
          @endif
        </div>
        <div class="mt-3 text-right">
          <input type="submit" class="btn btn-primary" value="投稿">
        </div>
          @csrf
      </form>
  </div>

  <!-- 権限に「教師」が含まれるユーザにだけ表示 -->
  @can('admin')
  <div class="w-25 ml-auto mr-auto">
    <div class="category_area mt-5 p-5">

      <div class="">
        <!-- バリデーション -->
        @if($errors->first('main_category_name'))
        <span class="error_message">{{ $errors->first('main_category_name') }}</span>
        @endif
        @if($errors->first('main_category_id'))
          <span class="error_message">{{ $errors->first('main_category_id') }}</span>
        @endif
        <p class="m-0">メインカテゴリー</p>
        <!-- formで最後のform actionのidと紐づける -->
        <input type="text" class="w-100 box" name="main_category_name" form="mainCategoryRequest">
        <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="mainCategoryRequest">
        <form action="{{ route('main.category.create') }}" method="post" id="mainCategoryRequest">{{ csrf_field() }}</form>
      </div>

    </div>
  </div>
  @endcan
</div>
@endsection