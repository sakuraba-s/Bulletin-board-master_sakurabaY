@extends('layouts.app')

@section('content')
<div class="post_create_container d-flex">
  <div class="post_create_area border w-50 m-5 p-5">

<!-- サブカテゴリー追加 -->
      <div class="">
        <!-- バリデーション -->
        @if($errors->first('sub_category_name'))
        <span class="error_message">{{ $errors->first('sub_category_name') }}</span>
        @endif
        <p class="m-0 mt-4">サブカテゴリー</p>
        <select class="w-100 box" form="subCategoryRequest" name="main_category_id">
          @foreach($main_categories as $main_category)
          <option value="{{ $main_category->id}}">{{ $main_category->main_category}}</option>
          @endforeach
        </select>

        <input type="text" class="w-100 box" name="sub_category_name" form="subCategoryRequest">
        <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="subCategoryRequest">
        <form action="{{ route('sub.category.create') }}" method="post" id="subCategoryRequest">{{ csrf_field() }}</form>
        
      </div>
      </div>
  </div>
  @endcan
</div>
@endsection