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
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th>Created By</th>
                                                <th>Like Count</th>
                                                <th>Comments Count</th>
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
                                                    <td>{{ $article->like->count() }}</td>
                                                    <td>{{ $article->comment->count() }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.articles.edit', ['id'=>$article->id]) }}" class="text-decoration-none">
                                                            <button class="btn btn-sm btn-warning" >
                                                                <i class="fas fa-edit"></i> <b>EDIT</b>
                                                            </button>
                                                        </a>

                                                        <a class="delete-button" href="{{ route('admin.articles.delete', ['id' => $article->id]) }}" class="text-decoration-none">
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
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $("#articles-table").DataTable({
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                dom: 'frtip',
                order: [[ 3, "desc" ]],
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
    </script>


@endsection
