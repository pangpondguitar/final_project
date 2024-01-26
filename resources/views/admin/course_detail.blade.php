@extends('admin.layouts.layout')
@section('content')
<!-- Modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form method="POST" action="{{ route('admin.course_detail.subject_insert', $id)}}  ">
        @csrf
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">เพิ่มรายวิชา</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="s_num" class="fs-6 mt-1 mb-0">รหัสวิชา</label>
                    <input type="text" class="form-control" placeholder="ป้อนชื่อสาขา" id="s_num" name="s_num">
                    <label for="s_name" class="fs-6 mt-1 mb-0">ชื่อวิชา</label>
                    <input type="text" class="form-control" placeholder="ป้อนรายละเอียดข้อมูลสาขา" id="s_name" name="s_name">
                    @error('s_name')
                    <div class=" my-2">
                        <span class="text-danger">{{$message}}</span>
                    </div>
                    @enderror

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="row">

    <div class="col-12 mt-4">
        <div class="card mb-3">
            <div class="card-body p-3">
                <h5 class="mb-0">เมนู</h5>
                <p class="text-sm">จัดการข้อมูลหลักสูตร</p>
                <div class="row">
                    <div class="col-lg-3">
                        <a href="{{ route('admin.course_detail', ['id' => $id, 'menu' => 1])}}">
                            <div class="card h-100 @if($menu_type == 1) menu_course_active @endif">
                                <span class="mask  opacity-9 border-radius-xl  "></span>
                                <div class="card-body p-3 position-relative">
                                    <div class="row">
                                        <div class="col-8 text-start">
                                            <h5 class="title fw-normal mb-0 mt-3">
                                                รายวิชาทั้งหมดในหลักสูตร
                                            </h5>
                                            <span class="title text-sm">รายวิชาทั้งหมด </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </a>
                    </div>
                    <div class="col-lg-3">
                        <a href="{{ route('admin.course_detail', ['id' => $id, 'menu' => 2])}}">
                            <div class="card h-100 @if($menu_type == 2) menu_course_active @endif">
                                <span class="mask  opacity-9 border-radius-xl  "></span>
                                <div class="card-body p-3 position-relative">
                                    <div class="row">
                                        <div class="col-8 text-start">
                                            <h5 class="title fw-normal mb-0 mt-3">
                                                คณะกรรมการหลักสูตร
                                            </h5>
                                            <span class="text-muted text-sm title">คณะกรรมการหลักสูตร </span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3">
                        <a href="{{ route('admin.course_detail', ['id' => $id, 'menu' => 3])}}">
                            <div class="card h-100 @if($menu_type == 3) menu_course_active @endif">
                                <span class="mask  opacity-9 border-radius-xl  "></span>
                                <div class="card-body p-3 position-relative">
                                    <div class="row">
                                        <div class="col-8 text-start">
                                            <h5 class="title fw-normal mb-0 mt-3">
                                                รายละเอียดข้อมูลหลักสูตร
                                            </h5>
                                            <span class="title text-sm">รายละเอียดข้อมูลหลักสูตร </span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($menu_type == 1)
    <div class="col-lg-12">
        <div class="card mb-3 ">
            <div class="card-header pb-0 p-3">
                <h5 class="mb-0">รายวิชา</h5>
                <p class="text-sm">รายวิชาทั้งหมด</p>
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="" class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#exampleModal">เพิ่มรายวิชา + </a>
                    </div>
                    <div>
                        <form method="GET" action="{{ route('admin.course_detail.subject_search', $id)}}  ">
                            <div class="d-flex">
                                <div class="">
                                    <input type="text" class="form-control" placeholder="ค้นหารายวิชา...." name="keyword">
                                </div>
                                <button class="btn btn-outline-secondary ms-2" type="submit">ค้นหา</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
            @if(count($subject) > 0)
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">รหัสวิชา</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ชื่อวิชา</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Function</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach($subject as $item)
                        <div class="modal fade" id="edit{{$item->s_id}}" tabindex="-1" aria-labelledby="edit{{$item->s_id}}" aria-hidden="true">
                            <form method="POST" action="{{ route('admin.course_detail.subject_edit', $item->s_id)}}  ">
                                @csrf
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title fs-5" id="exampleModalLabel{{$item->s_id}}">แก้ไขข้อมูลรายวิชา</h2>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="s_num" class="fs-6 mt-1 mb-0">รหัสวิชา</label>
                                            <input type="text" class="form-control" placeholder="ป้อนชื่อสาขา" id="s_num" name="s_num" value="{{$item->s_num}}">
                                            <label for="s_name" class="fs-6 mt-1 mb-0">ชื่อวิชา</label>
                                            <input type="text" class="form-control" placeholder="ป้อนรายละเอียดข้อมูลสาขา" id="s_name" name="s_name" value="{{$item->s_name}}">
                                            @error('s_name')
                                            <div class=" my-2">
                                                <span class="text-danger">{{$message}}</span>
                                            </div>
                                            @enderror

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ปิด</button>
                                            <button type="submit" class="btn btn-primary" name="edite">บันทึกข้อมูล</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <tr>
                            <td>
                                <h6 class="text-center">{{$item->s_num}}</h6>
                            </td>
                            <td>
                                <div class="d-flex px-3 py-1">

                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 ">{{$item->s_name}}</h6>
                                        <h6 class="text-xs text-secondary mb-0">{{$item->s_name}}</h6>
                                    </div>
                                </div>
                            </td>

                            <td class="align-middle text-center">
                                <a href="javascript:;" class="text-secondary font-weight-bold ms-3" data-toggle="tooltip" data-original-title="Edit user" data-bs-toggle="modal" data-bs-target="#edit{{$item->s_id}}">
                                    <i class="bi bi-pen"></i>
                                </a>
                                <a href="javascript:;" class="text-danger font-weight-bold ms-4" data-toggle="tooltip" data-original-title="Edit user" data-target="{{ route('admin.course_detail.subject_delete', $item->s_id) }}" onclick="Delete(this)">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </td>

                        </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
            <div class="card-footer py-2 pt-3">
                <div class="row">
                    <div class="col-lg-12">
                        {{ $subject->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    @elseif($menu_type == 2)
    <div class="col-lg-12">
        <div class="card mb-3">
            <div class="card-header pb-0 p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="mb-0">คณะกรรมการหลักสูตร</h5>
                        <p class="text-sm">คณะกรรมการหลักสูตรทั้งหมด</p>
                    </div>
                    <div>
                        <button class="btn bg-gradient-info">เพิ่มคณะกรรมการ</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($course_com as $item)

                    <div class="col-lg-3">
                        <div class="card card-plain text-center">
                            <a href="javascript:;">
                                <img class="avatar avatar-xl shadow" src="https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/team-3.jpg">
                            </a>
                            <div class="card-body">
                                <h4 class="card-title">Andrew John</h4>
                                <h6 class="category text-info text-gradient">Loan Counselor</h6>
                                <p class="card-description">
                                    "Don't walk behind me; I may not lead. Don't walk in front of me; I may not follow. Just walk beside me and be my friend."
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <!-- <div class="col-lg-3">
                        <div class="card card-plain text-center">
                            <a href="javascript:;">
                                <img class="avatar avatar-xl shadow" src="https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/team-3.jpg">
                            </a>
                            <div class="card-body">
                                <h4 class="card-title">Andrew John</h4>
                                <h6 class="category text-info text-gradient">Loan Counselor</h6>
                                <p class="card-description">
                                    "Don't walk behind me; I may not lead. Don't walk in front of me; I may not follow. Just walk beside me and be my friend."
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card card-plain text-center">
                            <a href="javascript:;">
                                <img class="avatar avatar-xl shadow" src="https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/team-3.jpg">
                            </a>
                            <div class="card-body">
                                <h4 class="card-title">Andrew John</h4>
                                <h6 class="category text-info text-gradient">Loan Counselor</h6>
                                <p class="card-description">
                                    "Don't walk behind me; I may not lead. Don't walk in front of me; I may not follow. Just walk beside me and be my friend."
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card card-plain text-center">
                            <a href="javascript:;">
                                <img class="avatar avatar-xl shadow" src="https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/team-3.jpg">
                            </a>
                            <div class="card-body">
                                <h4 class="card-title">Andrew John</h4>
                                <h6 class="category text-info text-gradient">Loan Counselor</h6>
                                <p class="card-description">
                                    "Don't walk behind me; I may not lead. Don't walk in front of me; I may not follow. Just walk beside me and be my friend."
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card card-plain text-center">
                            <a href="javascript:;">
                                <img class="avatar avatar-xl shadow" src="https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/team-3.jpg">
                            </a>
                            <div class="card-body">
                                <h4 class="card-title">Andrew John</h4>
                                <h6 class="category text-info text-gradient">Loan Counselor</h6>
                                <p class="card-description">
                                    "Don't walk behind me; I may not lead. Don't walk in front of me; I may not follow. Just walk beside me and be my friend."
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card h-100 card-plain border">
                            <div class="card-body d-flex flex-column justify-content-center text-center">
                                <a href="javascript:;">
                                    <i class="fa fa-plus text-secondary mb-3" aria-hidden="true"></i>
                                    <h5 class=" text-secondary"> เพิ่มกรรมการ </h5>
                                </a>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    @elseif($menu_type == 3)
    <div class="col-lg-12">
        <div class="card mb-3 ">
            <div class="card-header pb-0 p-3">
                <h5 class="mb-0">รายละเอียดข้อมูลหลักสูตร</h5>
                <p class="text-sm">รายละเอียดข้อมูลหลักสูตร</p>


            </div>
            <div class="card-body">
                <form action="" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label ">ชื่อหลักสูตร</label>
                            <div class="input-group">
                                <input id="firstName" name="name" class="form-control" type="text" placeholder="ชื่อหลักสูตร" required="required" value="{{$course->c_name}}">
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">ชื่อหลักสูตรภาษาอังกฤษ</label>
                            <div class="input-group">
                                <input id="lastName" name="name2" class="form-control" type="text" placeholder="ชื่อหลักสูตร(ภาษาอังกฤษ)" required="required" value="{{$course->c_name2}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label class="form-label mt-4">อัพโหลดไฟล์</label>
                            <input type="file" class="form-control" name="file" id="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <label class="form-label mt-4">รายละเอียด</label>
                            <textarea name="address" class="form-control" id="" cols="30" rows="3"></textarea>
                        </div>
                    </div>

                    <div class=" row d-flex text-end mt-3">
                        <div class="col-lg-12">
                            <a class="btn bg-outline-secondary mb-0 px-5" href="{{route('admin.users')}}">กลับ</a>
                            <button class="btn bg-gradient-success mb-0 px-5" type="submit">บันทึกข้อมูล</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card " id="delete">
            <div class="card-header">
                <h5 class="mb-1">ลบข้อมูลหลักสูตร</h5>
                <p class="text-sm mb-0">กรุณายืนยันการลบข้อมูลหลักสูตร คุณแน่ใจหรือในการลบข้อมูลหลักสูตรออกจากระบบเมื่อลบแล้วไม่สามารถกู้คืนข้อมูลดังกล่าวได้</p>
            </div>
            <div class="card-body d-sm-flex pt-0">
                <div class="d-flex align-items-center mb-sm-0 mb-4">
                    <div>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault0">
                        </div>
                    </div>
                    <div class="ms-2">
                        <span class="text-dark font-weight-bold d-block text-sm">Confirm</span>
                        <span class="text-xs d-block">I want to delete my account.</span>
                    </div>
                </div>
                <button class="btn btn-outline-secondary mb-0 ms-auto" type="button" name="button">Deactivate</button>
                <button class="btn bg-gradient-danger mb-0 ms-2" type="button" name="button" data-target="{{ route('admin.course_detail.course_delete', $id) }}" onclick="Delete(this)">ลบข้อมูลหลักสูตร</button>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection