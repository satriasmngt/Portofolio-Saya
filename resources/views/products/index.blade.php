<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f8ff;
        }

        .page-title {
            color: #0d6efd;
            font-weight: 600;
        }

        .card {
            border: none;
            border-radius: 12px;
        }

        .card-header-custom {
            background: #0d6efd;
            color: white;
            border-radius: 12px 12px 0 0;
        }

        .table thead {
            background: #0d6efd;
            color: white;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        /* ================= TOMBOL UTAMA ================= */
        .btn-primary-custom {
            background: #0d6efd;
            border: none;
            color: #fff;
            font-weight: 500;
            padding: 8px 18px;
            transition: 0.15s;
        }

        .btn-primary-custom:hover {
            background: #0d6efd;
            color: #fff;
        }

        .btn-primary-custom:focus {
            background: #0d6efd;
            color: #fff;
            box-shadow: 0 0 0 .15rem rgba(13, 110, 253, .3);
        }

        .btn-primary-custom:active {
            background: #0d6efd !important;
        }

        /* 🔥 INI YANG MEMPERBAIKI TOMBOL HILANG */
        .btn-primary-custom:disabled,
        .btn-primary-custom.disabled {
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

                    <a href="{{ route('users.index') }}" class="btn btn-warning btn-sm fw-semibold">
                        👤 Kelola User
                    </a>

                    <div class="text-end">
                        <div class="d-flex align-items-center justify-content-end gap-2 mb-1">
                            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" width="35"
                                class="rounded-circle">
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

                <h3 class="text-center my-4 page-title">List Produk</h3>

                <div class="card shadow-sm">
                    <div class="card-header card-header-custom">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Data Products</span>
                            <button class="btn btn-light btn-sm fw-semibold" data-bs-toggle="modal"
                                data-bs-target="#createProductModal">
                                + Add Product
                            </button>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <table class="table table-bordered table-hover" id="products-table">
                            <thead>
                                <tr>
                                    <th>IMAGE</th>
                                    <th>TITLE</th>
                                    <th>PRICE</th>
                                    <th>STOCK</th>
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
    <div class="modal fade" id="createProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Product</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
                    id="formCreate">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Image</label>
                            <input type="file" name="image" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" rows="3" class="form-control"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Price</label>
                                <input type="number" name="price" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Stock</label>
                                <input type="number" name="stock" class="form-control" required>
                            </div>
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
    <div class="modal fade" id="editProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form id="editProductForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Image</label>
                            <input type="file" name="image" class="form-control">
                            <small class="text-muted">Kosongkan jika tidak mengganti</small>
                            <div class="mt-2">
                                <img id="previewImage" width="120" class="rounded shadow-sm">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Title</label>
                            <input type="text" name="title" id="editTitle" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" id="editDescription" rows="3" class="form-control"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Price</label>
                                <input type="number" name="price" id="editPrice" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Stock</label>
                                <input type="number" name="stock" id="editStock" class="form-control" required>
                            </div>
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
/* ================= DATATABLE ================= */
let table;

$(document).ready(function(){
table = $('#products-table').DataTable({
processing:true,
serverSide:true,
responsive:true,
ajax:"{{ route('products.datatable') }}",
columns:[
{data:'image',orderable:false,searchable:false},
{data:'title'},
{data:'price'},
{data:'stock'},
{data:'actions',orderable:false,searchable:false}
]
});
});

/* ================= EDIT MODAL ================= */
$(document).on('click','.btn-edit',function(){
let id=$(this).data('id');

$('#editProductForm').attr('action','/products/'+id);
$('#editTitle').val($(this).data('title'));
$('#editDescription').val($(this).data('description'));
$('#editPrice').val($(this).data('price'));
$('#editStock').val($(this).data('stock'));
$('#previewImage').attr('src',$(this).data('image'));

$('#editProductModal').modal('show');
});

/* ================= LOADING BUTTON CREATE ================= */
$('#formCreate').on('submit',function(){
let btn=$(this).find('.btn-submit-create');

btn.prop('disabled',true);
btn.addClass('btn-loading');
btn.html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');
});

/* ================= LOADING BUTTON EDIT ================= */
$('#editProductForm').on('submit',function(){
let btn=$(this).find('.btn-submit-edit');

btn.prop('disabled',true);
btn.addClass('btn-loading');
btn.html('<span class="spinner-border spinner-border-sm"></span> Memperbarui...');
});

/* ================= DELETE CONFIRM ================= */
function confirmDelete(button){

Swal.fire({
title:'Yakin hapus?',
text:'Data tidak bisa dikembalikan!',
icon:'warning',
showCancelButton:true,
confirmButtonColor:'#d33',
cancelButtonColor:'#6c757d',
confirmButtonText:'Ya, hapus',
cancelButtonText:'Batal'
}).then((result)=>{

if(result.isConfirmed){

Swal.fire({
title:'Menghapus...',
text:'Mohon tunggu',
allowOutsideClick:false,
didOpen:()=>{Swal.showLoading();}
});

button.closest('form').submit();

}

});
}

/* ================= SWEETALERT SUCCESS ================= */
@if(session('success'))
$(document).ready(function(){

Swal.fire({
icon:'success',
title:'Berhasil',
text:"{{ session('success') }}",
timer:2000,
showConfirmButton:false
});

/* reset button */
$('.btn-submit-create').prop('disabled',false).html('Simpan');
$('.btn-submit-edit').prop('disabled',false).html('Update');

/* close modal */
$('#createProductModal').modal('hide');
$('#editProductModal').modal('hide');

/* reload datatable */
if(table){
table.ajax.reload(null,false);
}

});
@endif

/* ================= SWEETALERT ERROR SESSION ================= */
@if(session('error'))
$(document).ready(function(){
Swal.fire({
icon:'error',
title:'Gagal',
text:"{{ session('error') }}"
});
});
@endif

/* ================= VALIDATION ERROR ================= */
@if($errors->any())
$(document).ready(function(){

let msg = `{!! implode('<br>', $errors->all()) !!}`;

Swal.fire({
icon:'error',
title:'Validasi gagal',
html:msg
});

/* reset button */
$('.btn-submit-create').prop('disabled',false).html('Simpan');
$('.btn-submit-edit').prop('disabled',false).html('Update');

});
@endif
</script>

</body>

</html>