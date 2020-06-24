@if(count($enrolled) == 0)
<div class="course_body">
    <div class="course_text">
        Bạn chưa có dữ liệu lịch sử học.
    </div>
</div>
@endif

@foreach($enrolled as $enroll)
<div class="course_body">
    <div class="course_title">
        <a href="#"> {{ $enroll->course->name }}</a>
    </div>
    <div>
        <a href="{{ route('courses.show', ['id' => $enroll->course->id]) }}" class="btn btn-primary e-btn pull-right">
            Tiếp tục học
        </a>
    </div>
    <br>
    <div class="course_info">
        <ul>
            <li><a href="#"><b> {{ $enroll->course->teacher->user->name }}</b></a></li>
        </ul>
    </div>
    <div class="course_text">
        <p>{{ $enroll->course->overview }}</p>
    </div>
</div>
<br>
@endforeach
<div class="pull-right">
    {{ $enrolled->links('components.pagination') }}
</div>
