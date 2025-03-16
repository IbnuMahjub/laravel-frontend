@extends('dashboard.layouts.main')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="mb-4 text-primary">Edit data {{ $title }}</h5>
        <form action="{{ route('unit.update', $units['id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="property_id" class="form-label">Property</label>
                        <select class="form-control" id="property_id" name="property_id" data-placeholder="Choose one thing">
                            <option value="{{ $units['property']['id'] }}">{{ $units['property']['name_property'] }}</option>
                            @foreach ($property as $item)
                                <option value="{{ $item['id'] }}">{{ $item['name_property'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tipe" class="form-label">Tipe</label>
                        <select class="form-control" id="tipe" name="tipe" data-placeholder="Choose one thing">
                            <option value="{{ $units['tipe'] }}">{{ $units['tipe'] }}</option>
                            <option value="Deluxe">Deluxe</option>
                            <option value="Standard">Standard</option>
                            <option value="Suite">Suite</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="{{ $units['deskripsi'] }}">
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_kamar" class="form-label">Jumlah Kamar</label>
                        <input type="number" class="form-control" id="jumlah_kamar" name="jumlah_kamar" value="{{ $units['jumlah_kamar'] }}">
                    </div>
                    <div class="mb-3">
                        <label for="harga_unit" class="form-label">Harga Unit</label>
                        <input type="number" class="form-control" id="harga_unit" name="harga_unit" value="{{ $units['harga_unit'] }}">
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">Images</label>
                        @foreach ($units['images'] as $index => $item) 
                            <img src="{{ $item }}" alt="Current Image" width="100">
                            {{-- <input type="hidden" name="imagesOri[]" value="{{ $units['oriImage'][$index] }}"> --}}
                        @endforeach
                    </div>
                    <div class="mb-3">
                        <label for="new-images" class="form-label">Upload New Images</label>
                        <input type="file" name="images[]" id="new-images" multiple>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#property_id').select2({
            theme: "bootstrap-5",
            width: '100%',
            placeholder: "Select Property",
        });
        $('#tipe').select2({
            theme: "bootstrap-5",
            width: '100%',
            placeholder: "Select Tipe",
        });

        $('#new-images').on('change', function (e) {
            const files = e.target.files;
            const previewContainer = $('#image-preview');
            previewContainer.empty();

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function(event) {
                    const img = $('<img />', {
                        src: event.target.result,
                        width: 100,
                        style: 'margin: 5px'
                    });
                    previewContainer.append(img); 
                };

                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection
