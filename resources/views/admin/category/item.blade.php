@extends('admin.layout.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

      <div class="container-fluid">

        <div class="row mt-4">
          <div class="col-8 offset-2">
            <h4 class="my-4">{{ $pizza[0]->categoryName }}</h4>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <span class="fs-5 ml-5"> Total- {{ $pizza->total() }}</span>
                </h3>

              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">

                <table class="table table-hover text-nowrap text-center">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Pizza Image</th>
                      <th>Pizza Name</th>
                      <th>Price</th>

                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($pizza as $item )


                    <tr>
                      <td>{{ $item->pizza_id }}</td>
                      <td>
                          <img src="{{ asset('uploads/'.$item->image) }}" alt="" width="150px">
                      </td>
                      <td>{{$item->pizza_name}}</td>
                      <td>{{ $item->price  }}</td>
                    </tr>



                  @endforeach
                </tbody>
                </table>

                    <div class="col-md-6 offset-3 mt-4">
                        {{ $pizza->links() }}
                    </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <div class="">
                      <a href="{{ route('admin#category') }}"><button class="btn btn-dark">Back</button></a>
                  </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
