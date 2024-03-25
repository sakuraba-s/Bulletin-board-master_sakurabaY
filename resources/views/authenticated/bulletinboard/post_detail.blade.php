@extends('layouts.app')
@section('content')
<div class="vh-100 d-flex">
  <div class="w-50 mt-5">
    <div class="m-3 detail_container">
      <div class="p-3">

          <!-- 投稿の表示 -->
          <div class="contributor d-flex">
            <span>{{ $post->user->username }}</span>さん
            <span class="ml-5">{{ $post->updated_at }}</span>
          </div>
          <div class="contributor d-flex">
            <div class="detsail_post_title">{{ $post->title }}
            </div>

                <!-- ログインユーザのみ表示 削除ボタン編集ボタン-->
                @if(Auth::user()->id === $post->user_id)
                  <span class="edit-modal-open btn btn-primary" post_title="{{ $post->title }}" post_body="{{ $post->post }}" post_id="{{ $post->id }}" sub_category_id="{{ $post->sub_category_id }}" sub_categories="{{ $sub_categories}}">編集</span>
                  <span class="btn btn-primary  btn-danger"><a href="{{ route('post.delete', ['id' => $post->id]) }} "onclick="return confirm('削除してよろしいですか？');">削除</a></span>
                @endif
          </div>
          <div class="mt-3 detsail_post">{{ $post->post }}</div>

          <div>
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

            <!-- バリデーション -->
            <div>
              @if($errors->first('title'))
              <span class="error_message">{{ $errors->first('title') }}</span>
              @endif
              @if($errors->first('post_body'))
              <span class="error_message">{{ $errors->first('post_body') }}</span>
              @endif
            </div>
          </div>

          <!-- コメントを取得 Postテーブル→Post_commentテーブル→Userテーブル-->
        <div class="comment_container">
          <p class="">コメント</p>
          @foreach($post->postComments as $comment)
          <!-- 投稿にリレーションされたコメントデータを取得 -->
            <span>{{ $comment->commentUser($comment->user_id)->username }}</span>
            <!-- リレーション先のリレーション先の値を取るにはモデルで検索をしてfirstで値を取得する -->
            <!-- commentUser()でモデルにユーザidを引き渡す -->
              <!-- コメントの編集モーダルを開く -->
              @if(Auth::user()->id === $comment->user_id)
                <span class="comment-edit-modal-open btn btn-primary" comment="{{ $comment->comment }}" comment_id="{{ $comment->id }}" post_id="{{ $comment->post_id }}">編集</span>
                <span class="btn btn-primary  btn-danger"><a href="{{ route('comment.delete', ['id' => $comment->id,'post_id' => $post->id]) }} "onclick="return confirm('削除してよろしいですか？');">削除</a></span>
              @endif
            <p><span>{{ $comment->updated_at}}</span>
            <p>{{ $comment->comment }}</p>

              <!-- コメントに対するいいね数 -->
              <!-- jsにて実装 -->
              <!-- post_idでポスト送信し、コントローラで受けとる -->
              <div class="mr-6">
                @if(Auth::user()->is_PostCommentLike($comment->id))
                <!-- ログインしているユーザがそのコメントをいいねしている場合 -->
                <p class="m-0"><i class="fas fa-heart comment_un_like_btn" comment_id="{{ $comment->id }}"></i><span class="comment_like_counts{{ $comment->id }}">{{ $comment->comment_likes->count() }}</span></p>
                <!-- iタグで囲った部分にいいねアイコンを設置 -->
                <!-- 続いてjsに送信するデータを記述 -->
                @else
                <!-- ログインしているユーザがそのコメントをいいねしていない場合 -->
                <p class="m-0"><i class="fas fa-heart comment_like_btn" comment_id="{{ $comment->id }}"></i><span class="comment_like_counts{{ $comment->id }}">{{ $comment->comment_likes->count() }}</span></p>
                @endif
              </div>
          @endforeach


          <!-- コメント投稿 -->
          <div class="w-50 p-3">
            <div class="comment_container border m-5">
                <!-- コメントのバリデーション -->
                @if($errors->first('comment'))
                <span class="error_message">{{ $errors->first('comment') }}</span>
                @endif

                <form action="{{ route('comment.create') }}" method="post">
                  <input type="hidden" name="post_id" value="{{ $post->id }}">
                  <input type="text" class="w-100 box" name="comment">
                  <input type="submit" class="btn btn-primary" value="コメントする">
                @csrf
                </form>

            </div>
          </div>
      </div>

  </div>

