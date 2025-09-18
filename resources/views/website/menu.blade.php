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
            <div class="text-center mb-5">
                <small class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">Chaat King</small>
                <h1 class="display-5 mb-4">Authentic Indian Street Food</h1>
                <p class="lead text-muted">Experience the rich flavors of traditional Indian chaat and street food delicacies</p>
            </div>

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
                        <div class="row g-4">
                                    @foreach($category->items as $itemIndex => $item)
                                        <div class="col-lg-6 wow bounceInUp" data-wow-delay="{{ ($itemIndex + 1) * 0.1 }}s">
                                            <div class="menu-item bg-white rounded shadow-sm p-4 h-100 border">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h4 class="text-dark mb-0 fw-bold">{{ $item->name }}</h4>
                                                    <div class="text-end">
                                                        @if($item->variants->count() > 0)
                                                            <span class="badge bg-primary fs-6">From ₹{{ number_format($item->variants->min('price'), 0) }}</span>
                                                        @else
                                                            <span class="h5 text-primary mb-0 fw-bold">₹{{ number_format($item->price, 0) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                @if($item->description)
                                                    <p class="text-muted mb-3 small">{{ $item->description }}</p>
                                                @endif
                                                
                                                @if($item->variants->count() > 0)
                                                    <div class="mb-3">
                                                        <h6 class="text-dark mb-2 fw-semibold">
                                                            <i class="fas fa-utensils text-primary me-1"></i>Sizes
                                                        </h6>
                                                        <div class="row g-2">
                                                            @foreach($item->variants as $variant)
                                                                <div class="col-12">
                                                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                                                        <span class="text-dark fw-medium">
                                                                            @if(trim($variant->name) == '')
                                                                                {{ $item->name }}
                                                                            @else
                                                                                {{ $variant->name }}
                                                                            @endif
                                                                        </span>
                                                                        <span class="text-primary fw-bold">₹{{ number_format($variant->price, 0) }}</span>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                @if($item->addons->count() > 0)
                                                    <div class="mb-3">
                                                        <h6 class="text-dark mb-2 fw-semibold">
                                                            <i class="fas fa-plus-circle text-success me-1"></i>Add-ons
                                                        </h6>
                                                        <div class="row g-2">
                                                            @foreach($item->addons as $addon)
                                                                <div class="col-12">
                                                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                                                        <span class="text-dark">{{ $addon->name }}</span>
                                                                        <span class="text-success fw-bold">+₹{{ number_format($addon->price, 0) }}</span>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                <div class="text-center mt-3 pt-3 border-top">
                                                    <button class="btn btn-primary rounded-pill px-4">
                                                        <i class="fas fa-shopping-cart me-2"></i>Order Now
                                                    </button>
                                                </div>
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