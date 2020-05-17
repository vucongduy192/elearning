<div class="row blog_row">
    @foreach($blogs as $blog)
        <div class="col-lg-6">
            <div class="blog_post">
                <div class="blog_image"
                     style="background-image: url('{{ $blog->thumbnail ? $blog->thumbnail : \App\Models\Config::PLACEHOLDER_THUMBNAIL }}')"></div>
                <div class="blog_title_container">
                    <div class="blog_post_title"><a href="{{ route('blogs.show', ['id' => $blog->id]) }}">{{ substr($blog->title, 0, 20).'...' }}</a></div>
                    <div class="blog_post_text">
                        <p>{{ $blog->summary }}</p>
                    </div>
                    <div class="read_more"><a href="{{ route('blogs.show', ['id' => $blog->id]) }}">Read More <img src="{{ asset('front-end/images/right.png') }}" alt=""></a></div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="pull-right">
    {{ $blogs->links('components.pagination') }}
</div>
