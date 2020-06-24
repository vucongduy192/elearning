@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/courses.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/courses_responsive.css") }}">

    <link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/instructors.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/instructors_responsive.css") }}">
    <style>
        .instructors_background {
            top: 30px;
        }
        .courses {
            background: white;
        }
    </style>
@endsection

@section('content')
    <div class="header_padding" style="height: 120px;"></div>
    <div class="instructors">
        <div class="instructors_background"
             style="background-image: url({{ asset('front-end/images/instructors_background.png') }})"></div>
        <div class="container">
            <div class="row instructors_row">
                <div class="col-lg-4 instructor_col">
                    <div class="instructor text-center">
                        <div class="instructor_image_container">
                            <div class="instructor_image"><img
                                    src="{{ asset($professor->user->avatar ? $professor->user->avatar
                                                                           : \App\Models\Config::PLACEHOLDER_AVATAR) }}"
                                    alt=""></div>
                        </div>
                        <div class="instructor_name"><a href="#">{{ $professor->user->name }}</a></div>
                        <div class="instructor_social">
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="professor_detail">
                        <div class="instructor_name"><a href="#">Thông tin</a></div>
                        <div class="instructor_text">
                            <p>Thầy giảng dạy tại Bộ môn Công nghệ Phần mềm, Viện Công nghệ thông tin và truyền thông, trường Đại học Bách khoa Hà Nội. Bà nhận học vị Tiến sỹ ngành Tin học tại trường Đại học Bách khoa Grenoble, Cộng hoà Pháp năm 2008. Các hướng nghiên cứu chủ yếu hiện nay bao gồm: các hệ thống hướng dịch vụ và ứng dụng (chuyển đổi số, e-learning, IoT), các khía cạnh ngoài chức năng của phần mềm (đảm bảo an toàn, rủi ro, dung lỗi, dễ truy cập, tương tác, dùng được), các phương pháp phát triển phần mềm tiên tiến và ứng dụng.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="courses">
        <div class="container">
            <h3 class="section_title">Khóa học</h3>
            <div class="professor_courses_list courses_list"></div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var professor_id = "{{ $professor->id }}";
        function professor_courses(url="{{ route('professors.professor_courses') }}") {
            $.ajax({
                url: url,
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    professor_id: professor_id,
                },
                beforeSend: function () {
                    $('.professor_courses_list').waitMe({effect: 'bounce', text: '', bg: 'rgba(255,255,255,0.7)', color: '#000'});
                },
                success: function (data) {
                    $('.professor_courses_list').waitMe('hide').html(data.html);
                }
            });
        }
        $(document).ready(function () {
            professor_courses();

            $('body').on('click', '.pagination li',  function (e) {
                e.preventDefault();
                professor_courses(url=$(this).find("a").attr('href'));
            });
        })
    </script>
    </script>
@endsection
