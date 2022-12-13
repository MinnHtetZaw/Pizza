@extends('admin.layout.app')

@section('content')

<div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-8 offset-3 mt-5">
            <div class="col-md-9">
                <a href="{{ route('admin#pizza') }}" class="text-decoration-none"><div class="mb-4 text-dark"><i class="fa-solid fa-arrow-left"></i> back</div></a>
              <div class="card">
                <div class="card-header p-2">
                  <legend class="text-center">Pizza Info</legend>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane d-flex justify-content-evenly" id="activity">
                        <div class="mt-5">
                            <img src="{{ asset('uploads/'.$info->image) }}" class="img-thumbnail rounded-circle"   style="width:225px;height:225px;" alt="">

                        </div>
                        <div class="">

                            <div class="mt-3">
                                <b>Name</b> : <span>{{ $info->pizza_name }}</span>
                            </div>
                            <div class="mt-3">
                                <b>Price</b> : <span>{{ $info->price }} Kyats</span>
                            </div>
                            <div class="mt-3">
                                <b>Publish</b> :
                                @if ($info->publish_status == 0)
                                    <span>No</span>
                                @else
                                    <span>Yes</span>


                                @endif
                            </div>
                            <div class="mt-3">
                                <b>Category</b> : <span>{{ $info->category_id }}</span>
                            </div>
                            <div class="mt-3">
                                <b>Discount</b> : <span>{{ $info->discount }}</span>
                            </div>

                            <div class="mt-3">
                                <b>Buy One Get One</b> :
                                @if ($info->buy_one_get_one_status == 0)
                                <span>No</span>
                            @else
                                <span>Yes</span>


                            @endif
                            </div>

                            <div class="mt-3">
                                <b>Waiting Time</b> : <span>{{ $info->waiing_time }} minutes</span>
                            </div>

                            <div class="mt-3">
                                <b>Description</b> : <span>{{ $info->description }}</span>
                            </div>


                        </div>



                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
