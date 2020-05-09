@if(count($enrolled) == 0)
    <script>
        toastr.warning('You don\'t have any enrollment history data.');
    </script>
@endif

@foreach($enrolled as $enroll)
<div class="course_body">
    <div class="course_title">
        <a href="#"> {{ $enroll->course->name }}</a>
    </div>
    <div>
        <a href="{{ route('courses.show', ['id' => $enroll->course->id]) }}" class="btn btn-primary e-btn pull-right">
            Go to course
        </a>
    </div>
    <br>
    <div class="course_info">
        <ul>
            <li><a href="#"><b> {{ $enroll->course->teacher->user->name }}</b></a></li>
            <li><a href="#">English</a></li>
        </ul>
    </div>
    <div class="course_text">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce enim nulla.</p>
    </div>
</div>
<br>
@endforeach
<div class="pull-right">
    {{ $enrolled->links('components.pagination') }}
</div>