</div>



<!-- 投稿の編集のモーダル機能 -->
<div class="modal js-modal">
  <div class="modal__bg js-modal-close"></div>
  <div class="modal__content">
    <!-- <form action="{{ route('post.edit') }}" method="post"> -->
    <form action="{{ route('post.edit') }}" method="post">
        <div class="w-100">

          <!-- jQueryでモーダルへ受け渡した値を当てはまる 目印は name -->
          <!-- サブカテゴリ -->
          <select class="modal-inner-category w-100 m-auto box" name="sub_category_id">
              @foreach($sub_categories as $sub_category)
              <!-- 変数「sub_categories」はコントローラからビューに渡しているので（モーダル内でも）使える -->
                <option value="{{$sub_category->id}}"
                @if($sub_category->id==$post->sub_category_id) selected @endif>
                {{ $sub_category->sub_category}}
                </option>
              @endforeach
          </select>

          <!-- valueは送信したときに渡すデータ その次に描いてあるのが画面に表示させたい文字-->

          <!-- タイトル -->
          <div class="modal-inner-title w-50 m-auto box">
            <input type="text" name="post_title" placeholder="タイトル" class="w-100">
          </div>

          <!-- 本文 -->
          <div class="modal-inner-body w-50 m-auto pt-3 pb-3 box">
            <textarea placeholder="投稿内容" name="post_body" class="w-100"></textarea>
          </div>

          <!-- 更新する投稿のidをhiddenで送信 -->
          <div class="w-50 m-auto edit-modal-btn d-flex">
            <a class="js-modal-close btn btn-danger d-inline-block" href="">閉じる</a>
            <input type="hidden" class="edit-modal-hidden" name="post_id" value="">
            <!-- value部分にjQueryでモーダルへ受け渡した値を当てはめる -->
            <!-- <input type="hidden" class="edit-modal-hidden" name="post_title" value="">
            <input type="hidden" class="edit-modal-hidden" name="post_body" value=""> -->
            <input type="submit" class="btn btn-primary d-block" value="編集">
          </div>
        </div>
          {{ csrf_field() }}
    </form>
  </div>
</div>
<!-- コメントの編集のモーダル機能 -->
<div class="modal js-comment-modal">
  <div class="modal__bg js-modal-close"></div>
  <div class="modal__content">
    <!-- <form action="{{ route('post.edit') }}" method="post"> -->
    <form action="{{ route('comment.edit') }}" method="post">
        <div class="w-100">
          <!-- jQueryでモーダルへ受け渡した値を当てはまる 目印は name -->
          <!-- 本文 -->
          
          <div class="modal-inner-body w-50 m-auto pt-3 pb-3 box">
            <textarea name="comment" class="w-100"></textarea>
          </div>

          <!-- 更新する投稿のidをhiddenで送信 -->
          <div class="w-50 m-auto edit-modal-btn d-flex">
            <a class="js-modal-close btn btn-danger d-inline-block" href="">閉じる</a>

            <input type="hidden" class="comment-modal-hidden" name="comment_id" value="">
            <input type="hidden" class="post-modal-hidden" name="post_id" value="">
            <!-- value部分にjQueryでモーダルへ受け渡した値を当てはめる -->
            <!-- <input type="hidden" class="edit-modal-hidden" name="post_title" value="">
            <input type="hidden" class="edit-modal-hidden" name="post_body" value=""> -->
            <input type="submit" class="btn btn-primary d-block" value="編集">
          </div>
        </div>
          {{ csrf_field() }}
    </form>
  </div>
</div>
@endsection