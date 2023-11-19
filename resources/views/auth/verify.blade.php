@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('メールアドレスを確認して下さい') }}</div>

                <div class="card-body">
                    <!-- メールが送信できた場合 -->
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('入力されたメールアドレスへ登録用のリンクを送信しました.') }}
                        </div>
                    @endif

                    {{ __('リンクを確認してください.') }}
                    {{ __('メールが届かなかった場合') }},
                    <!-- route('verification.resend') -->
                    <form class="d-inline" method="POST" action="">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
