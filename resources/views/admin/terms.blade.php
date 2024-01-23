@extends('admin.layouts.layout')
@section('content')
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form method="POST" action="{{ route('admin.term_insert')}}">
        @csrf
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">เพิ่มภาคเรียนการศึกษา</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="t_num" class="fs-6 mt-1 mb-0">ภาคเรียน</label>
                    <input type="text" class="form-control" placeholder="ป้อนภาคเรียน" id="t_num" name="t_num" required>
                    <label for="t_year" class="fs-6 mt-1 mb-0">ปีการศึกษา</label>
                    <input type="text" class="form-control" placeholder="ป้อนปีการศึกษา" id="t_year" name="t_year" required>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="row">
    <div class="col-lg-12 mt-4">
        <div class="card ">
            <div class="card-header pb-0 p-3">
                <h5 class="mb-0">ภาคเรียน</h5>
                <p class="text-sm">ภาคเรียนการศึกษา(ทั้งหมด)</p>
                <div class="d-flex justify-content-between">
                    <div>
                        <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-danger ">เพิ่มภาคเรียน</button>
                    </div>
                    <div>
                        <form method=" GET" action="  ">
                            <div class="d-flex">
                                <div class="">
                                    <input type="text" class="form-control" placeholder="ค้นหาผู้ใช้งาน...." name="keyword">
                                </div>
                                <button class="btn btn-outline-secondary ms-2" type="submit">ค้นหา</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($term as $item)

                    <div class="modal fade" id="Modaledit{{$item->t_id}}" tabindex="-1" aria-labelledby="ModaleditLabel{{$item->t_id}}" aria-hidden="true">
                        <form method="POST" action="{{ route('admin.term_edit', $item->t_id)}}">
                            @csrf
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="modal-title fs-5" id="ModaleditLabel">แก้ไขภาคเรียนการศึกษา</h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="t_num" class="fs-6 mt-1 mb-0">ภาคเรียน</label>
                                        <input type="text" class="form-control" placeholder="ป้อนภาคเรียน" id="t_num" name="t_num" required value="{{$item->t_name}}">
                                        <label for="t_year" class="fs-6 mt-1 mb-0">ปีการศึกษา</label>
                                        <input type="text" class="form-control" placeholder="ป้อนปีการศึกษา" id="t_year" name="t_year" required value="{{$item->t_year}}">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                        <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-3">
                        <div class="card" style="background-image: url('../../../assets/img/curved-images/white-curved.jpeg')">
                            <span class="mask bg-gradient-dark opacity-9 border-radius-xl"></span>
                            <div class="card-body p-3 position-relative">
                                <div class="row">
                                    <div class="col-8 text-start">
                                        <div class="icon icon-shape bg-white shadow text-center border-radius-md">
                                            <i class="ni ni-circle-08 text-dark text-gradient text-lg opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <h5 class="text-white font-weight-bolder mb-0 mt-3">
                                            {{$item->t_name}}/{{$item->t_year}}
                                        </h5>
                                        <span class="text-white text-sm">ภาคเรียนการศึกษา </span>
                                    </div>
                                    <div class="col-4">
                                        <div class="dropdown text-end mb-6">
                                            <a href="javascript:;" class="cursor-pointer" id="dropdownUsers1" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-ellipsis-h text-white" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu px-2 py-3" aria-labelledby="dropdownUsers1">
                                                <li><a class="dropdown-item border-radius-md " href="{{ route('admin.term_program', $item->t_id) }}">จัดการผู้สอนรายวิชา</a></li>
                                                <li><a class="dropdown-item border-radius-md" href="javascript:;" data-bs-toggle="modal" data-bs-target="#Modaledit{{$item->t_id}}">แก้ไข</a></li>
                                                <li><a class="dropdown-item border-radius-md text-danger" href="javascript:;" data-target="{{ route('admin.term_delete', $item->t_id) }}" onclick="Delete(this)">ลบ</a></li>
                                            </ul>
                                        </div>
                                        <p class="text-white text-sm text-end font-weight-bolder mt-auto mb-0">{{$item->t_name}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
