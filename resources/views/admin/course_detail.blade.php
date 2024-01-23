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
                    <label for="s_num" class="fs-6 mt-1 mb-0">รหัสวิชา123</label>
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

                <div class="row align-items-center">
                    <div class="col-lg-4 col-sm-8">
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a href="{{ route('admin.course_detail', $id)}}" class="nav-link mb-0 px-0 py-1  ">
                                        รายวิชา
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.course_detail', $id)}}" class=" nav-link mb-0 px-0 py-1 ">
                                        คณะกรรมการหลักสูตร
                                    </a>
                                </li>


                                <div class="moving-tab position-absolute nav-link" style="padding: 0px; width: 120px; transform: translate3d(171px, 0px, 0px); transition: all 0.5s ease 0s;"><a class="nav-link mb-0 px-0 py-1  " data-bs-toggle="tab" href="../../../examples/pages/account/settings.html" role="tab" aria-selected="true">-</a></div>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card ">
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
</div>
@endsection
