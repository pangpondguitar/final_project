@extends('admin.layouts.layout')
@section('content')
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form method="POST" action="{{ url('admin/programs/insert')}}">
        @csrf
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">เพิ่มสาขาวิชา</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="p_pic" class="fs-6 mb-0">กรุณาเลือกไฟล์รูปภาพ</label>
                    <input type="file" class="form-control" id="p_img">
                    <label for="p_name" class="fs-6 mt-1 mb-0">ป้อนชื่อสาขา</label>
                    <input type="text" class="form-control" placeholder="ป้อนชื่อสาขา" id="p_name" name="p_name">
                    <label for="p_detail" class="fs-6 mt-1 mb-0">รายละเอียด</label>
                    <input type="text" class="form-control" placeholder="ป้อนรายละเอียดข้อมูลสาขา" id="p_detail" name="p_detail">
                    @error('p_name')
                    <div class=" my-2">
                        <span class="text-danger">{{$message}}</span>
                    </div>
                    @enderror

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
    <div class="col-12 mt-4">
        <div class="card mb-4">
            <div class="card-header pb-0 p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="mb-0">หลักสูตร</h5>
                        <p class="text-sm">หลักสูตรทั้งหมด</p>
                    </div>

                </div>
            </div>
            <div class="card-body p-3">

                <ul class="list-group">
                    @foreach($data as $item)
                    <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                        <div class="avatar me-3">
                            <img src="../../../assets/img/book (5).png" alt="kal" class="border-radius-lg shadow" style="padding: 8px;">
                        </div>
                        <div class="d-flex align-items-start flex-column justify-content-center">
                            <h6 class="mb-0 "> {{$item->p_name}}</h6>
                            <p class="mb-0 text-xs text-truncate" style="max-width: 80%; "> {{$item->p_detail}}</p>
                        </div>
                        <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto" href="{{ route('admin.course_all', $item->id)}}">ดูหลักสูตร</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
