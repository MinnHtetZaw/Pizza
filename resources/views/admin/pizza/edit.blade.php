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
                  <legend class="text-center">Edi Pizza</legend>
                </div>
                <div class="my-4 text-center">
                    <img src="{{ asset('uploads/'.$edit->image) }}" class="img-thumbnail "   style="width:200px;height:160px" alt="">
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <form class="form-horizontal" method="POST" action=" {{ route('admin#updatePizza',$edit->pizza_id) }}" enctype="multipart/form-data">
                          @csrf
                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" value="{{ old('name',$edit->pizza_name) }}" placeholder="Enter Pizza Name">

                            @if($errors->has('name'))

                                <p class="text-danger"> {{$errors->first('name')}}</p>
                            @endif
                          </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10">
                              <input type="file" class="form-control" name="image" value="" placeholder="Enter Image">

                              @if($errors->has('image'))

                                  <p class="text-danger"> {{$errors->first('image')}}</p>
                              @endif
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Price</label>
                            <div class="col-sm-10">
                              <input type="number" class="form-control" name="price" value="{{ old('price',$edit->price) }}" placeholder="Enter Price">

                              @if($errors->has('price'))

                                  <p class="text-danger"> {{$errors->first('price')}}</p>
                              @endif
                            </div>
                          </div>


                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Publish</label>
                            <div class="col-sm-10">
                                <select name="publish" class="form-control"  >
                                    <option value="">Choose Option...</option>
                                    @if ($edit->publish_status == 1 )
                                    <option value="1" selected>Publish</option>
                                    <option value="0">Unpublish</option>
                                    @elseif ($edit->publish_status == 0 )
                                    <option value="1">Publish</option>
                                    <option value="0" selected>Unpublish</option>
                                    @endif
                                </select>


                              @if($errors->has('publish'))

                                  <p class="text-danger"> {{$errors->first('publish')}}</p>
                              @endif
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">
                                <select name="category" class="form-control" >
                                    <option value=" {{$edit->category_id}} ">{{ $edit->category_name }}</option>


                                        @foreach ($category as $item )

                                        @if ($edit->category_id != $item->category_id)

                                             <option value=" {{ $item->category_id }} ">{{ $item->category_name }} </option>

                                        @endif
                                        @endforeach

                                </select>

                              @if($errors->has('name'))

                                  <p class="text-danger"> {{$errors->first('name')}}</p>
                              @endif
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Discount</label>
                            <div class="col-sm-10">
                              <input type="number" class="form-control" name="discount" value="{{ old('discount',$edit->discount_price) }}" placeholder="Enter Discount Price">

                              @if($errors->has('discount'))

                                  <p class="text-danger"> {{$errors->first('discount')}}</p>
                              @endif
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Buy 1 Get 1</label>
                            <div class="col-sm-10 mt-2">
                                @if ($edit->buy_one_get_one_status == 1)
                                <input type="radio" name="buyOneGetOne" value="1" class="form-input-check m-2" checked>Yes
                                @else
                                <input type="radio" name="buyOneGetOne" value="1" class="form-input-check m-2">Yes
                                @endif

                                @if ($edit->buy_one_get_one_status == 0)
                                <input type="radio" name="buyOneGetOne" value="0" class="form-input-check m-2" checked>No
                                @else
                                <input type="radio" name="buyOneGetOne" value="0" class="form-input-check m-2">No
                                @endif



                              @if($errors->has('buyOneGetOne'))

                                  <p class="text-danger"> {{$errors->first('buyOneGetOne')}}</p>
                              @endif
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Waiting Time</label>
                            <div class="col-sm-10">
                              <input type="number" class="form-control" name="waitingTime" value="{{ old('waitingTime',$edit->waiing_time) }}" placeholder="Enter Waiting Time">

                              @if($errors->has('waitingTime'))

                                  <p class="text-danger"> {{$errors->first('waitingTime')}}</p>
                              @endif
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                              <textarea name="description" class="form-control"  rows="3" placeholder="Enter Description">{{ old('description',$edit->description) }}</textarea>

                              @if($errors->has('description'))

                                  <p class="text-danger"> {{$errors->first('description')}}</p>
                              @endif
                            </div>
                          </div>



                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn bg-dark text-white">Add</button>
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
      </div>
    </section>
  </div>
@endsection
