@extends('admin.layouts.layout')
@section('content')
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form method="POST" action=" ">
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

    <div class="col-lg-12 mt-4">
        <div class="card ">
            <div class="card-header pb-0 p-3">
                <h5 class="mb-0">ผู้ใช้งาน</h5>
                <p class="text-sm">ผู้ใช้งานทั้งหมด(อาจารย์)</p>
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="{{ route('admin.user_insert')}} " class="btn btn-danger ">เพิ่มผู้ใช้งาน </a>
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
            @if(count($users) > 0)
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">username</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">email</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">status</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">date</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Function</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($users as $item)
                        <div class="modal fade" id="edit{{$item->id}}" tabindex="-1" aria-labelledby="edit{{$item->id}}" aria-hidden="true">
                            <form method="POST" action="{{ route('admin.course_detail.subject_edit', $item->id)}}  ">
                                @csrf
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title fs-5" id="exampleModalLabel{{$item->id}}">แก้ไขข้อมูลรายวิชา</h2>
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
                                <div class="d-flex px-2 py-1">
                                    <div>
                                        <img src="../../../assets/img/kal-visuals-square.jpg" class="avatar avatar-sm me-3">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0">{{$item->user_detail->user_d_name}}</h6>
                                        <p class="text-xs text-secondary mb-0">{{$item->user_detail->user_d_name2}}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{$item->username}}</p>
                                <p class="text-xs text-secondary mb-0">Organization</p>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <span class="badge badge-sm badge-success bg-success">Online</span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{$item->created_at}}</span>
                            </td>
                            <td class="align-middle text-center">
                                <a href="{{ route('admin.user_detail', $item->id)}} " class="text-secondary font-weight-bold ms-3" data-toggle="tooltip">
                                    <i class="bi bi-pen"></i>
                                </a>
                                <a class="text-danger font-weight-bold ms-4" data-toggle="tooltip" data-original-title="Edit user" data-target="{{ route('admin.user_delete', $item->id) }}" onclick="Delete(this)">
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
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
