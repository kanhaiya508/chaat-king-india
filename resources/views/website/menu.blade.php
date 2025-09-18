@extends('website.layout')
@section('website')
    <!-- Hero Start -->
    <div class="container-fluid bg-light py-6 my-6 mt-0">
        <div class="container text-center animated bounceInDown">
            <h1 class="display-1 mb-4">Our Menu</h1>
            <ol class="breadcrumb justify-content-center mb-0 animated bounceInDown">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item text-dark" aria-current="page">Menu</li>
            </ol>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Menu Start -->
    <div class="container-fluid menu py-6 my-6">
        <div class="container">

            <div class="tab-class text-center">
                <ul class="nav nav-pills d-inline-flex justify-content-center mb-5 wow bounceInUp" data-wow-delay="0.1s">
                    @foreach($categories as $index => $category)
                        @if($category->items->count() > 0)
                    <li class="nav-item p-2">
                                <a class="d-flex py-2 mx-2 border border-primary bg-white rounded-pill {{ $index === 0 ? 'active' : '' }}" 
                                   data-bs-toggle="pill" href="#tab-{{ $category->id }}">
                                    <span class="text-dark" style="width: 150px;">{{ $category->name }}</span>
                        </a>
                    </li>
                        @endif
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach($categories as $index => $category)
                        @if($category->items->count() > 0)
                            <div id="tab-{{ $category->id }}" class="tab-pane fade show p-0 {{ $index === 0 ? 'active' : '' }}">
                        <div class="row g-3">
                                    @foreach($category->items as $itemIndex => $item)
                                        <div class="col-lg-4 col-md-6">
                                            <div class="menu-item bg-white rounded-3 shadow-sm p-3 h-100 border border-2 position-relative" style="border-color: #e9ecef !important; transition: all 0.3s ease;">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h5 class="text-dark mb-0 fw-bold text-truncate" style="max-width: 200px;">{{ $item->name }}</h5>
                                                    <div class="text-end">
                                                        @if($item->variants->count() > 0)
                                                            <span class="badge bg-primary fs-6 px-2 py-1">From ₹{{ number_format($item->variants->min('price'), 0) }}</span>
                                                        @else
                                                            <span class="h6 text-primary mb-0 fw-bold">₹{{ number_format($item->price, 0) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                @if($item->description)
                                                    <p class="text-muted mb-3 small">{{ $item->description }}</p>
                                                @endif
                                                
                                                @if($item->variants->count() > 0)
                                                    <div class="mb-2">
                                                        <h6 class="text-dark mb-1 fw-semibold small">
                                                            <i class="fas fa-utensils text-primary me-1"></i>Sizes
                                                        </h6>
                                                        <div class="row g-1">
                                                            @foreach($item->variants as $variant)
                                                                <div class="col-12">
                                                                    <div class="d-flex justify-content-between align-items-center p-1 bg-light rounded-2">
                                                                        <span class="text-dark fw-medium small">
                                                                            @if(trim($variant->name) == '')
                                                                                {{ $item->name }}
                                                                            @else
                                                                                {{ $variant->name }}
                                                                            @endif
                                                                        </span>
                                                                        <span class="text-primary fw-bold small">₹{{ number_format($variant->price, 0) }}</span>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                @if($item->addons->count() > 0)
                                                    <div class="mb-2">
                                                        <h6 class="text-dark mb-1 fw-semibold small">
                                                            <i class="fas fa-plus-circle text-success me-1"></i>Add-ons
                                                        </h6>
                                                        <div class="row g-1">
                                                            @foreach($item->addons as $addon)
                                                                <div class="col-12">
                                                                    <div class="d-flex justify-content-between align-items-center p-1 bg-light rounded-2">
                                                                        <span class="text-dark small">{{ $addon->name }}</span>
                                                                        <span class="text-success fw-bold small">+₹{{ number_format($addon->price, 0) }}</span>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                               
                                            </div>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                        @endif
                    @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
    <!-- Menu End -->

    <!-- Call to Action -->
    <div class="container-fluid bg-primary py-6">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="text-white mb-3">Ready to Experience Authentic Indian Street Food?</h2>
                    <p class="text-white-50 mb-4">Visit us today and taste the authentic flavors of India's most beloved street food</p>
                    <a href="{{ route('contact') }}" class="btn btn-light btn-lg rounded-pill px-5">
                        <i class="fas fa-map-marker-alt me-2"></i>Find Us
                    </a>
                                    </div>
                                </div>
                            </div>
                        </div>
    <!-- Call to Action End -->
@endsection