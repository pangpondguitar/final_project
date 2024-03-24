@extends('admin.layouts.layout')
@section('content')
<!-- Modal -->
<style>
    .alert-dismissible .btn-close {}

    .card-input-element {
        display: none;
    }


    .card-input:hover {
        cursor: pointer;
    }

    .card-input-element:checked+.card-input {
        /* box-shadow: 0 0 1px 1px #e8e8e8; */
        background-color: #e8e8e8;
    }
</style>
<div class="row">
    <div class="col-12 mt-4">
        <div class=" mb-4">

            <div class="row mb-4">
                <div class="col-lg-12 mt-lg-0 mt-4">

                    <div class="card card-body" id="profile">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-sm-auto col-4">
                                <div class="avatar avatar-xl position-relative">
                                    <img src="../../../assets/img/bruce-mars.jpg" alt="bruce" class="w-100 border-radius-lg shadow-sm">
                                </div>
                            </div>
                            <div class="col-sm-auto col-8 my-auto">
                                <div class="h-100">
                                    <h5 class="mb-1 font-weight-bolder">
                                        {{$program->p_name}}
                                    </h5>
                                    <p class="mb-0 text-sm text-truncate" style="max-width: 1200px;">
                                        {{$program->p_detail}}
                                    </p>
                                </div>
                            </div>
                            <!-- <div class="col-sm-auto ms-sm-auto mt-sm-0 mt-3 d-flex">
                                <label class="form-check-label mb-0">
                                    <small id="profileVisibility">
                                        Switch to invisible
                                    </small>
                                </label>
                                <div class="form-check form-switch ms-2">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault23" checked="" onchange="visible()">
                                </div>
                            </div> -->
                            <div class="col-sm-auto ms-sm-auto mt-sm-0 mt-3 d-flex">
                                <a href="#" data-target="{{ route('program.delete', $program->p_id) }}" class="btn btn-danger" onclick="showAlert(this)">ลบข้อมูล</a>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-4" id="password">
                        <div class="card-header">
                            <h5>แก้ไขข้อมูล</h5>
                        </div>
                        <div class="card-body pt-0">
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                                <div class="offcanvas-header">
                                    <h5 id="offcanvasRightLabel">หลักสูตรทั้งหมด</h5>
                                    <button type="button" class="btn-close text-reset text-dark" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <form method="POST" action="{{ route('program.update.course', $program->p_id) }}">
                                        @csrf
                                        <div class="row">
                                            @foreach($courses as $item)
                                            <label class="m-0">
                                                <input type="radio" name="course" selected checked class="card-input-element" value="{{$item->c_id}}" />

                                                <div class="card card-default card-input mb-3">
                                                    <div class="card-body">
                                                        <div class="icon icon-shape bg-white shadow text-center border-radius-md">
                                                            <i class="ni ni-circle-08 text-dark text-gradient text-lg opacity-10" aria-hidden="true"></i>
                                                        </div>
                                                        <h5 class=" font-weight-bolder mb-0 mt-3">
                                                            หลักสูตร
                                                        </h5>
                                                        <span class=" text-sm">{{$item->c_name}} </span>
                                                    </div>
                                                </div>
                                            </label>
                                            @endforeach
                                            <div class="col">
                                                <button class="btn btn-primary w-100 mt-3" type="submit" name="form1">บันทึกข้อมูล</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('program.update', $program->p_id) }}">
                                @csrf
                                @if (session('status'))
                                <!-- <div class="alert alert-secondary text-white">
                                        {{ session('status') }}

                                    </div> -->
                                <div class="alert alert-secondary alert-dismissible fade show text-white" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif
                                <label class="form-label fs-6 mb-1">ชื่อสาขา</label>
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="ป้อนชื่อสาขา" name="p_name" value=" {{$program->p_name}}">
                                </div>
                                <label class="form-label fs-6 mb-1">รายละเอียด</label>
                                <div class="form-group">
                                    <textarea class="form-control" rows="3" placeholder="ป้อนรายละเอียดข้อมูลสาขา" name="p_detail" value="">{{$program->p_detail}}</textarea>
                                </div>
                                <div class="row">
                                    <label class="form-label fs-6 mb-1">หลักสูตรที่ใช้ปัจจุบัน</label>

                                    <div class="col-lg-4 col-md-6">
                                        <!-- <div class="card">
                                            <div class="card-body p-3">
                                                <div class="d-flex">
                                                    <div class="avatar avatar-xl bg-gradient-dark border-radius-md p-2">
                                                        <img src="../../../assets/img/small-logos/logo-slack.svg" alt="slack_logo">
                                                    </div>
                                                    <div class="ms-3 my-auto">
                                                        <h6>หลักสูตรปี 2566</h6>
                                                        <div class="avatar-group">
                                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-original-title="Jessica Rowland">
                                                                <img alt="Image placeholder" src="../../../assets/img/team-3.jpg" class="">
                                                            </a>
                                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-original-title="Audrey Love">
                                                                <img alt="Image placeholder" src="../../../assets/img/team-4.jpg" class="rounded-circle">
                                                            </a>
                                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-original-title="Michael Lewis">
                                                                <img alt="Image placeholder" src="../../../assets/img/team-2.jpg" class="rounded-circle">
                                                            </a>
                                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-original-title="Jessica Rowland">
                                                                <img alt="Image placeholder" src="../../../assets/img/team-3.jpg" class="">
                                                            </a>
                                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-original-title="Audrey Love">
                                                                <img alt="Image placeholder" src="../../../assets/img/team-4.jpg" class="rounded-circle">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <div class="dropdown">
                                                            <button class="btn btn-link text-secondary ps-0 pe-2" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa fa-ellipsis-v text-lg" aria-hidden="true"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-end me-sm-n4 me-n3" aria-labelledby="navbarDropdownMenuLink">
                                                                <a class="dropdown-program" href="javascript:;">ดูข้อมูล</a>
                                                                <a class="dropdown-program" href="javascript:;">ดูคณะกรรมการ</a>
                                                                <a class="dropdown-program text-danger" href="javascript:;">ลบข้อมูลหลักสูตร</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-sm mt-3"> If everything I did failed - which it doesn't, I think that it actually succeeds. </p>
                                                <hr class="horizontal dark">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h6 class="text-sm mb-0">5</h6>
                                                        <p class="text-secondary text-sm font-weight-bold mb-0">Participants</p>
                                                    </div>
                                                    <div class="col-6 text-end">
                                                        <h6 class="text-sm mb-0">02.03.22</h6>
                                                        <p class="text-secondary text-sm font-weight-bold mb-0">Due date</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        @if(empty($program->c_id))
                                        <div class="card" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" style="height: 180px;">
                                            <div class="card-body d-flex flex-column justify-content-center text-center">
                                                <a href="javascript:;">
                                                    <i class="fa fa-plus text-secondary mb-3" aria-hidden="true"></i>
                                                    <h5 class=" text-secondary"> เพิ่มหลักสูตร </h5>
                                                </a>
                                            </div>
                                        </div>
                                        @else
                                        <div class="card mt-2">
                                            <img class="card-img-top" src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1651&amp;q=80">
                                            <div class="position-relative" style="height: 50px;overflow: hidden;margin-top: -50px;z-index:2;position: relative;">
                                                <div class="position-absolute w-100 top-0" style="z-index: 1;">
                                                    <svg class="waves waves-sm" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 40" preserveAspectRatio="none" shape-rendering="auto">
                                                        <defs>
                                                            <path id="card-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
                                                        </defs>
                                                        <g class="moving-waves">
                                                            <use xlink:href="#card-wave" x="48" y="-1" fill="rgba(255,255,255,0.30"></use>
                                                            <use xlink:href="#card-wave" x="48" y="3" fill="rgba(255,255,255,0.35)"></use>
                                                            <use xlink:href="#card-wave" x="48" y="5" fill="rgba(255,255,255,0.25)"></use>
                                                            <use xlink:href="#card-wave" x="48" y="8" fill="rgba(255,255,255,0.20)"></use>
                                                            <use xlink:href="#card-wave" x="48" y="13" fill="rgba(255,255,255,0.15)"></use>
                                                            <use xlink:href="#card-wave" x="48" y="16" fill="rgba(255,255,255,0.99)"></use>
                                                        </g>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="mb-0">{{$c_course->c_name}}</h5>
                                                <small class="text-muted">{{$c_course->c_name2}}</small>
                                                <div class="d-flex justify-content-between mt-3">

                                                    <div>
                                                        <a href="{{ route('admin.course_detail', ['id' => $c_course->c_id, 'menu' => 1 ])}}" class="text-primary icon-move-right">ไปยังหลักสูตร
                                                            <i class="fas fa-arrow-right text-xs ms-1" aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                    <div>
                                                        <i class="bi bi-pen" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"></i>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        @endif

                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-end">
                                    <div>
                                        <h5 class=" mt-5">Password requirements</h5>
                                        <p class="text-muted mb-2">
                                            Please follow this guide for a strong password:
                                        </p>
                                        <ul class="text-muted ps-4 mb-0 float-start">
                                            <li>
                                                <span class="text-sm">One special characters</span>
                                            </li>
                                            <li>
                                                <span class="text-sm">Min 6 characters</span>
                                            </li>
                                            <li>
                                                <span class="text-sm">One number (2 are recommended)</span>
                                            </li>
                                            <li>
                                                <span class="text-sm">Change it often</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn bg-gradient-success btn-sm float-end mt-6 mb-0 " name="form2">บันทึกข้อมูล</button>
                                        <a class="btn bg-outline-dark  btn-sm float-end mt-6 mb-0 me-1" href="{{ route('admin.program')}}">กลับ</a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
<script>
    function showAlert(elem) {
        Swal.fire({
            title: 'ยืนยันรายการ?',
            text: "ยืนยันรายการอีกครั้ง!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#aeaeae',
            confirmButtonText: 'ยืนยันรายการ!',
            cancelButtonText: 'ปิด'
        }).then((result) => {
            if (result.isConfirmed) {
                let target = elem.getAttribute('data-target')
                location.href = target
            }
        });
    }
    $(document).ready(function() {
        $('input:radio').change(function() { //Clicking input radio
            var radioClicked = $(this).attr('id');
            unclickRadio();
            removeActive();
            clickRadio(radioClicked);
            makeActive(radioClicked);
        });
        $(".card2").click(function() { //Clicking the card
            var inputElement = $(this).find('input[type=radio]').attr('id');
            unclickRadio();
            removeActive();
            makeActive(inputElement);
            clickRadio(inputElement);
        });
    });


    function unclickRadio() {
        $("input:radio").prop("checked", false);
    }

    function clickRadio(inputElement) {
        $("#" + inputElement).prop("checked", true);
    }

    function removeActive() {
        $(".card").removeClass("active");
    }

    function makeActive(element) {
        $("#" + element + "-card").addClass("active");
    }
</script>