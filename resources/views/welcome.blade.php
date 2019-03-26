@extends('layouts.master')

@section('app')
    <div class="m-container container">
        <div class="w-header flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="w-top-right links">
                    @auth
                        <a href="{{ url('/') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}" style="color: transparent">Login</a>
                    @endauth
                </div>
            @endif

            <div class="w-content">
                <div class="w-title">
                    iFiring
                </div>

                <p>
                    努力做一个终身学习和持续思考的人
                </p>

                <ul class="w-links">
                    <li class="w-links-li col-xs-1 col-sm-2 col-md-2 col-lg-1">
                        <p class="w-links-p">
                            <a href="/blog/" target="_blank"><img class="w-icons" src="icons/notes.svg" alt="notes"/></a>
                        </p>
                    </li>
                    <li class="w-links-li col-xs-1 col-sm-2 col-md-2 col-lg-1">
                        <p class="w-links-p">
                            <a href="https://github.com/iFiring" target="_blank"><img class="w-icons" src="icons/github.svg" alt="github"/></a>
                        </p>
                    </li>
                    <li class="w-links-li col-xs-1 col-sm-2 col-md-2 col-lg-1">
                        <p class="w-links-p">
                            <a href="mailto:wchuan@drips.cn" title="wchuan@drips.cn"><img class="w-icons" src="icons/email.svg" alt="email"/></a>
                        </p>
                    </li>
                    <li class="w-links-li col-xs-1 col-sm-2 col-md-2 col-lg-1">
                        <p class="w-links-p">
                            <a href="https://twitter.com/wcdripscn" target="_blank" title=""><img class="w-icons" src="icons/twitter.svg" alt="twitter"/></a>
                        </p>
                    </li>
                    <li class="w-links-li col-xs-1 col-sm-2 col-md-2 col-lg-1">
                        <p class="w-links-p">
                            <a href="/blog/#/articles/about" target="_blank"><img class="w-icons" src="icons/user.svg" alt="user"/></a>
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection