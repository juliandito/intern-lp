@extends('admin.layouts.main')

@section('title', 'Dashboard')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-chart">
                            <canvas id="balance-chart" height="80"></canvas>
                        </div>
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Published Articles</h4>
                            </div>
                            <div class="card-body">
                                <h3></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-chart">
                            <canvas id="balance-chart" height="80"></canvas>
                        </div>
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-archive"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Drafted Articles</h4>
                            </div>
                            <div class="card-body">
                                <h3></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-chart">
                            <canvas id="sales-chart" height="80"></canvas>
                        </div>
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Users</h4>
                            </div>
                            <div class="card-body">
                                <h3></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row w-100">
                                <div class="col-sm-10">
                                    <h6>Recent Articles</h6>
                                </div>
                                <div class="col-sm-2">
                                    <a href="" class="text-decoration-none">
                                        <button id="preview-button" type="button" class="btn btn-block btn-sm btn-info">
                                            <strong>DETAIL</strong>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="top-5-scroll">
                            <ul class="list-unstyled list-unstyled-border">
                                {{-- @forelse ($articles as $article)
                                    <li class="media">
                                        <img class="mr-3 rounded" width="100" src="{{ $article->header_image }}" alt="header-image">
                                        <div class="media-body">
                                            <div class="float-right">
                                                <div class="font-weight-600 text-muted text-small">
                                                    @php
                                                    $timezone = 'Asia/Jakarta';
                                                    $d = strtotime($article->created_at . ' ' . $timezone);
                                                    echo date("m/d/Y - h:i", $d) . ' WIB';
                                                    @endphp
                                                </div>
                                            </div>
                                            <div class="media-title">
                                                {{ $article->title }}
                                            </div>
                                            <div class="mt-2">
                                                <span class="text-muted">Created by: </span>
                                                <strong>{{ $article->author->name }}</strong>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <h3>Belum ada artikel</h3>
                                @endforelse --}}
                            </ul>
                        </div>
                        <div class="card-footer">
                            {{-- {{ $articles->links('pagination::bootstrap-4') }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $("#article-categories-id").DataTable({
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                dom: 'rtp',
            });

            var sessionSuccessAlert = "{{ Session::has('success') }}";
            if (sessionSuccessAlert !== "") {
                let sessionSuccessAlertContent = "{{ Session::get('success') }}";
                CustomSuccessSwal('Sukses!', sessionSuccessAlertContent);
            }
        });
    </script>
@endsection
