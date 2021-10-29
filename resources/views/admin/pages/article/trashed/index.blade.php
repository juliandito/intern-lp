@extends('admin.layouts.main')

@section('title', 'Articles')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Trashed Articles</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard')}}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.articles.all') }}">Articles</a></div>
                    <div class="breadcrumb-item"><a href="#">Trashed</a></div>
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

                        <div class="card">
                            <div class="card-body" id="category-table-container">
                                <div class="table-responsive">
                                    <table id="trashed-articles-table" class="table table-bordered table-striped">
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
                                            @foreach ($trashed_articles as $article)
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
                                                        <button class="restore-button btn btn-sm btn-success" data-id="{{ $article->id }}">
                                                            <i class="fas fa-trash-restore"></i> <b>RESTORE</b>
                                                        </button>

                                                        <a class="permanent-delete-button" href="{{ route('admin.articles.trashed.destroy', ['id' => $article->id]) }}" class="text-decoration-none">
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
    <div class="modal fade text-left" id="restoreArticleModal" tabindex="-1" role="dialog" aria-labelledby="restoreArticleModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="restoreArticleModalLabel">Restore Article</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="restore-article-form" action="" method="POST" data-article-id="">
                    @csrf
                    <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Restore As:</label>
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
                            <i class="fas fa-trash-restore"></i> Restore
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
            var table = $("#trashed-articles-table").DataTable({
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
        $(".permanent-delete-button").on('click', function (event) {
            event.preventDefault();

            const HREF = $(this).attr('href');

            Swal.fire({
                icon: 'warning',
                title: 'Hapus Permanen',
                text: 'Anda yakin akan menghapus artikel secara permanen?',
                showCancelButton: true,
                confirmButtonText: 'Ya!',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.value) {
                    document.location.href = HREF;
                }
            });
        });

        $(".restore-button").on('click', function (event) {
            // clean input that might be saved as state
            $('#restore-article-form')[0].reset();
            $('#restore-article-form').attr('action', '');
            $('#restore-article-form').attr('data-article-id', '');

            let articleId = $(this).attr('data-id');


            $.ajax({
                type: "GET",
                url: "{{ url('/admin-news-portal/api/articles/trashed-detail/') }}"+ "/" + articleId,
                dataType: "JSON",
                success: function ( result ) {
                    $('#restore-article-form').attr('action', result.data.restore_url);
                    $('#restore-article-form').attr('data-article-id', result.data.article.id);

                    if (result.data.article.status === "draft") {
                        $('#restore-article-form input#draft').attr('checked', 'checked');
                    } else {
                        $('#restore-article-form input#published').attr('checked', 'checked');
                    }

                    $('#restoreArticleModal').modal('show');
                },
                error: function(xhr, options, err){}
            });
        });

		function quickEdit(id) {

        }

    </script>
@endsection
