@extends('dashboard.layouts.main')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="mb-4 text-primary">Edit data</h5>
        <form action="{{ route('unit.update', $units['id']) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="property_id" class="form-label">Property</label>
                        <select class="form-control" id="property_id" name="property_id" data-placeholder="Choose one thing">
                            <option value="">Select Property</option>
                            @foreach ($property as $item)
                                <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tipe" class="form-label">Tipe</label>
                        <select class="form-control" id="tipe" name="tipe" data-placeholder="Choose one thing">
                            <option value="">Select Tipe</option>
                            <option value="Deluxe">Deluxe</option>
                            <option value="Standard">Standard</option>
                            <option value="Suite">Suite</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">deskripsi</label>
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi">
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_kamar" class="form-label">jumlah_kamar</label>
                        <input type="number" class="form-control" id="jumlah_kamar" name="jumlah_kamar">
                    </div>
                    <div class="mb-3">
                        <label for="harga_unit" class="form-label">harga_unit</label>
                        <input type="number" class="form-control" id="harga_unit" name="harga_unit">
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">images</label>
                        <input type="file" class="form-control" id="images" name="images[]" multiple>
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
        $('#image-uploadify').imageuploadify();

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

    })
</script>
@endsection
