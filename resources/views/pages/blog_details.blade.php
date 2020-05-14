@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/blog_single.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/blog_single_responsive.css") }}">
@endsection
@section('content')
<div class="header_padding" style="height: 120px;"></div>

<div class="blog_top_image">
    <div class="blog_top">
        <div class="blog_background parallax-window" data-parallax="scroll"
             data-image-src="{{ asset($blog->thumbnail ? $blog->thumbnail : \App\Models\Config::PLACEHOLDER_THUMBNAIL) }}" data-speed="0.8"></div>
    </div>
</div>

<!-- Blog Content -->

<div class="blog_container">
    <div class="container">
        <div class="row blog_content_row">
            <div class="col">
                <div class="blog_content">
                    <div class="blog_post_title_container">
                        <div class="blog_title">{{ $blog->title }}</div>
                    </div>
                    <div class="blog_text">
                        {!! $blog->content !!}
                    </div>
                    <div class="blog_post_footer d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-start">
                        <div class="blog_post_author d-flex flex-row align-items-center justify-content-start">
                            <div class="author_image"><div><img src="images/blog_author.jpg" alt=""></div></div>
                            <div class="author_info">
                                <ul>
                                    <li><a href="#">Admin</a></li>
                                    <li>Sep 29, 2017 at 9:48 am</li>
                                </ul>
                            </div>
                        </div>
                        <div class="blog_post_share ml-lg-auto">
                            <span>share</span>
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-google" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Similar Posts -->

        <div class="row similar_posts">
            @foreach($newest_blogs as $blog)
                <div class="col-lg-6">
                    <div class="blog_post">
                        <div class="blog_image"
                             style="background-image: url('{{ $blog->thumbnail ? $blog->thumbnail : \App\Models\Config::PLACEHOLDER_THUMBNAIL }}')"></div>
                        <div class="blog_title_container">
                            <div class="blog_post_title"><a href="{{ route('blogs.show', ['id' => $blog->id]) }}">{{ $blog->title }}</a></div>
                            <div class="blog_post_text">
                                <p>{{ $blog->summary }}</p>
                            </div>
                            <div class="read_more"><a href="{{ route('blogs.show', ['id' => $blog->id]) }}">Read More <img src="{{ asset('front-end/images/right.png') }}" alt=""></a></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="{{ asset('front-end/plugins/parallax-js-master/parallax.min.js') }}"></script>
    <script src="{{ asset('front-end/js/blog_single.js') }}"></script>

@endsection
