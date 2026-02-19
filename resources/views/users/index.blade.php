<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #f4f8ff; }
        .page-title { color: #0d6efd; font-weight: 600; }
        .card { border: none; border-radius: 12px; }
        .card-header-custom { background: #0d6efd; color: white; border-radius: 12px 12px 0 0; }
        .table thead { background: #0d6efd; color: white; }

        .btn-primary-custom {
            background: #0d6efd;
            border: none;
            color: #fff;
            font-weight: 500;
            padding: 8px 18px;
        }

        .btn-primary-custom:disabled {
            background: #0d6efd !important;
            color: #fff !important;
            opacity: 1 !important;
            cursor: not-allowed;
        }

        .btn-loading {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
    </style>
</head>

<body>
<div class="container mt-5">
<div class="row">
<div class="col-md-12">

<!-- TOP -->
<div class="d-flex justify-content-between align-items-start mb-3">

    <a href="{{ route('products.index') }}" class="btn btn-warning btn-sm fw-semibold">
        📦 Kelola Produk
    </a>

    <div class="text-end">
        <div class="d-flex align-items-center justify-content-end gap-2 mb-1">
            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" width="35" class="rounded-circle">
            <span class="fw-semibold">{{ auth()->user()->name }}</span>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end mb-3">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="btn btn-danger btn-sm w-100">Logout</button>
    </form>
</div>

<h3 class="text-center my-4 page-title">List User</h3>

<div class="card shadow-sm">
<div class="card-header card-header-custom">
    <div class="d-flex justify-content-between align-items-center">
        <span>Data Users</span>
        <button class="btn btn-light btn-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#createUserModal">
            + Add User
        </button>
    </div>
</div>

<div class="card-body bg-white">
<table class="table table-bordered table-hover" id="users-table">
<thead>
<tr>
    <th>AVATAR</th>
    <th>NAME</th>
    <th>EMAIL</th>
    <th width="20%" class="text-center">ACTIONS</th>
</tr>
</thead>
</table>
</div>
</div>

</div>
</div>
</div>

<!-- ================= MODAL CREATE ================= -->
<div class="modal fade" id="createUserModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content rounded-4 border-0 shadow">

<div class="modal-header bg-primary text-white">
    <h5 class="modal-title">Tambah User</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>

<form action="/users" method="POST" id="formCreate">
@csrf
<div class="modal-body">

<div class="mb-3">
<label class="form-label fw-semibold">Nama</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label fw-semibold">Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label fw-semibold">Password</label>
<input type="password" name="password" class="form-control" required>
</div>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
<button type="submit" class="btn btn-primary-custom btn-submit-create">
<span class="text">Simpan</span>
</button>
</div>
</form>

</div>
</div>
</div>

<!-- ================= MODAL EDIT ================= -->
<div class="modal fade" id="editUserModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content rounded-4 border-0 shadow">

<div class="modal-header bg-primary text-white">
<h5 class="modal-title">Edit User</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>

<form id="editUserForm" method="POST">
@csrf
@method('PUT')

<div class="modal-body">

<div class="mb-3">
<label class="form-label fw-semibold">Nama</label>
<input type="text" name="name" id="editName" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label fw-semibold">Email</label>
<input type="email" name="email" id="editEmail" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label fw-semibold">Password (opsional)</label>
<input type="password" name="password" class="form-control">
<small class="text-muted">Kosongkan jika tidak diganti</small>
</div>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
<button type="submit" class="btn btn-primary-custom btn-submit-edit">
<span class="text">Update</span>
</button>
</div>
</form>

</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
let table;

$(document).ready(function(){
table = $('#users-table').DataTable({
processing:true,
serverSide:true,
responsive:true,
ajax:"/users/datatable",
columns:[
{data:'avatar',orderable:false,searchable:false},
{data:'name'},
{data:'email'},
{data:'actions',orderable:false,searchable:false}
]
});
});

/* ================= EDIT ================= */
$(document).on('click','.btn-edit',function(){

let id=$(this).data('id');

$('#editUserForm').attr('action','/users/'+id);
$('#editName').val($(this).data('name'));
$('#editEmail').val($(this).data('email'));

$('#editUserModal').modal('show');
});

/* ================= LOADING BUTTON CREATE ================= */
$('#formCreate').on('submit',function(){
let btn=$(this).find('.btn-submit-create');

btn.prop('disabled',true);
btn.addClass('btn-loading');
btn.html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');
});

/* ================= LOADING BUTTON EDIT ================= */
$('#editUserForm').on('submit',function(){
let btn=$(this).find('.btn-submit-edit');

btn.prop('disabled',true);
btn.addClass('btn-loading');
btn.html('<span class="spinner-border spinner-border-sm"></span> Memperbarui...');
});

/* ================= SUCCESS ================= */
@if(session('success'))
$(document).ready(function(){

Swal.fire({
icon:'success',
title:'Berhasil',
text:"{{ session('success') }}",
timer:2000,
showConfirmButton:false
});

$('.btn-submit-create').prop('disabled',false).html('Simpan');
$('.btn-submit-edit').prop('disabled',false).html('Update');

$('#createUserModal').modal('hide');
$('#editUserModal').modal('hide');

if(table){
table.ajax.reload(null,false);
}

});
@endif

/* ================= ERROR ================= */
@if(session('error'))
$(document).ready(function(){
Swal.fire({
icon:'error',
title:'Gagal',
text:"{{ session('error') }}"
});
});
@endif

@if($errors->any())
$(document).ready(function(){

let msg = `{!! implode('<br>', $errors->all()) !!}`;

Swal.fire({
icon:'error',
title:'Validasi gagal',
html:msg
});

$('.btn-submit-create').prop('disabled',false).html('Simpan');
$('.btn-submit-edit').prop('disabled',false).html('Update');

});
@endif

/* ================= DELETE ================= */
$(document).on('click','.btn-delete',function(){

let id   = $(this).data('id');
let name = $(this).data('name');

Swal.fire({
title: 'Hapus user?',
text: "User "+name+" akan dihapus",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#d33',
confirmButtonText: 'Ya, hapus',
cancelButtonText: 'Batal'
}).then((result) => {

if(result.isConfirmed){

$.ajax({
url: '/users/' + id,
method: 'POST',   // <-- PENTING
data: {
    _token: '{{ csrf_token() }}',
    _method: 'DELETE'   // <-- Laravel delete method
},
success: function(res){

if(res.status === 'success'){

Swal.fire({
icon:'success',
title:'Berhasil',
text:res.message,
timer:1500,
showConfirmButton:false
});

table.ajax.reload(null,false);

}else{

Swal.fire({
icon:'error',
title:'Gagal',
text:res.message
});

}

},
error: function(xhr){

let msg = 'Terjadi kesalahan';

if(xhr.responseJSON && xhr.responseJSON.message){
    msg = xhr.responseJSON.message;
}

Swal.fire({
icon:'error',
title:'Error',
text: msg
});
}
});

}

});

});

</script>

</body>
</html>