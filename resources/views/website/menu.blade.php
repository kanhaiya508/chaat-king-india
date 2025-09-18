@extends('website.layout')
@section('website')
    <!-- Hero Start -->
    <div class="container-fluid bg-light py-6 my-6 mt-0">
        <div class="container text-center animated bounceInDown">
            <h1 class="display-1 mb-4">Menu</h1>
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
                        <li class="nav-item p-2">
                            <a class="d-flex py-2 mx-2 border border-primary bg-white rounded-pill {{ $index === 0 ? 'active' : '' }}" 
                               data-bs-toggle="pill" href="#tab-{{ $category->id }}">
                                <span class="text-dark" style="width: 150px;">{{ $category->name }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach($categories as $index => $category)
                        <div id="tab-{{ $category->id }}" class="tab-pane fade show p-0 {{ $index === 0 ? 'active' : '' }}">
                            <div class="row g-4">
                                @forelse($category->items as $itemIndex => $item)
                                    <div class="col-lg-6 wow bounceInUp" data-wow-delay="{{ ($itemIndex + 1) * 0.1 }}s">
                                        <div class="menu-item d-flex align-items-center">
                                            <div class="w-100 d-flex flex-column text-start ps-4">
                                                <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                                    <h4>{{ $item->name }}</h4>
                                                    <h4 class="text-primary">₹{{ number_format($item->price, 0) }}</h4>
                                                </div>
                                                <p class="mb-0">{{ $item->description ?: 'Delicious ' . $item->name . ' prepared with authentic spices and fresh ingredients.' }}</p>
                                                
                                                @if($item->variants->count() > 0)
                                                    <div class="mt-2">
                                                        <small class="text-muted">
                                                            <strong>Variants:</strong> 
                                                            @foreach($item->variants as $variant)
                                                                {{ $variant->name }} (₹{{ number_format($variant->price, 0) }}){{ !$loop->last ? ', ' : '' }}
                                                            @endforeach
                                                        </small>
                                                    </div>
                                                @endif
                                                
                                                @if($item->addons->count() > 0)
                                                    <div class="mt-1">
                                                        <small class="text-muted">
                                                            <strong>Add-ons:</strong> 
                                                            @foreach($item->addons as $addon)
                                                                {{ $addon->name }} (₹{{ number_format($addon->price, 0) }}){{ !$loop->last ? ', ' : '' }}
                                                            @endforeach
                                                        </small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 text-center">
                                        <p class="text-muted">No items available in this category yet.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Menu End -->
@endsection
