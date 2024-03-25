$(function () {

  // メインカテゴリをクリックでサブカテゴリが開く
    $('.main_categories').click(function () {
      var category_id = $(this).attr('category_id');
      $('.category_num' + category_id).slideToggle();
    });


    // クリックするといいね数がふえる
    $(document).on('click', '.like_btn', function (e) {
      // フォームが持つデフォルトの動作をキャンセル
      e.preventDefault();
      $(this).addClass('un_like_btn');
      $(this).removeClass('like_btn');
      // 押したらピンクのいいねボタンに変える

      var post_id = $(this).attr('post_id');
      // post_idという名前の属性をもつ値を取得（※ビューから送信している）
      var count = $('.like_counts' + post_id).text();
      //「.like_counts' + post_id」のクラス名の中身（いいねの数）を「テキスト」として取得する
      var countInt = Number(count);
      // 上記の変数を数字に変換して定義する

      // 非同非同期通信
      $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        // CSRFトークン
        method: "get",
        url: "/like/post/" + post_id,
        // いいねをつけるコントローラに接続するURLを指定する
        data: {
          post_id: $(this).attr('post_id'),
          // 該当の投稿のID サーバーに送信するデータ(コントローラに渡すデータ)
        },
      }).done(function (res) {
        console.log(res);
        $('.like_counts' + post_id).text(countInt + 1);
        // $以下のクラス名の場所にcountInt変数＋１をした数字をテキストとして表示させる


      }).fail(function (res) {
        console.log('fail');
      });
    });
    // クリックするとコメントのいいね数がふえる
    $(document).on('click', '.comment_like_btn', function (e) {
      // フォームが持つデフォルトの動作をキャンセル
      e.preventDefault();
      $(this).addClass('comment_un_like_btn');
      $(this).removeClass('comment_like_btn');
      // 押したらピンクのいいねボタンに変える

      var comment_id = $(this).attr('comment_id');
      // post_comment_idという名前の属性をもつ値を取得（※ビューから送信している）
      var count = $('.comment_like_counts' + comment_id).text();
      //「.like_counts' + comment_id」のクラス名の中身（いいねの数）を「テキスト」として取得する
      var countInt = Number(count);
      // 上記の変数を数字に変換して定義する

      // 非同非同期通信
      $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        // CSRFトークン
        method: "get",
        url: "/comment/post/" + comment_id,
        // いいねをつけるコントローラに接続するURLを指定する
        data: {
          comment_id: $(this).attr('comment_id'),
          // 該当の投稿のID サーバーに送信するデータ(コントローラに渡すデータ)
        },
      }).done(function (res) {
        console.log(res);
        $('.comment_like_counts' + comment_id).text(countInt + 1);
        // $以下のクラス名の場所にcountInt変数＋１をした数字をテキストとして表示させる


      }).fail(function (res) {
        console.log('fail');
      });
    });
  
    // クリックするといいね数が減る
    $(document).on('click', '.un_like_btn', function (e) {
      e.preventDefault();
      $(this).removeClass('un_like_btn');
      $(this).addClass('like_btn');
      var post_id = $(this).attr('post_id');
      var count = $('.comment_like_counts' + post_id).text();
      var countInt = Number(count);
  
      $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: "get",
        url: "/unlike/post/" + post_id,
        data: {
          post_id: $(this).attr('post_id'),
        },
      }).done(function (res) {
        $('.comment_like_counts' + post_id).text(countInt - 1);
      }).fail(function () {
      });
    });
    // クリックするとコメントのいいね数が減る
    $(document).on('click', '.comment_un_like_btn', function (e) {
      e.preventDefault();
      $(this).removeClass('comment_un_like_btn');
      $(this).addClass('comment_like_btn');
      var comment_id = $(this).attr('comment_id');
      var count = $('.like_counts' + comment_id).text();
      var countInt = Number(count);
  
      $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: "get",
        url: "/unlike/comment/" + post_id,
        data: {
          comment_id: $(this).attr('comment_id'),
        },
      }).done(function (res) {
        $('.like_counts' + comment_id).text(countInt - 1);
      }).fail(function () {
      });
    });

    // 投稿の編集モーダルデータ受け渡し
    $('.edit-modal-open').on('click',function(){
      $('.js-modal').fadeIn();
      var post_title = $(this).attr('post_title');
      var post_body = $(this).attr('post_body');
      var post_id = $(this).attr('post_id');
      $('.modal-inner-title input').val(post_title);
      $('.modal-inner-body textarea').text(post_body);
      $('.edit-modal-hidden').val(post_id);
      return false;
    });
    $('.js-modal-close').on('click', function () {
      $('.js-modal').fadeOut();
      return false;

    });
    // コメントの編集モーダルデータ受け渡し
    // varでビューから受け取った値を定義する
    $('.comment-edit-modal-open').on('click',function(){
      $('.js-comment-modal').fadeIn();
      var comment = $(this).attr('comment');
      var comment_id = $(this).attr('comment_id');
      var post_id = $(this).attr('post_id');
      $('.modal-inner-body textarea').text(comment);
      // モーダルウィンドウに表示
      $('.comment-modal-hidden').val(comment_id);
      // ビューのモーダルの記述の指定のクラスのvalueに値を設定する
      $('.post-modal-hidden').val(post_id);

      return false;
    });
    $('.js-modal-close').on('click', function () {
      $('.js-comment-modal').fadeOut();
      return false;
    });


    // カテゴリのアコーディオンメニュ
    $(".acMenu dt").on("click", function() {
      $(this).next().slideToggle(300);
      // next次に配置されている要素を取得
      // コンテンツの表示非表示※display:noneがblockに変化する
      // カッコ内はアニメーションの時間0.3秒
      $(this).toggleClass("open", 300);
      // メインカテゴリにopenクラスを付け外しして矢印の向きを変更
      });
  
  });
  