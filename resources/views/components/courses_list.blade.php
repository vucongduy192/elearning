<div class="row courses_row">
    @if (count($courses) == 0)
        <script>
            toastr.warning('Not found any courses');
        </script>
    @endif

    @foreach($courses as $course)
        <div class="col-lg-4 course_col">
            <div class="course">
                <div class="course_image">
                    <img src="{{ $course->thumbnail ? $course->thumbnail : \App\Models\Config::PLACEHOLDER_THUMBNAIL }}" alt="">
                </div>
                <div class="course_body">
                    <div class="course_title">
                        <a href="{{ route('courses.show', ['id' => $course->id]) }}">{{ mb_substr($course->name, 0, 21, "utf-8") }}
                        </a>
                    </div>
                    <div class="course_info">
                        <ul>
                            <li><a href="{{ route('professors.show', ['id' => $course->teacher->id]) }}">{{ $course->teacher->user->name }}</a></li>
                            <li><a href="#">English</a></li>
                        </ul>
                    </div>
                    <div class="course_text">
                        <p>{{ $course->overview }}</p>
                    </div>
                </div>
                <div class="course_footer d-flex flex-row align-items-center justify-content-start">
                    <div class="course_students"><i class="fa fa-user" aria-hidden="true"></i><span>{{ $course->enrolls }}</span></div>
                    <div class="course_rating ml-auto"><i class="fa fa-star" aria-hidden="true"></i><span>{{ (count($course->reviews) != 0) ? round($course->reviews->pluck('rating')->avg(), 0) : '0' }}</span>
                    </div>
                    <div class="course_mark course_free trans_200"><a href="#">Free</a></div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="pull-right">
    {{ $courses->links('components.pagination') }}
</div>
