@extends('dashboard.layouts.main')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="mb-4 text-primary">From {{ $title }}</h5>
        <form action="{{ route('unit.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="property_id" class="form-label">Property</label>
                        <select class="form-control @error('property_id') is-invalid @enderror" id="property_id" name="property_id" data-placeholder="Choose one thing">
                            <option value="">Select Property</option>
                            @foreach ($properties as $property)
                                <option value="{{ $property['id'] }}" {{ old('property_id') == $property['id'] ? 'selected' : '' }}>{{ $property['name_property'] }}</option>
                            @endforeach
                        </select>
                        @error('property_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="tipe" class="form-label">Tipe</label>
                        <select class="form-control @error('tipe') is-invalid @enderror" id="tipe" name="tipe" data-placeholder="Choose one thing">
                            <option value="">Select Tipe</option>
                            <option value="Deluxe" {{ old('tipe') == 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
                            <option value="Standard" {{ old('tipe') == 'Standard' ? 'selected' : '' }}>Standard</option>
                            <option value="Suite" {{ old('tipe') == 'Suite' ? 'selected' : '' }}>Suite</option>
                        </select>
                        @error('tipe')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="jumlah_kamar" class="form-label">Jumlah Kamar</label>
                        <input type="number" class="form-control @error('jumlah_kamar') is-invalid @enderror" id="jumlah_kamar" name="jumlah_kamar" value="{{ old('jumlah_kamar') }}">
                        @error('jumlah_kamar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="harga_unit" class="form-label">Harga Unit</label>
                        <input type="number" class="form-control @error('harga_unit') is-invalid @enderror" id="harga_unit" name="harga_unit" value="{{ old('harga_unit') }}">
                        @error('harga_unit')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                      @enderror
                    </div>

                    <div class="mb-3">
                        <label for="images" class="form-label">Images</label>
                        <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images[]" multiple>
                        @error('images')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    
                    {{-- <div class="card mb-3">
                        <div class="card-body bg-dark @error('images') is-invalid @enderror">
                            <input id="image-uploadify" type="file" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf" name="images[]" multiple>
                        </div>
                    </div> --}}
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
