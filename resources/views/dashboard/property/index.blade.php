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
                 <th>Category</th>
                 <th>gambar</th>
                 <th>Action</th>
              </tr>
           </thead>
           <tbody>
              @foreach ($properties as $item)
              <tr id="property-{{ $item['id'] }}">
                 <td>{{ $item['name'] }}</td>
                 <td>{{ $item['category']['name'] }}</td>
                 {{-- <td>{{ $item['alamat'] }}</td> --}}
                 <td>
                  <img src="{{ $item['image'] }}" alt="" width="100">
                </td>
                 <td class="d-flex">
                  <a href="javascript:void(0)" class="btn btn-warning btn-sm me-2" onclick="editProperty({{ $item['id']}})">
                    <span data-feather="edit"></span> Edit
                  </a>
                  
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
            <select class="form-control" id="category_id" name="category_id">
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
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title" id="editPropertyModalLabel">Edit Property</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editPropertyForm" method="POST">
          @csrf
          <input type="hidden" name="_method" value="PUT"> 
          <input type="hidden" name="id" id="edit_property_id">

          <div class="mb-3">
            <label for="edit_name" class="form-label">Name</label>
            <input type="text" class="form-control" id="edit_name" name="name">
          </div>
        
          <div class="mb-3">
            <label for="edit_category" class="form-label">Category</label>
            <select class="form-control" id="edit_category" name="category_id">
              <!-- Kategori akan diisi oleh JavaScript -->
            </select>
          </div>

          <div class="mb-3">
            <label for="edit_image" class="form-label">Property Image</label>
            <img id="edit_image" class="img-fluid" src="" width="100" alt="Property Image" />
          </div>
          

          <div class="mb-3">
            <label for="edit_alamat" class="form-label">edit_alamat</label>
            <textarea name="edit_alamat" id="edit_alamat" class="form-control" cols="20" rows="5"></textarea>
          </div>
          

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-warning">Update Porperty</button>
          </div>
        </form>
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
        console.log(response);
        if (response.success) {
          table.row.add([
            response.property.name,
            response.property.category.name,
            response.property.alamat,
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

    // edit Property
    window.editProperty = function(id) {
    $.ajax({
        url: '/property/' + id + '/edit', 
        type: 'GET',
        success: function(response) {
          console.log(response);
            if (response.success) {
              
                $('#edit_property_id').val(response.property.id);
                $('#edit_name').val(response.property.name);
                $('#edit_alamat').val(response.property.alamat);
                $('#edit_image').attr('src', response.property.image);
                $('#edit_category').empty();

                response.categories.forEach(function(category) {
                    var selected = category.id == response.property.category.id ? 'selected' : '';
                    $('#edit_category').append(
                        '<option value="' + category.id + '" ' + selected + '>' + category.name + '</option>'
                    );
                });

                $('#editPropertyModal').modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to fetch Property details.',
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'An error occurred while fetching category details.',
            });
        }
    });
};



    // Update Property
    $('#editPropertyForm').on('submit', function(e) {
    e.preventDefault();
    var id = $('#edit_property_id').val();
    var name = $('#edit_name').val();
    var slug = $('#edit_slug').val();

    $.ajax({
      url: '/property/' + id,
      type: 'PUT',
      data: {
        _token: '{{ csrf_token() }}',
        name: name,
        slug: slug
      },
      success: function(response) {
        if (response.success) {
          var row = $('#category-' + id); 

        // Update data dalam <tr>
          row.find('td').eq(0).text(response.category.name); // Update name
          row.find('td').eq(1).text(response.category.slug); // Update slug

          // Update action buttons dengan ID yang benar
          row.find('td').eq(2).html(
            '<a href="javascript:void(0)" class="btn btn-warning btn-sm me-2" onclick="editCategory(' + response.category.id + ')">Edit</a>' +
            '<button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' + response.category.id + ')">Delete</button>' // Update delete button
          );

          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Category has been updated successfully.',
            confirmButtonText: 'OK'
          });

          $('#editCategoryModal').modal('hide');
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Failed to update category.',
          });
        }
      },
      error: function() {
        Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: 'An error occurred while updating category.',
        });
      }
    });
  });


  window.confirmDelete = function(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: 'You won\'t be able to revert this!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: '/category/' + id,  // URL API untuk delete
        type: 'DELETE',
        data: {
          _token: '{{ csrf_token() }}',
        },
        success: function(response) {
          if (response.success) {
            // Remove the deleted row from the table
            $('#category-' + id).remove();
            Swal.fire({
              icon: 'success',
              title: 'Deleted!',
              text: 'Category has been deleted.',
              confirmButtonText: 'OK'
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong while deleting category.',
              confirmButtonText: 'OK'
            });
          }
        },
        error: function() {
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Failed to delete category. Please try again later.',
            confirmButtonText: 'OK'
          });
        }
      });
    }
  });
};

  });
</script>
@endsection

@endsection
