<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Produk</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f8ff;
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
            background-color: #0d6efd;
            color: white;
            border-radius: 12px 12px 0 0;
        }

        .table thead {
            background-color: #0d6efd;
            color: white;
        }

        .btn-primary-custom {
            background-color: #0d6efd;
            border: none;
        }

        .btn-primary-custom:hover {
            background-color: #0b5ed7;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-end align-items-center mb-3">
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2"
                            data-bs-toggle="dropdown">

                            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" width="35"
                                class="rounded-circle">

                            <span>{{ auth()->user()->name }}</span>
                        </button>
                    </div>

                </div>

                <form action="{{ route('logout') }}" method="POST" class="text-end">
                    @csrf
                    <button class="btn btn-danger btn-sm">Logout</button>
                </form>
                <h3 class="text-center my-4 page-title">
                    List Produk
                </h3>

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
                                    <th style="width: 20%" class="text-center">ACTIONS</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Create Product -->
    <div class="modal fade" id="createProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Product</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Image</label>
                            <input type="file" name="image" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Nama produk" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" rows="3" class="form-control"
                                placeholder="Deskripsi produk"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Price</label>
                                <input type="number" name="price" class="form-control" placeholder="Harga" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Stock</label>
                                <input type="number" name="stock" class="form-control" placeholder="Stok" required>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary-custom text-white btn-submit-create">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Product -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
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
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti</small>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary-custom text-white btn-submit-edit">
                            Update
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
        @if(session('success'))
Swal.fire({
    icon: "success",
    title: "Berhasil",
    text: "{{ session('success') }}",
    timer: 2000,
    showConfirmButton: false
});
@elseif(session('error'))
Swal.fire({
    icon: "error",
    title: "Gagal",
    text: "{{ session('error') }}",
    timer: 2000,
    showConfirmButton: false
});
@endif

function confirmDelete(button) {
    Swal.fire({
        title: 'Yakin?',
        text: "Data ini akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    })
}

$(document).ready(function () {
    $('#products-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{{ route('products.datatable') }}",
        columns: [
            { data: 'image', name: 'image', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'price', name: 'price' },
            { data: 'stock', name: 'stock' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            zeroRecords: "Data tidak ditemukan",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            infoEmpty: "Data kosong",
            processing: "Memuat..."
        }
    });
});

$(document).on('click', '.btn-edit', function () {

    let id = $(this).data('id');

    $('#editProductForm').attr('action', '/products/' + id);

    $('#editTitle').val($(this).data('title'));
    $('#editDescription').val($(this).data('description'));
    $('#editPrice').val($(this).data('price'));
    $('#editStock').val($(this).data('stock'));
    $('#previewImage').attr('src',$(this).data('image'));

    $('#editProductModal').modal('show');
});

$('form[action="{{ route('products.store') }}"]').on('submit', function () {
        let btn = $(this).find('.btn-submit-create');

        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...');
    });

     $('#editProductForm').on('submit', function () {
        let btn = $(this).find('.btn-submit-edit');

        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm me-2"></span>Memperbarui...');
    });
    </script>

</body>

</html>