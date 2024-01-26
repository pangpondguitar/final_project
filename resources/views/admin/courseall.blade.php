@extends('admin.layouts.layout')
@section('content')
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form method="POST" action="{{ route('admin.course_insert', $id)}}">
        @csrf
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">เพิ่มหลักสูตร</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="name" class="fs-6 mt-1 mb-0">ป้อนชื่อหลักสูตร</label>
                    <input type="text" class="form-control" placeholder="ป้อนชื่อสาขา" id="name" name="name">
                    <label for="name2" class="fs-6 mt-1 mb-0">ชื่อหลักสูตรภาษาอังกฤษ</label>
                    <input type="text" class="form-control" placeholder="ป้อนรายละเอียดข้อมูลสาขา" id="name2" name="name2">
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
                        <h5 class="mb-0">{{ $p_name}}</h5>
                        <p class="text-sm">หลักสูตรทั้งหมด</p>
                    </div>
                    <div>
                        <div>
                            <a href="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">เพิ่มหลักสูตร</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="row">
                    @foreach($data as $item)
                    <div class="col-lg-12">
                        <div class="card bg-gradient-default my-1">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title text-dark text-gradient"> {{$item->c_name}}</h5>

                                        <blockquote class="blockquote text-white mb-0">
                                            <p class="text-dark ms-3">{{$item->c_name2}}</p>
                                            <footer class="blockquote-footer text-gradient text-info text-sm ms-3">Someone famous in <cite title="Source Title">Source Title</cite></footer>
                                        </blockquote>
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.course_detail', ['id' => $item->c_id, 'menu' => 1 ])}}" class="btn btn-outline-info">ดูรายละเอียด</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="card">
                            <div class="card-body">
                                <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                                    <div class="avatar me-3">
                                        <img src="../../../assets/img/kal-visuals-square.jpg" alt="kal" class="border-radius-lg shadow">
                                    </div>
                                    <div class="d-flex align-items-start flex-column justify-content-center">
                                        <h6 class="mb-0 "> {{$item->c_name}}</h6>
                                        <p class="mb-0 text-xs text-truncate" style="max-width: 80%; "> {{$item->c_name2}}</p>
                                        <h3 class="fw-bold">ปี 2566</h3>
                                    </div>
                                    <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto" href="{{ route('admin.course_all', $item->p_id)}}">ดูหลักสูตร</a>
                                </li>
                            </div>
                        </div> -->
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection