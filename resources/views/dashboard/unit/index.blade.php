@extends('dashboard.layouts.main')
@section('content')

<div class="mb-3">
  <a href="/units/create" class="btn btn-primary">
     Add unit
  </a>
</div>

<div class="card">
  <div class="card-body">
     <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
           <thead>
              <tr>
                 <th>Name property</th>
                 <th>harga_unit</th>
                 <th>Tipe Unit</th>
                 <th>Action</th>
              </tr>
           </thead>
           <tbody>
              @foreach ($units as $item)
              <tr id="unit-{{ $item['id'] }}">
                 <td>{{ $item['property']['name'] }}</td>
                 <td>{{ $item['harga_unit'] }}</td>
                 <td>{{ $item['tipe'] }}</td>
                 <td class="d-flex">
                  <a href="/unit/{{ $item['id'] }}/edit" class="btn btn-warning btn-sm me-2">
                    <span data-feather="edit"></span> Edit
                  </a>
                  <a href="/unit/{{ $item['id'] }}" class="btn btn-primary btn-sm me-2">Detail</a>
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


@section('scripts')
<script>
  $(document).ready(function () {
        $('#example').DataTable();
  });

    @if(session('success'))
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: '{{ session('success') }}',
        });
    @endif

    @if(session('error'))
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: '{{ session('error') }}',
        });
    @endif


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
            deletUnit(id);
        }
    });

    function deletUnit(id) {
      $.ajax({
          url: '{{ url("unit") }}/' + id,
          type: 'DELETE',
          data: {
              _token: '{{ csrf_token() }}',  
          },
          success: function(response) {
              console.log("Response from API:", response);
              if (response.success) {
                  $('#unit-' + id).remove();
                  Swal.fire({
                      icon: 'success',
                      title: 'Deleted!',
                      text: 'unit has been deleted successfully.',
                      confirmButtonText: 'OK'
                  });
              } else {
                  Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: response.message || 'Failed to delete Unit.',
                      confirmButtonText: 'OK'
                  });
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              Swal.fire({
                  icon: 'error',
                  title: 'Error!',
                  text: 'Failed to delete Unit. Please try again later.',
                  confirmButtonText: 'OK'
              });
          }
      });
  }
}
</script>
@endsection

@endsection
