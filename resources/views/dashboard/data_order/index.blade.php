@extends('dashboard.layouts.main')
@section('content')

<div class="mb-3">
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#propertyModal" id="createPropertyBtn">
     Tambah Data Order Baru
  </button>
</div>

<div class="card">
  <div class="card-body">
     <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
           <thead>
              <tr>
                 <th>Name Property</th>
                 <th>Kode Pemesanan</th>
                 <th>Nama Pembeli</th>
                 <th>No Invoice</th>
                 <th>Status Pembayaran</th>
                 <th>Action</th>
              </tr>
           </thead>
           <tbody>
              @foreach ($data_orders as $item)
              <tr id="dataorder-{{ $item['id_order'] }}">
                 <td>{{ $item['name_property'] }}</td>
                 <td>{{ $item['kode_pemesanan'] }}</td>
                 <td>{{ $item['nama_pembeli'] ?? 'Akun GUEST' }}</td>
                 <td>{{ $item['no_invoice'] }}</td>
                 <td>{{ $item['status'] }}</td>
                 <td class="d-flex">
                  <a href="javascript:void(0)" class="btn btn-warning btn-sm me-2" onclick="editProperty({{ $item['id_order']}})">
                    <span data-feather="edit"></span> Edit
                  </a>
                  {{-- <a href="/property/{{ $item['slug'] }}" class="btn btn-primary btn-sm me-2">Detail</a> --}}
                  <button type="submit" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $item['id_order'] }})">
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
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).ready(function() {
    var table = $('#example').DataTable();

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
            dropdownParent: $('#editPropertyModal') 
        });
    });

     $('#savePropertyBtn').on('click', function() {
   var formData = new FormData();
   formData.append('name_property', $('#name_property').val());
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
           console.log("Response from API:", response);
           if (response.success) {
               table.row.add([
                   response.property.name_property,
                   response.property.slug,
                   response.property.category.name_category,
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

           if (xhr.status === 422) {
               var errors = xhr.responseJSON.errors;
               $.each(errors, function(field, messages) {
                   $('#' + field).addClass('is-invalid'); // Add the 'is-invalid' class for the field
                   $('#' + field).next('.invalid-feedback').text(messages[0]); // Display error message
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
            if (response.success) {
                $('#edit_property_id').val(response.property.id);
                $('#edit_name_property').val(response.property.name_property);
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

    formData.append('name_property', $('#edit_name_property').val());
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
                var row = $('#property-' + id);
                row.find('td:eq(0)').text(response.property.name_property); 
                row.find('td:eq(1)').text(response.property.slug); 
                row.find('td:eq(2)').text(response.property.category.name_category); 
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
