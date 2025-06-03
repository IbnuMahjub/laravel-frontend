@extends('dashboard.layouts.main')
@section('content')

<div class="mb-3">
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#propertyModal" id="createPropertyBtn">
     Add Property
  </button>
</div>

<div class="card">
  <div class="card-body">
     <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
           <thead>
              <tr>
                 <th>Name Property</th>
                 <th>Slug</th>
                 <th>Category</th>
                 <th>gambar</th>
                 <th>Action</th>
              </tr>
           </thead>
           <tbody>
              @foreach ($properties as $item)
              <tr id="property-{{ $item['id'] }}">
                 <td>{{ $item['name_property'] }}</td>
                 <td>{{ $item['slug'] }}</td>
                 <td>{{ $item['data_category']['name_category'] }}</td>
                 {{-- <td>{{ $item['alamat'] }}</td> --}}
                 <td>
                  <img src="{{ $item['image'] }}" alt="" width="100">
                </td>
                 <td class="d-flex">
                  <a href="javascript:void(0)" class="btn btn-warning btn-sm me-2" onclick="editProperty({{ $item['id']}})">
                    <span data-feather="edit"></span> Edit
                  </a>
                  <a href="/property/{{ $item['slug'] }}" class="btn btn-primary btn-sm me-2">Detail</a>
                  <button type="submit" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $item['id'] }})">
                    <span data-feather="x-circle"></span> Hapus
                  </button>
                </td>
              </tr>
              @endforeach
           </tbody>
        </table>
     </div>
  </div>
</div>


<div class="modal fade" id="propertyModal" tabindex="-1" aria-labelledby="propertyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="propertyModalLabel">Add Property</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="propertyForm">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="name_property" class="form-label">Name Property</label>
              <input type="text" class="form-control @error('name_property') is-invalid @enderror" id="name_property" name="name_property">
              @error('name_property')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label for="category_id" class="form-label">Category</label>
              <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                  <option value="{{ $category['id'] }}">{{ $category['name_category'] }}</option>
                @endforeach
              </select>
              @error('category_id')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="alamat" class="form-label">Alamat</label>
              <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat">
              @error('alamat')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label for="image" class="form-label">Image</label>
              <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
              @error('image')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="negara" class="form-label">Negara</label>
              <input type="text" class="form-control" id="negara">
            </div>
            <div class="col-md-6 mb-3">
              <label for="kota" class="form-label">Kota</label>
              <input type="text" class="form-control" id="kota">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="kecamatan" class="form-label">Kecamatan</label>
              <input type="text" class="form-control" id="kecamatan">
            </div>
          </div>
          <button type="button" class="btn btn-primary" id="searchLocationBtn">Cari Lokasi</button>

          <div class="row">
            <div class="col-md-6 mb-3 mt-4">
              <label for="longitude" class="form-label">Longitude</label>
              <input type="text" class="form-control" id="longitude" required readonly>
            </div>
            <div class="col-md-6 mb-3 mt-4">
              <label for="latitude" class="form-label">Latitude</label>
              <input type="text" class="form-control" id="latitude" required readonly>
            </div>
          </div>
          <div id="map" style="height: 400px;"></div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="savePropertyBtn">Save Category</button>
      </div>
    </div>
  </div>
</div>


