@extends('layouts.app')

@section('content')

<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto">掲示板投稿一覧</p>

    <!-- 投稿内容を繰り返して表示 -->
    @foreach($posts as $post)
    <!-- コントローラの記述により、posts変数には絞り込まれた必要な投稿のデータが入っている -->
    <div class="post_area border w-75 m-auto p-3">
      <!-- ユーザ名 -->
      <!-- userメソッドが呼び出して、リレーション先の値を取得する -->
      <p><span>{{ $post->user->username }}</span>さん</p>
      <!-- 投稿時間 -->
      <p><span>{{ $post->created_at}}</span>
      <!-- 閲覧数 -->
      <!-- (;'∀')ここに閲覧数を表示 -->
      <!-- タイトル -->
      <p class="bold"><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->title }}</a></p>
      <!-- postのidをGET送信で送る -->
      <!-- タイトルは詳細画面へリンクになっている -->


        <!-- サブカテゴリ -->
        <p><span class="category_btn">{{ $post->subCategory->sub_category }}</span></p>

          <!-- コメント数 -->
        <div class="d-flex post_status">
          <div class="mr-5"><i class="fa fa-comment"></i>
            <!-- Postモデルのメソッドを使用 -->
            <span class="">{{ $post->postComments ->count()}}</span>
          </div>
          <!-- いいね数 -->
          <!-- jsにて実装 -->
          <!-- post_idでポスト送信し、コントローラで受けとる -->
          <div class="mr-6">
            @if(Auth::user()->is_Like($post->id))
            <!-- ログインしているユーザがその投稿をいいねしている場合 -->
            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $post->likes->count() }}</span></p>
            <!-- iタグで囲った部分にいいねアイコンを設置 -->
            <!-- 続いてjsに送信するデータを記述 -->
            @else
            <!-- ログインしているユーザがその投稿をいいねしていない場合 -->
            <p class="m-0"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $post->likes->count() }}</span></p>
            @endif
          </div>
        </div>
    </div>
    @endforeach
  </div>

  <div class="other_area border w-25">
    <div class="border m-4">
      <!-- カテゴリ追加画面へ -->
      <div class="post_btn"><a href="{{ route('category.create') }}">カテゴリを追加</a></div>
      <!-- 新規投稿画面へ -->
      <div class="post_btn"><a href="{{ route('post.input') }}">投稿</a></div>

      <!-- 検索 -->
      <div class="post_btn d-flex justify-content-between">
        <form action="{{ route('top') }}" method="get">
          <!-- inputタグに入力されたテキストをget送信する→ルーティングのURLパラメータで受け取る→コントローラで絞り込みの処理をする -->
          <input type="text" placeholder="キーワードを検索" name="keyword">
          <input type="submit" value="検索">
          @csrf
        </form>
      </div>

      <div class="d-flex justify-content-between">
        <!-- いいねした投稿に絞る -->
        <input type="submit" name="like_posts" class="pink" value="いいねした投稿" form="postSearchRequest">
        <!-- 自分の投稿に絞る -->
        <input type="submit" name="my_posts" class="yellow" value="自分の投稿" form="postSearchRequest">
      </div>
      <ul>
      <!-- カテゴリで投稿を絞る -->
      <h5>カテゴリ検索</h5>
        @foreach($categories as $category)
        <li class="main_categories acMenu" category_id="{{ $category->id }}">
          <dt><h5>{{ $category->main_category }}</h5></dt>
          <!-- メインカテゴリ -->
          <dd>
            @foreach($category->subCategories as $subcategory)
              <!-- ここのnameで判別して送る -->
              <input type="submit" name="category_word" class="" value=" {{ $subcategory->sub_category }}" form="postSearchRequest">
            @endforeach
          </dd>
          <!-- サブカテゴリ -->
        </li>
        @endforeach
      </ul>
    </div>
  </div>

  <!-- なにこのふぉーむ(;'∀')？？？？？ -->
  <form action="{{ route('top') }}" method="get" id="postSearchRequest"></form>
</div>
@endsection