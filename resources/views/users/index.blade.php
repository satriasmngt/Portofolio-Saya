<!DOCTYPE html>
<html lang="en">

<head>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Kelola User</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>

body{
background:#f4f8ff;
}

.page-title{
color:#0d6efd;
font-weight:600;
}

.card{
border:none;
border-radius:12px;
}

.card-header-custom{
background:#0d6efd;
color:white;
border-radius:12px 12px 0 0;
}

.table thead{
background:#0d6efd;
color:white;
}

.btn-primary-custom{
background:#0d6efd;
border:none;
color:#fff;
font-weight:500;
padding:8px 18px;
}

.btn-primary-custom:disabled{
background:#0d6efd!important;
opacity:0.6!important;
cursor:not-allowed;
}

.validation-icon{
font-size:18px;
}

</style>

</head>


<body>

<div class="container mt-5">
<div class="row">
<div class="col-md-12">


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

<button class="btn btn-light btn-sm fw-semibold"
data-bs-toggle="modal"
data-bs-target="#createUserModal">

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

<div class="input-group">

<input type="password"
name="password"
id="createPassword"
class="form-control"
required>

<button type="button"
class="btn btn-outline-secondary toggle-password"
data-target="createPassword">

<i class="bi bi-eye"></i>

</button>

</div>

</div>


<div class="mb-3">

<label class="form-label fw-semibold">Konfirmasi Password</label>

<div class="input-group">

<input type="password"
name="password_confirmation"
id="createPasswordConfirm"
class="form-control"
required>

<button type="button"
class="btn btn-outline-secondary toggle-password"
data-target="createPasswordConfirm">

<i class="bi bi-eye"></i>

</button>

<span class="input-group-text">
<i id="createPasswordIcon" class="bi validation-icon"></i>
</span>

</div>

<small id="createPasswordText"></small>

</div>


</div>


<div class="modal-footer">

<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

Batal

</button>

<button type="submit" class="btn btn-primary-custom btn-submit-create">
<span class="text">Simpan</span>
<span class="spinner-border spinner-border-sm d-none loading"></span>
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

<div class="input-group">

<input type="password"
name="password"
id="editPassword"
class="form-control">

<button type="button"
class="btn btn-outline-secondary toggle-password"
data-target="editPassword">

<i class="bi bi-eye"></i>

</button>

</div>

</div>


<div class="mb-3">

<label class="form-label fw-semibold">Konfirmasi Password</label>

<div class="input-group">

<input type="password"
name="password_confirmation"
id="editPasswordConfirm"
class="form-control">

<button type="button"
class="btn btn-outline-secondary toggle-password"
data-target="editPasswordConfirm">

<i class="bi bi-eye"></i>

</button>

<span class="input-group-text">
<i id="editPasswordIcon" class="bi validation-icon"></i>
</span>

</div>

<small id="editPasswordText"></small>

</div>

</div>


<div class="modal-footer">

<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

Batal

</button>

<button type="submit" class="btn btn-primary-custom btn-submit-edit">
<span class="text">Update</span>
<span class="spinner-border spinner-border-sm d-none loading"></span>
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

table=$('#users-table').DataTable({

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



/* EDIT USER */

$(document).on('click','.btn-edit',function(){

let id=$(this).data('id');

$('#editUserForm').attr('action','/users/'+id);

$('#editName').val($(this).data('name'));

$('#editEmail').val($(this).data('email'));

new bootstrap.Modal(document.getElementById('editUserModal')).show();

});



/* SHOW PASSWORD */

$(document).on('click','.toggle-password',function(){

let inputId=$(this).data('target');

let input=$('#'+inputId);

let icon=$(this).find('i');

if(input.attr('type')==='password'){

input.attr('type','text');

icon.removeClass('bi-eye').addClass('bi-eye-slash');

}else{

input.attr('type','password');

icon.removeClass('bi-eye-slash').addClass('bi-eye');

}

});



/* VALIDASI PASSWORD */

function validatePassword(pass,confirm,icon,text,button){

let p=$(pass).val();

let c=$(confirm).val();

let i=$(icon);

let t=$(text);

let b=$(button);


if(c.length===0){

i.removeClass().addClass('bi');

t.text('');

b.prop('disabled',false);

return;

}


if(p===c){

i.removeClass().addClass('bi bi-check-circle text-success');

t.text('Password cocok').removeClass('text-danger').addClass('text-success');

b.prop('disabled',false);

}else{

i.removeClass().addClass('bi bi-x-circle text-danger');

t.text('Password tidak cocok').removeClass('text-success').addClass('text-danger');

b.prop('disabled',true);

}

}



$('#createPassword,#createPasswordConfirm').on('keyup',function(){

validatePassword(
'#createPassword',
'#createPasswordConfirm',
'#createPasswordIcon',
'#createPasswordText',
'.btn-submit-create'
);

});


$('#editPassword,#editPasswordConfirm').on('keyup',function(){

validatePassword(
'#editPassword',
'#editPasswordConfirm',
'#editPasswordIcon',
'#editPasswordText',
'.btn-submit-edit'
);

});

/* ================= LOADING SUBMIT CREATE ================= */

$('#formCreate').on('submit', function(){

let btn = $('.btn-submit-create');

btn.prop('disabled', true);

btn.find('.text').text('Menyimpan...');

btn.find('.loading').removeClass('d-none');

});


/* ================= LOADING SUBMIT EDIT ================= */

$('#editUserForm').on('submit', function(){

let btn = $('.btn-submit-edit');

btn.prop('disabled', true);

btn.find('.text').text('Mengupdate...');

btn.find('.loading').removeClass('d-none');

});

/* ================= DELETE USER ================= */

$(document).on('click','.btn-delete',function(){

let id=$(this).data('id');
let name=$(this).data('name');

Swal.fire({
title: 'Hapus User?',
text: "User "+name+" akan dihapus!",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#d33',
cancelButtonColor: '#6c757d',
confirmButtonText: 'Ya, hapus!',
cancelButtonText: 'Batal'
}).then((result) => {

if(result.isConfirmed){

$.ajax({
url:'/users/'+id,
type:'DELETE',
data:{
_token:'{{ csrf_token() }}'
},

beforeSend:function(){

Swal.fire({
title:'Menghapus...',
text:'Harap tunggu',
allowOutsideClick:false,
didOpen:()=>{
Swal.showLoading()
}
});

},

success:function(res){

Swal.close();

if(res.status=='success'){

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

error:function(){

Swal.fire({
icon:'error',
title:'Error',
text:'Terjadi kesalahan server'
});

}

});

}

});

});

@if(session('success'))
document.addEventListener("DOMContentLoaded", function(){

Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session("success") }}',
    timer: 2000,
    showConfirmButton: false
});

});
@endif


@if(session('error'))
document.addEventListener("DOMContentLoaded", function(){

Swal.fire({
    icon: 'error',
    title: 'Gagal',
    text: '{{ session("error") }}'
});

});
@endif

</script>

</body>
</html>