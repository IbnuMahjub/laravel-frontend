@extends('dashboard.layouts.main')

@section('content')

<div class="mb-3">
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal" id="createCategoryBtn">
    Add Category
  </button>
</div>

<div class="card">
  <div class="card-body">
     <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
           <thead>
              <tr>
                 <th>Name</th>
                 <th>Slug</th>
                 <th>Action</th>
              </tr>
           </thead>
           <tbody>
              @foreach ($categories as $item)
              <tr id="category-{{ $item['id'] }}">
                 <td>{{ $item['name_category'] }}</td>
                 <td>{{ $item['slug'] }}</td>
                 <td class="d-flex">
                  {{-- Edit Button --}}
                  <a href="javascript:void(0)" class="btn btn-warning btn-sm me-2" onclick="editCategory({{ $item['id']}})">
                    <span data-feather="edit"></span> Edit
                  </a>
                  
                  {{-- Delete Button --}}
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

{{-- Add Category Modal --}}
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="categoryModalLabel">Add Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="categoryForm">
          @csrf
          <div class="mb-3">
            <label for="name_category" class="form-label">Name</label>
            <input type="text" class="form-control" id="name_category" name="name_category">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveCategoryBtn">Save Category</button>
      </div>
    </div>
  </div>
</div>

{{-- Edit Category Modal --}}
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editCategoryForm" method="POST"> <!-- Method tetap POST -->
          @csrf
          <input type="hidden" name="_method" value="PUT"> 
          <input type="hidden" name="id" id="edit_category_id">

          <div class="mb-3">
            <label for="edit_name" class="form-label">Name</label>
            <input type="text" class="form-control" id="edit_name_category" name="name_category">
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-warning">Update Category</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@section('scripts')
<script>
  $(document).ready(function() {
    var table = $('#example').DataTable();

    $('#saveCategoryBtn').on('click', function() {
      var name_category = $('#name_category').val();

      $.ajax({
        url: '{{ route("category.store") }}',
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          name_category: name_category
        },
        success: function(response) {
          if (response.success) {
            table.row.add([
              response.category.name_category,  
              response.category.slug, 
              '<a href="javascript:void(0)" class="btn btn-warning btn-sm me-2" onclick="editCategory(' + response.category.id + ')">Edit</a>' +
              '<button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' + response.category.id + ')">Delete</button>'
            ]).draw();  

            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Category has been added successfully.',
                confirmButtonText: 'OK'
            });

            $('#categoryModal').modal('hide');
            $('#categoryForm')[0].reset();
          } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong. Please try again!',
                confirmButtonText: 'OK'
            }); 
          }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to add category. Please try again later.',
                confirmButtonText: 'OK'
            });
        }
      });
    });

    // Edit Category
    window.editCategory = function(id) {
      $.ajax({
        url: '/category/' + id + '/edit', 
        type: 'GET',
        success: function(response) {
          if (response.success) {
            $('#edit_category_id').val(response.category.id);
            $('#edit_name_category').val(response.category.name_category);
            $('#editCategoryModal').modal('show');
          } else {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to fetch category details.',
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

    // Update Category
    $('#editCategoryForm').on('submit', function(e) {
      e.preventDefault();
      var id = $('#edit_category_id').val();
      var name = $('#edit_name_category').val();

      $.ajax({
        url: '/category/' + id,
        type: 'PUT',
        data: {
          _token: '{{ csrf_token() }}',
          name_category: name
        },
        success: function(response) {
          if (response.success) {
            var row = $('#category-' + id) ; 

            row.find('td').eq(0).text(response.category.name_category); 
            row.find('td').eq(1).text(response.category.slug);

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
            url: '/category/' + id,  
            type: 'DELETE',
            data: {
              _token: '{{ csrf_token() }}',
            },
            success: function(response) {
              if (response.success) {
                table.row('#category-' + id).remove().draw();
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
