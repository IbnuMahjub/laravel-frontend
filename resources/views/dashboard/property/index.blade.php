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
                 <td>{{ $item['name'] }}</td>
                 <td>{{ $item['slug'] }}</td>
                 <td>{{ $item['category']['name'] }}</td>
                 {{-- <td>{{ $item['alamat'] }}</td> --}}
                 <td>
                  <img src="{{ $item['image'] }}" alt="" width="100">
                </td>
                 <td class="d-flex">
                  <a href="javascript:void(0)" class="btn btn-warning btn-sm me-2" onclick="editProperty({{ $item['id']}})">
                    <span data-feather="edit"></span> Edit
                  </a>
                  <a href="/property/{{ $item['id'] }}" class="btn btn-primary btn-sm me-2">Detail</a>
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

{{-- Add Property Modal --}}
<div class="modal fade" id="propertyModal" tabindex="-1" aria-labelledby="propertyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="propertyModalLabel">Add Property</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="propertyForm">
          @csrf
          <div class="mb-3">
            <label for="name" class="form-label">Name Property</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>
          <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-control" id="category_id" name="category_id" data-placeholder="Choose one thing">
              <option value="">Select Category</option>
              @foreach ($categories as $category)
                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat">
          </div>
          <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
          </div>
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
  <div class="modal-dialog">
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
          <div class="mb-3">
            <label for="edit_name" class="form-label">Name Property</label>
            <input type="text" class="form-control" id="edit_name" name="name">
          </div>
          <div class="mb-3">
            <label for="edit_category_id" class="form-label">Category</label>
            <select class="form-control" id="edit_category_id" name="category_id">
              @foreach ($categories as $category)
                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="edit_alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="edit_alamat" name="alamat">
          </div>
          <div class="mb-3">
            <label for="edit_image" class="form-label">Image</label>
            <input type="file" class="form-control" id="edit_image" name="image">
          </div>
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
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).ready(function() {
    var table = $('#example').DataTable();

    // select2 add modal
    $('#propertyModal').on('shown.bs.modal', function () {
        $('#category_id').select2({
            theme: "bootstrap-5",
            width: '100%',
            placeholder: $( this ).data( 'placeholder' ), 
            dropdownParent: $('#propertyModal') 
        });
    });

    // select2 edit modal
    $('#editPropertyModal').on('shown.bs.modal', function () {
        $('#edit_category_id').select2({
            theme: "bootstrap-5",
            width: '100%',
            placeholder: "Choose...",
            allowClear: true,
            dropdownParent: $('#editPropertyModal') // Pastikan dropdown muncul di dalam modal
        });
    });

    $('#savePropertyBtn').on('click', function() {
      var formData = new FormData();
      formData.append('name', $('#name').val());
      formData.append('category_id', $('#category_id').val());
      formData.append('alamat', $('#alamat').val());
      formData.append('image', $('#image')[0].files[0]);  
      
      $.ajax({
      url: '{{ route("property.store") }}',
      type: 'POST',
      _token: '{{ csrf_token() }}',
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        // console.log(response);
        console.log("Response from API:", response);
        if (response.success) {
          table.row.add([
            response.property.name,
            response.property.slug,
            response.property.category.name,
            '<img src="' + response.property.image + '" alt="Property Image" style="width: 100px;">',
            '<a href="javascript:void(0)" class="btn btn-warning btn-sm me-2" onclick="editCategory(' + response.property.id + ')">Edit</a>' +
            '<button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' + response.property.id + ')">Delete</button>'
          ]).draw();

          Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Property has been added successfully.',
                confirmButtonText: 'OK'
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
        Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: 'Failed to add property. Please try again later.',
          confirmButtonText: 'OK'
        });
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
            if (response.success) {
                $('#edit_property_id').val(response.property.id);
                $('#edit_name').val(response.property.name);
                $('#edit_category_id').val(response.property.category.id);
                $('#edit_alamat').val(response.property.alamat);
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

    formData.append('name', $('#edit_name').val());
    formData.append('category_id', $('#edit_category_id').val());
    formData.append('alamat', $('#edit_alamat').val());
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
                // Find the row by property ID and update it
                var row = $('#property-' + id);
                row.find('td:eq(0)').text(response.property.name); 
                row.find('td:eq(1)').text(response.property.slug); // Category
                row.find('td:eq(2)').text(response.property.category.name); // Category
                row.find('td:eq(3)').html('<img src="' + response.property.image + '" alt="Property Image" style="width: 100px;">'); // Image
                
                // Show success message
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
