@foreach($reviews as $r)
<div class="review">
    <div
        class="review_title_container d-flex flex-row align-items-start justify-content-start">
        <div
            class="review_title d-flex flex-row align-items-center justify-content-center">
            <div class="review_author_image">
                <div><img src="#" alt=""></div>
            </div>
            <div class="review_author">
                <div class="review_author_name"><a href="#">{{ $r->student->user->name }}</a></div>
                <div class="review_date">Sep 29, 2017 at 9:48 am</div>
            </div>
        </div>
        <div class="review_stars ml-auto">
            <div class="rating_r rating_r_{{$r->rating}} review_rating">
                <i></i>
                <i></i>
                <i></i>
                <i></i>
                <i></i></div>
        </div>
    </div>
    <div class="review_text">
        <p>{{ $r->content }}</p>
    </div>
</div>
@endforeach
<div class="pull-right">
    {{ $reviews->links('components.pagination') }}
</div>
