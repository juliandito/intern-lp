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
                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ Session::get('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form id="article-form" action="{{ route('admin.articles.update', ['id' => $article->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <div class="row" style="width: 100%">
                                        <div class="col-md-10">
                                            <h5>Edit Article</h5>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-block btn-primary">
                                                <i class="fas fa-save"></i> Save Changes
                                            </button>
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
                                            <input type="text" name="title" id="title" class="form-control" value="{{ $article->title }}">
                                            @error('title')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label class="col-md-1 col-form-label text-md-right">Slug</label>
                                        <div class="col-md-11">
                                            <input type="text" name="slug" id="slug" class="form-control" value="{{ $article->slug }}" autocomplete="off">
                                            <small id="slug-status"></small>
                                            @error('slug')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
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

                                    <div class="row form-group mb-4">
                                        <label class="col-md-1 col-form-label text-md-right">Article Status</label>
                                        <div class="col-md-4">
                                            <div class="selectgroup w-100">
                                                @if ($article->status == 'draft')
                                                    <label class="selectgroup-item">
                                                        <input class="selectgroup-input" type="radio" name="save_as" id="draft" value="draft" checked="checked">
                                                        <span class="selectgroup-button"><strong>DRAFT</strong></span>
                                                    </label>
                                                    <label class="selectgroup-item">
                                                        <input class="selectgroup-input" type="radio" name="save_as" id="published" value="published">
                                                        <span class="selectgroup-button"><strong>PUBLISHED</strong></span>
                                                    </label>
                                                @else
                                                    <label class="selectgroup-item">
                                                        <input class="selectgroup-input" type="radio" name="save_as" id="draft" value="draft">
                                                        <span class="selectgroup-button"><strong>DRAFT</strong></span>
                                                    </label>
                                                    <label class="selectgroup-item">
                                                        <input class="selectgroup-input" type="radio" name="save_as" id="published" value="published" checked="checked">
                                                        <span class="selectgroup-button"><strong>PUBLISHED</strong></span>
                                                    </label>
                                                @endif
                                            </div>
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
                                            <textarea name="content" id="content" cols="30" rows="10">
                                                {{ $article->content }}
                                            </textarea>
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
                    <img class="header-preview" src="{{ $article->thumbnail_image }}" alt="current header image" style="max-width: 750px">
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
                            <img class="header-preview" src="{{ $article->thumbnail_image }}" alt="current header image" style="max-width: 750px">
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
