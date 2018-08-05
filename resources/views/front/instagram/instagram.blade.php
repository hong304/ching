@extends('master')
@section('title', 'Ching He Huang Chinese Cooking | Instagram | ChingHeHuang.com')
@section('page-description','Instagram Posts of Ching')
@section('header-script')

@endsection

@section('content')

    <section class="offset-top bg-color white">
        <div class="container pt40 mb40">
            <div class="row m0">
                <div class="col-md-8 col-12 offset-md-2">
                    <div class="text-md-left text-center">
                        <div class="static-page-content">
                            <h1 class="static-content-title text-uppercase">Instagram</h1>

                            @foreach($items as $item)
                                <div class="col-md-4">
                                    <a href="{{$item['link']}}" target="_blank">
                                        <img src="{{$item['images']['low_resolution']['url']}}">
                                    </a>
                                </div>
                            @endforeach
                        </div><!-- end of .static-page-content -->

                    </div>
                </div>

            </div><!-- end of .row -->
        </div>
    </section>
@endsection

@section('footer-script')
@endsection