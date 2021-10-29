@extends('admin.layouts.main')

@section('title', 'Articles')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Articles</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard')}}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Articles</a></div>
                    <div class="breadcrumb-item">All</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="p-1 m-1">
                                    @foreach ($errors->all() as $error)
                                    <li>
                                        {{ $error }}
                                    </li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if(Session::has('delete_success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {!! Session::get('delete_success') !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('admin.articles.create')}}">
                                    <button class="btn btn-sm btn-success">
                                        <b>
                                            <i class="fas fa-plus-circle"></i> CREATE
                                        </b>
                                    </button>
                                </a>
                            </div>
                            <div class="card-body" id="category-table-container">
                                <div class="table-responsive">
                                    <table id="articles-table" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th>Created By</th>
                                                <th>
                                                    <i class="fas fa-cog"></i>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($articles as $article)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $article->title }}</td>
                                                    <td>{{ $article->category->name }}</td>
                                                    <td>
                                                        @if ($article->status == 'published')
                                                            <span class="badge badge-success shadow-sm font-weight-bold">{{ $article->status }}</span>
                                                        @elseif ($article->status == 'draft')
                                                            <span class="badge badge-secondary shadow-sm font-weight-bold">{{ $article->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                        $timezone = 'Asia/Jakarta';
                                                        $d = strtotime($article->created_at . ' ' . $timezone);
                                                        echo date("m/d/Y - h:i", $d) . ' WIB';
                                                        @endphp
                                                    </td>
                                                    <td>{{ $article->author->name }}</td>
                                                    <td>
                                                        {{-- <a href="" class="text-decoration-none">
                                                            <button class="btn btn-sm btn-info">
                                                                <i class="fas fa-eye"></i> <b>VIEW</b>
                                                            </button>
                                                        </a> --}}

                                                        <button class="btn btn-sm btn-primary" onclick="quickEdit({{$article->id}})">
                                                            <i class="fas fa-bolt"></i> <b>QUICK EDIT</b>
                                                        </button>

                                                        <a href="{{ route('admin.articles.edit', ['id'=>$article->id]) }}" class="text-decoration-none">
                                                            <button class="btn btn-sm btn-warning" >
                                                                <i class="fas fa-edit"></i> <b>EDIT</b>
                                                            </button>
                                                        </a>

                                                        <a class="delete-button" href="{{ route('admin.articles.delete', ['article' => $article->id]) }}" class="text-decoration-none">
                                                            <button class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i> <b>DELETE</b>
                                                            </button>
                                                        </a>
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

@section('modal')
    <div class="modal fade text-left" id="quickEditModal" tabindex="-1" role="dialog" aria-labelledby="quickEditModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quickEditModalLabel">Quick Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="quick-edit-form" action="" method="POST" data-article-id="">
                    @csrf
                    <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Title:</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Slug:</label>
                                <input type="text" class="form-control" id="slug" name="slug">
                                <small id="slug-status"></small>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Status:</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input class="selectgroup-input" type="radio" name="save_as" id="draft" value="draft">
                                        <span class="selectgroup-button"><strong>DRAFT</strong></span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input class="selectgroup-input" type="radio" name="save_as" id="published" value="published" >
                                        <span class="selectgroup-button"><strong>PUBLISHED</strong></span>
                                    </label>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Close
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $("#articles-table").DataTable({
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                dom: 'frtip',
                order: [[ 4, "desc" ]],
            });

            var sessionSuccessAlert = "{{ Session::has('success') }}";
            if (sessionSuccessAlert !== "") {
                let sessionSuccessAlertContent = "{{ Session::get('success') }}";
                CustomSuccessSwal('Sukses!', sessionSuccessAlertContent);
            }
        });
    </script>

    <script type="text/javascript">
        $(".delete-button").on('click', function (event) {
            event.preventDefault();

            const HREF = $(this).attr('href');

            Swal.fire({
                icon: 'warning',
                title: 'Konfirmasi Hapus',
                text: 'Anda yakin akan menghapus artikel?',
                showCancelButton: true,
                confirmButtonText: 'Ya!',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.value) {
                    document.location.href = HREF;
                }
            });
        });

		function quickEdit(id) {
            // clean input that might be saved as state
            $('#quick-edit-form')[0].reset();
            $('#quick-edit-form').attr('action', '');
            $('#quick-edit-form').attr('data-article-id', '');

            $.ajax({
                type: "GET",
                url: "{{ url('/admin-news-portal/api/articles/quick-edit/') }}"+ "/" + id,
                dataType: "JSON",
                success: function ( result ) {
                    $('#quick-edit-form input#title').val(result.data.article.title);
                    $('#quick-edit-form input#slug').val(result.data.article.slug);
                    $('#quick-edit-form').attr('action', result.data.quick_edit_update_url);
                    $('#quick-edit-form').attr('data-article-id', result.data.article.id);

                    if (result.data.article.status === "draft") {
                        $('#quick-edit-form input#draft').attr('checked', 'checked');
                    } else {
                        $('#quick-edit-form input#published').attr('checked', 'checked');
                    }

                    $('#quickEditModal').modal('show');
                },
                error: function(xhr, options, err){}
            });
        }

        const slugValidationUrl = "{{ route('admin.api.articles.validate-slug') }}";
        $('#quick-edit-form input#slug').keyup(function(event) {
            var slug = $(this).val();
            var article_id = $('#quick-edit-form').attr('data-article-id');

            $.post(slugValidationUrl, {
                _method: 'POST',
                _token: '{{ csrf_token() }}',
                slug: slug,
                article_id: article_id,
            },
            function (data) {
                if (data.success) {
                    $('#slug-status').attr('class', '');
                    $('#slug-status').attr('class', 'text-success');
                    $('#slug-status').text('');
                    $('#slug-status').text('Slug is available');
                } else {
                    $('#slug-status').attr('class', '');
                    $('#slug-status').attr('class', 'text-danger');
                    $('#slug-status').text('');
                    $('#slug-status').text('Slug is unavailable, please use another slug');
                }
                return false;
            });
        });
    </script>
@endsection