{{-- Edit Property Modal --}}
<div class="modal fade" id="editPropertyModal" tabindex="-1" aria-labelledby="editPropertyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPropertyModalLabel">Edit Property</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editPropertyForm">
          @csrf
          @method('PUT')
          <input type="hidden" id="edit_property_id" name="id">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="edit_name_property" class="form-label">Name Property</label>
              <input type="text" class="form-control" id="edit_name_property" name="name_property">
            </div>
            <div class="col-md-6 mb-3">
              <label for="edit_category_id" class="form-label">Category</label>
              <select class="form-control" id="edit_category_id" name="category_id">
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                  <option value="{{ $category['id'] }}">{{ $category['name_category'] }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="edit_alamat" class="form-label">Alamat</label>
              <input type="text" class="form-control" id="edit_alamat" name="alamat">
            </div>
            <div class="col-md-6 mb-3">
              <label for="edit_image" class="form-label">Image</label>
              <input type="file" class="form-control" id="edit_image" name="image">
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="edit_negara" class="form-label">Negara</label>
              <input type="text" class="form-control" id="edit_negara" name="negara">
            </div>
            <div class="col-md-6 mb-3">
              <label for="edit_kota" class="form-label">Kota</label>
              <input type="text" class="form-control" id="edit_kota" name="kota">
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="edit_kecamatan" class="form-label">Kecamatan</label>
              <input type="text" class="form-control" id="edit_kecamatan" name="kecamatan">
            </div>
          </div>

          <button type="button" class="btn btn-primary" id="editSearchLocationBtn">Cari Lokasi</button>

          <div class="row">
            <div class="col-md-6 mb-3 mt-4">
              <label for="edit_longitude" class="form-label">Longitude</label>
              <input type="text" class="form-control" id="edit_longitude" name="longitude" readonly required>
            </div>
            <div class="col-md-6 mb-3 mt-4">
              <label for="edit_latitude" class="form-label">Latitude</label>
              <input type="text" class="form-control" id="edit_latitude" name="latitude" readonly required>
            </div>
          </div>

          <div id="edit_map" style="height: 400px;"></div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="updatePropertyBtn">Update Property</button>
      </div>
    </div>
  </div>
</div>




@section('scripts')
<script>
  let properties = {!! json_encode($properties) !!}
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).ready(function() {
    var table = $('#example').DataTable();
    var map;
    $('#propertyModal').on('shown.bs.modal', function () {

        map = L.map('map').setView([-6.1751, 106.8650], 13); 

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© Mrxnunu'
        }).addTo(map);

        var marker;

        map.on('click', function(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);
            $('#latitude').val(e.latlng.lat); 
            $('#longitude').val(e.latlng.lng); 
        });

        $('#category_id').select2({
            theme: "bootstrap-5",
            width: '100%',
            placeholder: $( this ).data( 'placeholder' ), 
            dropdownParent: $('#propertyModal') 
        });

        $('#searchLocationBtn').on('click', function() {
        var negara = $('#negara').val();
        var kota = $('#kota').val();
        var kecamatan = $('#kecamatan').val();
        // var street = $('#street').val();

        var address = `${kecamatan}, ${kota}, ${negara}`;
        
        // Lakukan request ke Nominatim
        $.ajax({
            url: 'https://nominatim.openstreetmap.org/search',
            data: {
                q: address,
                format: 'json',
                addressdetails: 1
            },
            success: function(data) {
                if (data.length > 0) {
                    var location = data[0];
                    var lat = location.lat;
                    var lon = location.lon;

                    map.setView([lat, lon], 13);

                    if (marker) {
                        map.removeLayer(marker);
                    }
                    
                    // Tambahkan marker di lokasi yang ditemukan
                    marker = L.marker([lat, lon]).addTo(map);
                    $('#latitude').val(lat);
                    $('#longitude').val(lon);
                } else {
                  
                    Swal.fire({
                        icon: 'error',
                        title: 'Lokasi Tidak Ditemukan',
                        text: 'Silakan periksa kembali input Anda.',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat mencari lokasi. Silakan coba lagi.',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    });

    // select2 edit modal
      let editMap;
      let editMarker;

      $('#editPropertyModal').on('shown.bs.modal', function () {
          // Inisialisasi map jika belum ada
          if (!editMap) {
              editMap = L.map('edit_map').setView([-6.1751, 106.8650], 13);
              L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                  maxZoom: 19,
                  attribution: '© OpenStreetMap contributors'
              }).addTo(editMap);

              editMap.on('click', function (e) {
                  if (editMarker) {
                      editMap.removeLayer(editMarker);
                  }
                  editMarker = L.marker(e.latlng).addTo(editMap);
                  $('#edit_latitude').val(e.latlng.lat);
                  $('#edit_longitude').val(e.latlng.lng);
              });
          }

          // Set posisi marker dan map berdasarkan data existing
          let lat = $('#edit_latitude').val();
          let lng = $('#edit_longitude').val();
          if (lat && lng) {
              editMap.setView([lat, lng], 13);
              if (editMarker) {
                  editMap.removeLayer(editMarker);
              }
              editMarker = L.marker([lat, lng]).addTo(editMap);
          }

          $('#edit_category_id').select2({
              theme: "bootstrap-5",
              width: '100%',
              placeholder: "Choose...",
              allowClear: true,
              dropdownParent: $('#editPropertyModal')
          });

          $('#editSearchLocationBtn').on('click', function () {
              var negara = $('#edit_negara').val();
              var kota = $('#edit_kota').val();
              var kecamatan = $('#edit_kecamatan').val();

              var address = `${kecamatan}, ${kota}, ${negara}`;

              $.ajax({
                  url: 'https://nominatim.openstreetmap.org/search',
                  data: {
                      q: address,
                      format: 'json',
                      addressdetails: 1
                  },
                  success: function (data) {
                      if (data.length > 0) {
                          var location = data[0];
                          var lat = location.lat;
                          var lon = location.lon;

                          editMap.setView([lat, lon], 13);

                          if (editMarker) {
                              editMap.removeLayer(editMarker);
                          }

                          editMarker = L.marker([lat, lon]).addTo(editMap);
                          $('#edit_latitude').val(lat);
                          $('#edit_longitude').val(lon);
                      } else {
                          Swal.fire({
                              icon: 'error',
                              title: 'Lokasi Tidak Ditemukan',
                              text: 'Silakan periksa kembali input Anda.',
                              confirmButtonText: 'OK'
                          });
                      }
                  },
                  error: function () {
                      Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: 'Terjadi kesalahan saat mencari lokasi. Silakan coba lagi.',
                          confirmButtonText: 'OK'
                      });
                  }
              });
          });

      });


     $('#savePropertyBtn').on('click', function() {
        var formData = new FormData();
        formData.append('name_property', $('#name_property').val());
        formData.append('category_id', $('#category_id').val());
        formData.append('alamat', $('#alamat').val());
        formData.append('latitude', $('#latitude').val());
        formData.append('longitude', $('#longitude').val());
        formData.append('negara', $('#negara').val());
        formData.append('kota', $('#kota').val());
        formData.append('kecamatan', $('#kecamatan').val());
        formData.append('image', $('#image')[0].files[0]);  

        $.ajax({
            url: '{{ route("property.store") }}',
            type: 'POST',
            _token: '{{ csrf_token() }}',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log("Response from API:", response);
                if (response.success) {
                    table.row.add([
                        response.property.name_property,
                        response.property.slug,
                        response.property.data_category.name_category,
                        // response.property.category.name_category,
                        '<img src="' + response.property.image + '" alt="Property Image" style="width: 100px;">',
                        '<a href="javascript:void(0)" class="btn btn-warning btn-sm me-2" onclick="editCategory(' + response.property.id + ')">Edit</a>' +
                        '<button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' + response.property.id + ')">Delete</button>'
                    ]).draw();

                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.pesan,
                        // confirmButtonText: 'OK'
                        showConfirmButton: false,
                        timer: 1500
                    });

                    $('#propertyModal').modal('hide');
                    $('#propertyForm')[0].reset();
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message || 'Something went wrong. Please try again!',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);

                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        $('#' + field).addClass('is-invalid'); 
                        $('#' + field).next('.invalid-feedback').text(messages[0]); 
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to add property. Please try again later.',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
        });

  });

  // fungsi edit dan update
  function editProperty(id) {
      $.ajax({
          url: '{{ url("property") }}/' + id + '/edit',
          type: 'GET',
          success: function(response) {
              console.log("Response from API:", response);
              if (response.success) {
                  $('#edit_property_id').val(response.property.id);
                  $('#edit_name_property').val(response.property.name_property);
                  // $('#edit_category_id').val(response.property.category.id);
                  $('#edit_category_id').val(response.property.data_category.id);
                  $('#edit_alamat').val(response.property.alamat);
                  $('#edit_negara').val(response.property.negara || '');
                  $('#edit_kota').val(response.property.kota || '');
                  $('#edit_kecamatan').val(response.property.kecamatan || '');
                  $('#edit_latitude').val(response.property.latitude || '');
                  $('#edit_longitude').val(response.property.longitude || '');

                  if (response.property.image) {
                      $('#edit_image').after(`
                          <div id="currentImagePreview" class="mt-2">
                              <img src="${response.property.image}" alt="Current Image" style="width: 100px;">
                          </div>
                      `);
                  }
                  $('#editPropertyModal').modal('show');
              } else {
                  Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: response.message || 'Failed to fetch property data',
                      confirmButtonText: 'OK'
                  });
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              Swal.fire({
                  icon: 'error',
                  title: 'Error!',
                  text: 'Failed to fetch property data. Please try again later.',
                  confirmButtonText: 'OK'
              });
          }
      });
  }

  $('#updatePropertyBtn').on('click', function() {
      var id = $('#edit_property_id').val();
      var formData = new FormData();
      var imageFile = $('#edit_image')[0].files[0];

      if (imageFile) {
          formData.append('image', imageFile);
      } else {
          console.log('No image file selected.');
      }

      formData.append('name_property', $('#edit_name_property').val());
      formData.append('category_id', $('#edit_category_id').val());
      formData.append('alamat', $('#edit_alamat').val());
      formData.append('negara', $('#edit_negara').val());
      formData.append('kota', $('#edit_kota').val());
      formData.append('kecamatan', $('#edit_kecamatan').val());
      formData.append('latitude', $('#edit_latitude').val());
      formData.append('longitude', $('#edit_longitude').val());    
      formData.append('_method', 'PUT');

      $.ajax({
          url: '{{ url("property") }}/' + id,
          type: 'POST',
          _token: '{{ csrf_token() }}',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
              console.log("Response from API:", response);
              if (response.success) {
                  var row = $('#property-' + id);
                  row.find('td:eq(0)').text(response.property.name_property); 
                  row.find('td:eq(1)').text(response.property.slug); 
                  row.find('td:eq(2)').text(response.property.data_category.name_category); 
                  // row.find('td:eq(2)').text(response.property.category.name_category); 
                  row.find('td:eq(3)').html('<img src="' + response.property.image + '" alt="Property Image" style="width: 100px;">'); // Image
                  
                  Swal.fire({
                      icon: 'success',
                      title: 'Success!',
                      text: 'Property has been updated successfully.',
                      confirmButtonText: 'OK'
                  });

                  // Hide the edit modal
                  $('#editPropertyModal').modal('hide');
              } else {
                  Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: response.message || 'Failed to update property',
                      confirmButtonText: 'OK'
                  });
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              Swal.fire({
                  icon: 'error',
                  title: 'Error!',
                  text: 'Failed to update property. Please try again later.',
                  confirmButtonText: 'OK'
              });
          }
      });
  });

  function confirmDelete(id) {
      Swal.fire({
          title: 'Are you sure?',
          text: 'You won\'t be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'Cancel'
      }).then((result) => {
          if (result.isConfirmed) {
              deleteProperty(id);
          }
      });
  }

  function deleteProperty(id) {
      $.ajax({
          url: '{{ url("property") }}/' + id,
          type: 'DELETE',
          data: {
              _token: '{{ csrf_token() }}',  
          },
          success: function(response) {
              console.log("Response from API:", response);
              if (response.success) {
                  $('#property-' + id).remove();
                  Swal.fire({
                      icon: 'success',
                      title: 'Deleted!',
                      text: 'Property has been deleted successfully.',
                      confirmButtonText: 'OK'
                  });
              } else {
                  Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: response.message || 'Failed to delete property.',
                      confirmButtonText: 'OK'
                  });
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              Swal.fire({
                  icon: 'error',
                  title: 'Error!',
                  text: 'Failed to delete property. Please try again later.',
                  confirmButtonText: 'OK'
              });
          }
      });
  }



  
</script>
@endsection

@endsection
