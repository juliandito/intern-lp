@extends('admin.layouts.main')

@section('title', 'Articles')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/tinyMCE.css') }}">
@endsection

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Articles</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.articles.all') }}">Articles</a></div>
                    <div class="breadcrumb-item">Create</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ Session::get('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form id="article-form" action="{{ route('admin.articles.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <div class="row" style="width: 100%">
                                        <div class="col-md-8">
                                            <h5>Create New Article</h5>
                                        </div>
                                        <div class="col-md-2">
                                            <button id="save-draft-button" type="submit" class="btn btn-block btn-outline-primary">Save Draft</button>
                                        </div>
                                        <div class="col-md-2">
                                            <button id="publish-button" type="submit" class="btn btn-block btn-primary">Publish</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h6>Article Details</h6>
                                </div>
                                <div class="card-body">
                                    <div id="save-as-field" style="display: none">
                                        <input type="text" name="save_as" id="save_as" class="form-control" value="">
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label class="col-md-1 col-form-label text-md-right">Title</label>
                                        <div class="col-md-11">
                                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" autocomplete="off">
                                            @error('title')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label class="col-md-1 col-form-label text-md-right">Slug</label>
                                        <div class="col-md-11">
                                            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" autocomplete="off">
                                            <small id="slug-status"></small>
                                            @error('slug')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label class="col-md-1 col-form-label text-md-right">Article Category</label>
                                        <div class="col-md-9">
                                            <div id="article-category-selection">
                                                <select class="form-control" name="category" id="category">
                                                    <option value="" selected>Pilih kategori artikel--</option>
                                                    @forelse ($article_categories as $article_category)
                                                        <option class="form-control" value="{{ $article_category->id }}">
                                                            {{ $article_category->name }}
                                                        </option>
                                                    @empty
                                                        <option class="form-control" value="" selected>No available categories</option>
                                                    @endforelse

                                                </select>
                                                @error('category')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-block btn-success" data-toggle="modal" data-target="#addCategoryModal">
                                                <i class="fas fa-plus"></i> New Category
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label class="col-md-1 col-form-label text-md-right">Thumbnail Image</label>
                                        <div class="col-md-9">
                                            <input type="file" name="header_image" id="header_image" class="form-control" autocomplete="off">
                                            @error('header_image')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#viewHeaderImageModal">
                                                <i class="fas fa-eye"></i> Preview Thumbnail
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <div class="row w-100">
                                        <div class="col-sm-10">
                                            <h6>Article Contents</h6>
                                        </div>
                                        <div class="col-sm-2">
                                            <button id="preview-button" type="button" class="btn btn-block btn-info">
                                                <i class="fas fa-eye"></i> Preview Content
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row form-group mb-4">
                                        <div class="col-md-12">
                                            <textarea name="content" id="content" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('modal')
    <div class="modal fade text-left" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Article Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add-category-form" action="" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Description:</label>
                            <textarea class="form-control" id="description" name="description" cols="30" rows="6"></textarea>
                        </div>
                </div>
                <div class="modal-footer text-right">
                    <div class="p-2">
                        <div class="row">
                            <div class="col pr-0">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="viewHeaderImageModal" tabindex="-1" role="dialog" aria-labelledby="viewHeaderImageModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewHeaderImageModalLabel">Thumbnail Image Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img class="header-preview" src="" alt="header-image" style="max-width: 750px">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="articlePreviewModal" tabindex="-1" role="dialog" aria-labelledby="articlePreviewModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Article Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row text-center">
                        <div class="col">
                            <h3 id="title-preview"></h3>
                        </div>
                    </div>
                    <div class="row mt-4 text-center">
                        <div class="col">
                            <img class="header-preview" src="" alt="header-image" style="max-width: 750px">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div id="content-preview" class="col">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="https://cdn.tiny.cloud/1/ogyj3ibbxhhdlxazb5yn1nc1rpcouq4bqe3w884ykjknrlh7/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#save-draft-button').on('click', function(event) {
                event.preventDefault();
                $('input#save_as').val('draft');

                $('form#article-form').submit();
            });

            $('#publish-button').on('click', function(event) {
                event.preventDefault();
                $('input#save_as').val('published');

                $('form#article-form').submit();
            });

            const slugValidationUrl = "{{ route('admin.api.articles.validate-slug') }}";
            $('#slug').keyup(function(event) {
                var slug = $(this).val();

                $.post(slugValidationUrl, {
                        _method: 'POST',
                        _token: '{{ csrf_token() }}',
                        slug: slug,
                        article_id: '',
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
                    }
                );
            });

            $('#add-category-form').on('submit', function(event) {
                event.preventDefault();

                const formData = createFormData('add-category-form');
                const storeUrl = "{{ route('admin.api.article-categories.store') }}";

                $.post(storeUrl, {
                        _method: 'POST',
                        _token: '{{ csrf_token() }}',
                        admin_id: '{{ Auth::user()->id }}',
                        name: $('input#name').val(),
                        description: $('textarea#description').val(),
                    },
                    function (data) {
                        if (data.success) {
                            CustomSuccessSwal('Sukses', 'Berhasil ditambahkan ke daftar kategori!');

                            // refresh article category selections
                            $("#article-category-selection").load(" #article-category-selection");
                        } else {
                            CustomErrorSwal('Gagal', 'Mohon periksa isian');
                        }
                        $('#addCategoryModal').modal('hide');
                        $('#add-category-form')[0].reset();
                        return false;
                    }
                );
            });

            $("input[type='file']").on("change", function() {
                if (this.files[0].size > 5000000) {
                    CustomErrorSwal('Gagal', 'Ukuran file terlalu besar ( >5 MB )');

                    this.value = '';
                    return false;
                } else {

                    // check file extension
                    const pathFile = this.value;
                    const validExtensions = /(\.jpg|\.jpeg|\.png)$/i;
                    if(!validExtensions.exec(pathFile)){
                        CustomErrorSwal('Gagal', 'File harus bertipe .JPG, .JPEG atau .PNG');

                        this.value = '';
                        return false;
                    } else {
                        var oFReader = new FileReader();
                        oFReader.readAsDataURL(document.getElementById("header_image").files[0]);

                        oFReader.onload = function(oFREvent) {
                            $(".header-preview").attr('src', oFREvent.target.result)
                        };

                        CustomSuccessSwal('Sukses', 'Ukuran dan ekstensi file sudah tepat');
                    }
                }
            });

            const contentImagesUploadUrl = "{{ route('admin.api.articles.store-tinymce-image') }}";
            tinymce.init({
                selector: 'textarea#content',
                plugins: [
                    'advlist autolink lists link charmap print preview anchor imagetools',
                    'searchreplace visualblocks image code fullscreen',
                    'insertdatetime media table paste help wordcount'
                    ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | link image code | help',
                toolbar_sticky: true,
                height: 400,
                quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
                noneditable_noneditable_class: 'mceNonEditable',
                toolbar_mode: 'sliding',
                image_caption: true,
                images_upload_url: contentImagesUploadUrl,
                relative_urls: false,
                remove_script_host : false,
                convert_urls : true,
                file_picker_callback: function(field_name, url, type, win) {
                    // trigger file upload form
                    if (type == 'image') $('textarea#content').click();
                },
                content_style: 'body { font-family:Noto Sans,Helvetica,Arial,sans-serif; font-size:16px }'
            });

            $("#preview-button").on('click', function (event) {
                const currentEditorTitle = $('input#title').val();
                const currentEditorContent = tinymce.get("content").getContent();

                $("#title-preview").html(currentEditorTitle);
                $("#content-preview").html(currentEditorContent);

                $('#articlePreviewModal').modal('show');
            });

        });
    </script>
@endsection
