@extends('admin.layouts.layout')
@section('content')
<!-- Modal -->

<div class="row">
    <div class="col-12 mt-4">
        <div class="card mb-4 h-100">
            <div class="card-header pb-0 p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="mb-0">เลือกสาขา</h5>
                        <p class="text-sm">สาขาทั้งหมด</p>
                    </div>

                </div>
            </div>
            <div class="card-body p-3 ">
                <div class="row">
                    @foreach($programs as $item)
                    <div class="col-lg-2 g-3">
                        <div class="card" style="height:150px">
                            <span class="maskopacity-9 border-radius-xl"></span>
                            <div class="card-body p-3 position-relative">
                                <div class=" d-flex justify-content-start align-items-center">
                                    <div class=" text-start">
                                        <div class="icon icon-shape bg-white shadow text-center border-radius-md">
                                            <i class="ni ni-circle-08 text-dark text-gradient text-lg opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <h6 class="text-dark font-weight-bolder mb-0 mt-3">
                                            {{$item->p_name}}
                                        </h6>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>
                <!-- <ul class="list-group">
                    <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                        <div class="avatar me-3">
                            <img src="../../../assets/img/book (4).png" alt="kal" class="border-radius-lg shadow" style="padding: 8px;">
                        </div>
                        <div class="d-flex align-items-start flex-column justify-content-center">
                            <h6 class="mb-0 "> {{$item->p_name}}</h6>
                            <p class="mb-0 text-xs text-truncate" style="max-width: 80%; "> {{$item->p_detail}}</p>
                        </div>
                        <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto" href="{{ route('admin.course_all', $item->id)}}">เลือกสาขา</a>
                    </li>
                </ul> -->
            </div>
        </div>
    </div>
</div>
@endsection