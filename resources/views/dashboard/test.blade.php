@extends('dashboard.layouts.main')
@section('content')
<div class="col d-flex align-items-stretch">
  <div class="card w-100 overflow-hidden rounded-4">
    <div class="card-body position-relative p-4">
      <div class="row">
      
        <div class="col-12 col-sm-5">
          <h5 class="mb-0">Form Modal</h5>
          <p class="my-3">In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to
            demonstrate the visual
            content. </p>
          <div class="">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-grd-primary px-4" data-bs-toggle="modal"
              data-bs-target="#FormModal">Click Me</button>
            <!-- Modal -->
            <div class="modal fade" id="FormModal">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header border-bottom-0 py-2 bg-grd-info">
                    <h5 class="modal-title">Registration Form</h5>
                    <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                      <i class="material-icons-outlined">close</i>
                    </a>
                  </div>
                  <div class="modal-body">
                    <div class="form-body">
                      <form class="row g-3">
                        <div class="col-md-12">
                          <label for="input7" class="form-label">Country</label>
                          <select id="input7" class="form-select">
                            {{-- <option selected="">Choose...</option> --}}
                            @foreach ($properties as $item)
                                <option value="{{ $item['id'] }}">{{ $item['name_category'] }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-md-12">
                          <div class="d-md-flex d-grid align-items-center gap-3">
                            <button type="button" class="btn btn-grd-danger px-4">Submit</button>
                            <button type="button" class="btn btn-grd-info px-4">Reset</button>
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
      </div><!--end row-->
      <div class="row">
        <div class="col-12 col-sm-7">
          <form action="/test" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="coba" class="form-label">Single select w/ allow clear</label>
                <select class="form-select @error('property_id') is-invalid @enderror" id="cobadua" data-placeholder="Choose one thing" name="property_id">
                  <option value="">Pilih</option>
                  @foreach ($properties as $item)
                      <option value="{{ $item['id'] }}">{{ $item['name_category'] }}</option>
                  @endforeach
                </select>
                @error('property_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
              <label for="alamat" class="form-label">Alamat</label>
              <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat">
              @error('alamat')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="harga" class="form-label">harga</label>
              <input type="text" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga">
              @error('harga')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="name" class="form-label">name</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
              @error('name')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="image" class="form-label">image</label>
              <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image[]" multiple>
              @error('image')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
              @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@section('scripts')
    <script>
      $(document).ready(function() {
    // Inisialisasi Select2 untuk elemen yang berada di luar modal
    $('#coba').select2({
        theme: "bootstrap-5",
        width: '100%',
        placeholder: "Choose one thing",
        allowClear: true
    });
    $('#cobadua').select2({
        theme: "bootstrap-5",
        width: '100%',
        placeholder: "Choose one thing",
        
    });

    // Inisialisasi Select2 setelah modal muncul
    $('#FormModal').on('shown.bs.modal', function () {
        $('#input7').select2({
            theme: "bootstrap-5",
            width: '100%',
            placeholder: "Choose...", 
            allowClear: true,
            dropdownParent: $('#FormModal') 
        });
    });

    // Hancurkan Select2 saat modal ditutup untuk menghindari masalah
    $('#FormModal').on('hidden.bs.modal', function () {
        $('#input7').select2('destroy');
    });
});

    </script>
@endsection
@endsection