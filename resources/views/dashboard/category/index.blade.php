@extends('dashboard.layouts.main')
@section('content')



<div class="mb-3">
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal" id="createCategoryBtn">
     Add Product
  </button>
</div>

<div class="card">
  <div class="card-body">
     <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
           <thead>
              <tr>
                 <th>Name</th>
                 <th>Slug</th>
                 <th>Action</th>
              </tr>
           </thead>
           <tbody>
              @foreach ($categories as $item)
              <tr>
                 <td>{{ $item['name'] }}</td>
                 <td>{{ $item['slug'] }}</td>
                 <td class="d-flex">
                  {{-- Tombol Edit --}}
                  <a href="/category/{{ $item['id'] }}/edit" class="btn btn-warning btn-sm me-2">
                    <span data-feather="edit"></span> Edit
                  </a>
                  
                  {{-- Tombol Hapus --}}
                  <form action="/category/{{ $item['id'] }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">
                      <span data-feather="x-circle"></span> Hapus
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
           </tbody>
        </table>
     </div>
  </div>
</div>

<!-- Modal -->
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
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>
          <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control" id="slug" name="slug">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveCategoryBtn">Save changes</button>
      </div>
    </div>
  </div>
</div>

@section('scripts')
<script>
  $(document).ready(function() {
    var table = $('#example').DataTable();

    // Event listener untuk klik tombol simpan
    $('#saveCategoryBtn').on('click', function() {
      var name = $('#name').val();
      var slug = $('#slug').val();

      // Kirim data ke backend menggunakan AJAX
      $.ajax({
        url: '{{ route("category.store") }}', // Arahkan ke route store
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          name: name,
          slug: slug
        },
        success: function(response) {
          if (response.success) {
            console.log(response);
            table.row.add([
              response.category.name,  
              response.category.slug, 
              '<button class="btn btn-warning btn-sm me-2">Edit</button>' +
              '<button class="btn btn-danger btn-sm">Delete</button>'
            ]).draw();  

            $('#categoryModal').modal('hide');
            $('#categoryForm')[0].reset();
          } else {
            alert(response.message); 
          }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText); 
            alert('Failed to add category. Please try again!');
        }
      });
    });
  });
</script>
@endsection



@endsection