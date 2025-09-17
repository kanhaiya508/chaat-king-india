@extends('website.layout')
@section('website')
    <!-- Hero Start -->
    <div class="container-fluid bg-light py-6 my-6 mt-0">
        <div class="container text-center animated bounceInDown">
            <h1 class="display-1 mb-4">Gallery</h1>
            <ol class="breadcrumb justify-content-center mb-0 animated bounceInDown">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
              
                <li class="breadcrumb-item text-dark" aria-current="page">Gallery</li>
            </ol>
        </div>
    </div>
    <!-- Hero End -->

    <!-- About Satrt -->
    <div class="container-fluid py-6">
        <div class="container">
            <div class="row g-2">
                <div class="col-3">
                    <img src="{{ asset('webasset/img/about.jpg') }}" class="img-fluid  border border-primary p-2"
                        alt="">
                </div>
                <div class="col-3">
                    <img src="{{ asset('webasset/img/about.jpg') }}" class="img-fluid border border-primary p-2"
                        alt="">
                </div>
                <div class="col-3">
                    <img src="{{ asset('webasset/img/about.jpg') }}" class="img-fluid border border-primary p-2"
                        alt="">
                </div>
                <div class="col-3">
                    <img src="{{ asset('webasset/img/about.jpg') }}" class="img-fluid border border-primary p-2"
                        alt="">
                </div>
                <div class="col-3">
                    <img src="{{ asset('webasset/img/about.jpg') }}" class="img-fluid border border-primary p-2"
                        alt="">
                </div>
                <div class="col-3">
                    <img src="{{ asset('webasset/img/about.jpg') }}" class="img-fluid border border-primary p-2"
                        alt="">
                </div>
            </div>
        </div>
    </div>
@endsection
