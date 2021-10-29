@extends('admin.layouts.main')

@section('title', 'Article Categories')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Article Categories</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Article Categories</a></div>
                    <div class="breadcrumb-item">All</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ Session::get('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('admin.article-categories.create')}} ">
                                    <button class="btn btn-sm btn-success">
                                        <b>
                                            <i class="fas fa-plus-circle"></i> CREATE
                                        </b>
                                    </button>
                                </a>
                            </div>
                            <div class="card-body" id="category-table-container">
                                <div class="table-responsive">
                                    <table id="data-table-no-print" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>
                                                    <i class="fas fa-cog"></i>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($article_categories as $category)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $category->name }}</td>
                                                    <td>{{ $category->description }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.article-categories.edit', ['id'=>$category->id]) }}">
                                                            <button class="btn btn-sm btn-warning">
                                                                <i class="fas fa-edit"></i> <b>EDIT</b>
                                                            </button>
                                                        </a>

                                                        @if ($category->article->count() > 0)
                                                            <button class="btn btn-sm btn-danger" disabled
                                                            data-toggle="tooltip" data-placement="left"  title="Masih ada artikel yang mempunyai kategori ini"
                                                            >
                                                                <i class="fas fa-trash"></i> <b>DELETE</b>
                                                            </button>
                                                        @else
                                                            <a role="button" class="delete-button" href="{{ route('admin.article-categories.delete', ['id'=>$category->id]) }}">
                                                                <button class="btn btn-sm btn-danger">
                                                                    <i class="fas fa-trash"></i> <b>DELETE</b>
                                                                </button>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var table = $("#data-table-no-print").DataTable({
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                buttons: [
                    'copyHtml5', 'pdfHtml5', 'csvHtml5',
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2 ]
                        }
                    },
                ],
                dom: 'Bfrtip',
            });

            $(".delete-button").click(function (event) {
                event.preventDefault();

                const HREF = $(this).attr('href');

                Swal.fire({
                    icon: 'warning',
                    title: 'Konfirmasi Hapus',
                    text: 'Anda yakin akan menghapus?',
                    showCancelButton: true,
                    confirmButtonText: 'Ya!',
                    cancelButtonColor: '#d33',
                }).then((result) => {
                    if (result.value) {
                        document.location.href = HREF;
                    }
                });
            });
        });
    </script>
@endsection
