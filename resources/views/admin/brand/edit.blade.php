@extends('admin.admin_master')

@section('admin')
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show"
      role="alert">
      <strong>{{ session('success')  }}</strong>
      <button type="button" class="close" data-dismiss="alert"
        aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif
  <div class="py-12">
    <div class="container">
      <div class="row">

        <div class="col-md-8">
          <div class="card">
            {{-- Card Header --}}
            <div class="card-header"> Edit Brand </div>
            {{-- Start Card Body --}}
            <div class="card-body">
              {{--  Start Edit Form --}}
              <form action="{{ url('brand/update/'.$brands->id) }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                {{-- @php
                var_dump($brands->brand_image);
                @endphp --}}

                {{-- Place hidden field for old already inserted image --}}
                <input type="hidden" name="old_image" value="{{ $brands->brand_image }}">

                <div class="form-group">
                  {{--  ********* Form Group for Brand Name --}}
                  <label for="exampleInputEmail1">Update Brand Name</label>
                  <input type="text"
                    name="brand_name"
                    class="form-control"
                    id="exampleInputEmail1"
                    aria-describedby="emailHelp"
                    value="{{ $brands->brand_name }}"
                   >
                   @error('brand_name')
                      <span class="text-danger">{{ $message }}</span>
                   @enderror
                </div>

                {{--  ********** Form Group for Image ******** --}}
                <div class="form-group">

                  <label for="exampleInputEmail2">Update Brand Image</label>
                  <input type="file"
                    name="brand_image"
                    class="form-control"
                    id="exampleInputEmail2"
                    aria-describedby="emailHelp"
                    value="{{ $brands->brand_image }}"
                    >
                    @error('brand_image')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>
                {{--  ******** Display in Update Form the exiting in DB stores image --}}
                <div class="form-group">
                  <img src="{{ asset($brands->brand_image) }}" style="width: 400px; height: 200px;">
                </div>


                <button type="submit" class="btn btn-primary">Update Brand</button>
              </form>
              {{-- End Edit Form --}}

            </div>
            {{-- End Card Body  --}}


          </div>

        </div>


      </div>
    </div>



  </div>
@endsection
