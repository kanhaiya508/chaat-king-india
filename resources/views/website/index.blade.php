@extends('website.layout')
@section('website')
    <!-- Hero Start -->
    <div class="container-fluid bg-light py-6 my-6 mt-0">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-7 col-md-12">
                    <small
                        class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-4 animated bounceInDown">Welcome
                        to CaterServ</small>
                    <h1 class="display-1 mb-4 animated bounceInDown">Book <span class="text-primary">Cater</span>Serv For Your
                        Dream Event</h1>
                    <a href=""
                        class="btn btn-primary border rounded-pill py-3 px-4 px-md-5 me-4 animated bounceInLeft">Book
                        Now</a>
                    <a href=""
                        class="btn btn-primary border rounded-pill py-3 px-4 px-md-5 animated bounceInLeft">Know More</a>
                </div>
                <div class="col-lg-5 col-md-12">
                    <img src="{{ asset('webasset/img/hero.png') }}" class="img-fluid rounded animated zoomIn"
                        alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->


    <!-- About Satrt -->
    <div class="container-fluid py-6">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5 wow bounceInUp" data-wow-delay="0.1s">
                    <img src="{{ asset('webasset/img/about.jpg') }}" class="img-fluid rounded" alt="">
                </div>
                <div class="col-lg-7 wow bounceInUp" data-wow-delay="0.3s">
                    <small
                        class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">About
                        Us</small>
                    <h1 class="display-5 mb-4">Trusted By 200 + satisfied clients</h1>
                    <p class="mb-4">Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore eit
                        esdioilore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullaemco laboeeiris nisi ut aliquip ex ea commodo consequat. Duis aute
                        irure
                        dolor iesdein reprehendeerit in voluptate velit esse cillum dolore.</p>
                    <div class="row g-4 text-dark mb-5">
                        <div class="col-sm-6">
                            <i class="fas fa-share text-primary me-2"></i>Fresh and Fast food Delivery
                        </div>
                        <div class="col-sm-6">
                            <i class="fas fa-share text-primary me-2"></i>24/7 Customer Support
                        </div>
                        <div class="col-sm-6">
                            <i class="fas fa-share text-primary me-2"></i>Easy Customization Options
                        </div>
                        <div class="col-sm-6">
                            <i class="fas fa-share text-primary me-2"></i>Delicious Deals for Delicious Meals
                        </div>
                    </div>
                    <a href="" class="btn btn-primary py-3 px-5 rounded-pill">About Us<i
                            class="fas fa-arrow-right ps-2"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Fact Start-->
    <div class="container-fluid faqt py-6">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-7">
                    <div class="row g-4">
                        <div class="col-sm-4 wow bounceInUp" data-wow-delay="0.3s">
                            <div class="faqt-item bg-primary rounded p-4 text-center">
                                <i class="fas fa-users fa-4x mb-4 text-white"></i>
                                <h1 class="display-4 fw-bold" data-toggle="counter-up">689</h1>
                                <p class="text-dark text-uppercase fw-bold mb-0">Happy Customers</p>
                            </div>
                        </div>
                        <div class="col-sm-4 wow bounceInUp" data-wow-delay="0.5s">
                            <div class="faqt-item bg-primary rounded p-4 text-center">
                                <i class="fas fa-users-cog fa-4x mb-4 text-white"></i>
                                <h1 class="display-4 fw-bold" data-toggle="counter-up">107</h1>
                                <p class="text-dark text-uppercase fw-bold mb-0">Expert Chefs</p>
                            </div>
                        </div>
                        <div class="col-sm-4 wow bounceInUp" data-wow-delay="0.7s">
                            <div class="faqt-item bg-primary rounded p-4 text-center">
                                <i class="fas fa-check fa-4x mb-4 text-white"></i>
                                <h1 class="display-4 fw-bold" data-toggle="counter-up">253</h1>
                                <p class="text-dark text-uppercase fw-bold mb-0">Events Complete</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 wow bounceInUp" data-wow-delay="0.1s">
                    <div class="video">
                        <button type="button" class="btn btn-play" data-bs-toggle="modal"
                            data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Video -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Youtube Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- 16:9 aspect ratio -->
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="" id="video" allowfullscreen
                            allowscriptaccess="always" allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fact End -->


    <!-- Service Start -->
    <div class="container-fluid service py-6">
        <div class="container">
            <div class="text-center wow bounceInUp" data-wow-delay="0.1s">
                <small
                    class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">Our
                    Services</small>
                <h1 class="display-5 mb-5">What We Offer</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 col-sm-12 wow bounceInUp" data-wow-delay="0.1s">
                    <div class="bg-light rounded service-item">
                        <div class="service-content d-flex align-items-center justify-content-center p-4">
                            <div class="service-content-icon text-center">
                                <i class="fas fa-cheese fa-7x text-primary mb-4"></i>
                                <h4 class="mb-3">Wedding Services</h4>
                                <p class="mb-4">Contrary to popular belief, ipsum is not simply random.</p>
                                <a href="#" class="btn btn-primary px-4 py-2 rounded-pill">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 wow bounceInUp" data-wow-delay="0.3s">
                    <div class="bg-light rounded service-item">
                        <div class="service-content d-flex align-items-center justify-content-center p-4">
                            <div class="service-content-icon text-center">
                                <i class="fas fa-pizza-slice fa-7x text-primary mb-4"></i>
                                <h4 class="mb-3">Corporate Catering</h4>
                                <p class="mb-4">Contrary to popular belief, ipsum is not simply random.</p>
                                <a href="#" class="btn btn-primary px-4 py-2 rounded-pill">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 wow bounceInUp" data-wow-delay="0.5s">
                    <div class="bg-light rounded service-item">
                        <div class="service-content d-flex align-items-center justify-content-center p-4">
                            <div class="service-content-icon text-center">
                                <i class="fas fa-hotdog fa-7x text-primary mb-4"></i>
                                <h4 class="mb-3">Cocktail Reception</h4>
                                <p class="mb-4">Contrary to popular belief, ipsum is not simply random.</p>
                                <a href="#" class="btn btn-primary px-4 py-2 rounded-pill">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 wow bounceInUp" data-wow-delay="0.7s">
                    <div class="bg-light rounded service-item">
                        <div class="service-content d-flex align-items-center justify-content-center p-4">
                            <div class="service-content-icon text-center">
                                <i class="fas fa-hamburger fa-7x text-primary mb-4"></i>
                                <h4 class="mb-3">Bento Catering</h4>
                                <p class="mb-4">Contrary to popular belief, ipsum is not simply random.</p>
                                <a href="#" class="btn btn-primary px-4 py-2 rounded-pill">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 wow bounceInUp" data-wow-delay="0.1s">
                    <div class="bg-light rounded service-item">
                        <div class="service-content d-flex align-items-center justify-content-center p-4">
                            <div class="service-content-icon text-center">
                                <i class="fas fa-wine-glass-alt fa-7x text-primary mb-4"></i>
                                <h4 class="mb-3">Pub Party</h4>
                                <p class="mb-4">Contrary to popular belief, ipsum is not simply random.</p>
                                <a href="#" class="btn btn-primary px-4 py-2 rounded-pill">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 wow bounceInUp" data-wow-delay="0.3s">
                    <div class="bg-light rounded service-item">
                        <div class="service-content d-flex align-items-center justify-content-center p-4">
                            <div class="service-content-icon text-center">
                                <i class="fas fa-walking fa-7x text-primary mb-4"></i>
                                <h4 class="mb-3">Home Delivery</h4>
                                <p class="mb-4">Contrary to popular belief, ipsum is not simply random.</p>
                                <a href="#" class="btn btn-primary px-4 py-2 rounded-pill">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 wow bounceInUp" data-wow-delay="0.5s">
                    <div class="bg-light rounded service-item">
                        <div class="service-content d-flex align-items-center justify-content-center p-4">
                            <div class="service-content-icon text-center">
                                <i class="fas fa-wheelchair fa-7x text-primary mb-4"></i>
                                <h4 class="mb-3">Sit-down Catering</h4>
                                <p class="mb-4">Contrary to popular belief, ipsum is not simply random.</p>
                                <a href="#" class="btn btn-primary px-4 py-2 rounded-pill">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 wow bounceInUp" data-wow-delay="0.7s">
                    <div class="bg-light rounded service-item">
                        <div class="service-content d-flex align-items-center justify-content-center p-4">
                            <div class="service-content-icon text-center">
                                <i class="fas fa-utensils fa-7x text-primary mb-4"></i>
                                <h4 class="mb-3">Buffet Catering</h4>
                                <p class="mb-4">Contrary to popular belief, ipsum is not simply random.</p>
                                <a href="#" class="btn btn-primary px-4 py-2 rounded-pill">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->




    <!-- Menu Start -->
    <div class="container-fluid menu bg-light py-6 my-6">
        <div class="container">
            <div class="text-center wow bounceInUp" data-wow-delay="0.1s">
                <small
                    class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">Our
                    Menu</small>
                <h1 class="display-5 mb-5">Most Popular Food in the World</h1>
            </div>
            <div class="tab-class text-center">
                <ul class="nav nav-pills d-inline-flex justify-content-center mb-5 wow bounceInUp" data-wow-delay="0.1s">
                    <li class="nav-item p-2">
                        <a class="d-flex py-2 mx-2 border border-primary bg-white rounded-pill active"
                            data-bs-toggle="pill" href="#tab-6">
                            <span class="text-dark" style="width: 150px;">Starter</span>
                        </a>
                    </li>
                    <li class="nav-item p-2">
                        <a class="d-flex py-2 mx-2 border border-primary bg-white rounded-pill" data-bs-toggle="pill"
                            href="#tab-7">
                            <span class="text-dark" style="width: 150px;">Main Course</span>
                        </a>
                    </li>
                    <li class="nav-item p-2">
                        <a class="d-flex py-2 mx-2 border border-primary bg-white rounded-pill" data-bs-toggle="pill"
                            href="#tab-8">
                            <span class="text-dark" style="width: 150px;">Drinks</span>
                        </a>
                    </li>
                    <li class="nav-item p-2">
                        <a class="d-flex py-2 mx-2 border border-primary bg-white rounded-pill" data-bs-toggle="pill"
                            href="#tab-9">
                            <span class="text-dark" style="width: 150px;">Offers</span>
                        </a>
                    </li>
                    <li class="nav-item p-2">
                        <a class="d-flex py-2 mx-2 border border-primary bg-white rounded-pill" data-bs-toggle="pill"
                            href="#tab-10">
                            <span class="text-dark" style="width: 150px;">Our Spesial</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-6" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-6 wow bounceInUp" data-wow-delay="0.1s">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Paneer</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 wow bounceInUp" data-wow-delay="0.2s">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Sweet Potato</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 wow bounceInUp" data-wow-delay="0.3s">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Sabudana Tikki</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 wow bounceInUp" data-wow-delay="0.4s">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Pizza</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 wow bounceInUp" data-wow-delay="0.5s">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Bacon</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 wow bounceInUp" data-wow-delay="0.6s">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Chicken</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 wow bounceInUp" data-wow-delay="0.7s">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Blooming</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 wow bounceInUp" data-wow-delay="0.8s">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Sweet</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-7" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Argentinian</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Crispy</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Sabudana Tikki</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Blooming</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Argentinian</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Lemon</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Water Drink</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Salty lemon</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-8" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Crispy water</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Juice</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Orange</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Apple Juice</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Banana</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Sweet Water</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Hot Coffee</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Sweet Potato</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-9" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Sabudana Tikki</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Crispy</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Pizza</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Bacon</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Chicken</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Blooming</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Sweet</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Argentinian</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-10" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Sabudana Tikki</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Crispy</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Pizza</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Bacon</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Chicken</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Blooming</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Sweet</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu-item d-flex align-items-center">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                            <h4>Argentinian</h4>
                                            <h4 class="text-primary">$90</h4>
                                        </div>
                                        <p class="mb-0">Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut
                                            labore.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Menu End -->



    <!-- Testimonial Start -->
    <div class="container-fluid py-6">
        <div class="container">
            <div class="text-center wow bounceInUp" data-wow-delay="0.1s">
                <small
                    class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">Testimonial</small>
                <h1 class="display-5 mb-5">What Our Customers says!</h1>
            </div>
            <div class="owl-carousel owl-theme testimonial-carousel testimonial-carousel-1 mb-4 wow bounceInUp"
                data-wow-delay="0.1s">
                <div class="testimonial-item rounded bg-light">
                    <div class="d-flex mb-3">
                        <img src="{{ asset('webasset/img/testimonial-1.jpg') }}"
                            class="img-fluid rounded-circle flex-shrink-0" alt="">
                        <div class="position-absolute" style="top: 15px; right: 20px;">
                            <i class="fa fa-quote-right fa-2x"></i>
                        </div>
                        <div class="ps-3 my-auto">
                            <h4 class="mb-0">Person Name</h4>
                            <p class="m-0">Profession</p>
                        </div>
                    </div>
                    <div class="testimonial-content">
                        <div class="d-flex">
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                        </div>
                        <p class="fs-5 m-0 pt-3">Lorem ipsum dolor sit amet elit, sed do eiusmod tempor ut labore et dolore
                            magna aliqua.</p>
                    </div>
                </div>
                <div class="testimonial-item rounded bg-light">
                    <div class="d-flex mb-3">
                        <img src="{{ asset('webasset/img/testimonial-2.jpg') }}"
                            class="img-fluid rounded-circle flex-shrink-0" alt="">
                        <div class="position-absolute" style="top: 15px; right: 20px;">
                            <i class="fa fa-quote-right fa-2x"></i>
                        </div>
                        <div class="ps-3 my-auto">
                            <h4 class="mb-0">Person Name</h4>
                            <p class="m-0">Profession</p>
                        </div>
                    </div>
                    <div class="testimonial-content">
                        <div class="d-flex">
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                        </div>
                        <p class="fs-5 m-0 pt-3">Lorem ipsum dolor sit amet elit, sed do eiusmod tempor ut labore et dolore
                            magna aliqua.</p>
                    </div>
                </div>
                <div class="testimonial-item rounded bg-light">
                    <div class="d-flex mb-3">
                        <img src="{{ asset('webasset/img/testimonial-3.jpg') }}"
                            class="img-fluid rounded-circle flex-shrink-0" alt="">
                        <div class="position-absolute" style="top: 15px; right: 20px;">
                            <i class="fa fa-quote-right fa-2x"></i>
                        </div>
                        <div class="ps-3 my-auto">
                            <h4 class="mb-0">Person Name</h4>
                            <p class="m-0">Profession</p>
                        </div>
                    </div>
                    <div class="testimonial-content">
                        <div class="d-flex">
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                        </div>
                        <p class="fs-5 m-0 pt-3">Lorem ipsum dolor sit amet elit, sed do eiusmod tempor ut labore et dolore
                            magna aliqua.</p>
                    </div>
                </div>
                <div class="testimonial-item rounded bg-light">
                    <div class="d-flex mb-3">
                        <img src="{{ asset('webasset/img/testimonial-4.jpg') }}"
                            class="img-fluid rounded-circle flex-shrink-0" alt="">
                        <div class="position-absolute" style="top: 15px; right: 20px;">
                            <i class="fa fa-quote-right fa-2x"></i>
                        </div>
                        <div class="ps-3 my-auto">
                            <h4 class="mb-0">Person Name</h4>
                            <p class="m-0">Profession</p>
                        </div>
                    </div>
                    <div class="testimonial-content">
                        <div class="d-flex">
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                        </div>
                        <p class="fs-5 m-0 pt-3">Lorem ipsum dolor sit amet elit, sed do eiusmod tempor ut labore et dolore
                            magna aliqua.</p>
                    </div>
                </div>
            </div>
            <div class="owl-carousel testimonial-carousel testimonial-carousel-2 wow bounceInUp" data-wow-delay="0.3s">
                <div class="testimonial-item rounded bg-light">
                    <div class="d-flex mb-3">
                        <img src="{{ asset('webasset/img/testimonial-1.jpg') }}"
                            class="img-fluid rounded-circle flex-shrink-0" alt="">
                        <div class="position-absolute" style="top: 15px; right: 20px;">
                            <i class="fa fa-quote-right fa-2x"></i>
                        </div>
                        <div class="ps-3 my-auto">
                            <h4 class="mb-0">Person Name</h4>
                            <p class="m-0">Profession</p>
                        </div>
                    </div>
                    <div class="testimonial-content">
                        <div class="d-flex">
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                        </div>
                        <p class="fs-5 m-0 pt-3">Lorem ipsum dolor sit amet elit, sed do eiusmod tempor ut labore et dolore
                            magna aliqua.</p>
                    </div>
                </div>
                <div class="testimonial-item rounded bg-light">
                    <div class="d-flex mb-3">
                        <img src="{{ asset('webasset/img/testimonial-2.jpg') }}"
                            class="img-fluid rounded-circle flex-shrink-0" alt="">
                        <div class="position-absolute" style="top: 15px; right: 20px;">
                            <i class="fa fa-quote-right fa-2x"></i>
                        </div>
                        <div class="ps-3 my-auto">
                            <h4 class="mb-0">Person Name</h4>
                            <p class="m-0">Profession</p>
                        </div>
                    </div>
                    <div class="testimonial-content">
                        <div class="d-flex">
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                        </div>
                        <p class="fs-5 m-0 pt-3">Lorem ipsum dolor sit amet elit, sed do eiusmod tempor ut labore et dolore
                            magna aliqua.</p>
                    </div>
                </div>
                <div class="testimonial-item rounded bg-light">
                    <div class="d-flex mb-3">
                        <img src="{{ asset('webasset/img/testimonial-3.jpg') }}"
                            class="img-fluid rounded-circle flex-shrink-0" alt="">
                        <div class="position-absolute" style="top: 15px; right: 20px;">
                            <i class="fa fa-quote-right fa-2x"></i>
                        </div>
                        <div class="ps-3 my-auto">
                            <h4 class="mb-0">Person Name</h4>
                            <p class="m-0">Profession</p>
                        </div>
                    </div>
                    <div class="testimonial-content">
                        <div class="d-flex">
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                        </div>
                        <p class="fs-5 m-0 pt-3">Lorem ipsum dolor sit amet elit, sed do eiusmod tempor ut labore et dolore
                            magna aliqua.</p>
                    </div>
                </div>
                <div class="testimonial-item rounded bg-light">
                    <div class="d-flex mb-3">
                        <img src="{{ asset('webasset/img/testimonial-4.jpg') }}"
                            class="img-fluid rounded-circle flex-shrink-0" alt="">
                        <div class="position-absolute" style="top: 15px; right: 20px;">
                            <i class="fa fa-quote-right fa-2x"></i>
                        </div>
                        <div class="ps-3 my-auto">
                            <h4 class="mb-0">Person Name</h4>
                            <p class="m-0">Profession</p>
                        </div>
                    </div>
                    <div class="testimonial-content">
                        <div class="d-flex">
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                        </div>
                        <p class="fs-5 m-0 pt-3">Lorem ipsum dolor sit amet elit, sed do eiusmod tempor ut labore et dolore
                            magna aliqua.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->


    <!-- Blog Start -->
    <div class="container-fluid blog py-6">
        <div class="container">
            <div class="text-center wow bounceInUp" data-wow-delay="0.1s">
                <small
                    class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">Our
                    Blog</small>
                <h1 class="display-5 mb-5">Be First Who Read News</h1>
            </div>
            <div class="row gx-4 justify-content-center">
                <div class="col-md-6 col-lg-4 wow bounceInUp" data-wow-delay="0.1s">
                    <div class="blog-item">
                        <div class="overflow-hidden rounded">
                            <img src="{{ asset('webasset/img/blog-1.jpg') }}" class="img-fluid w-100" alt="">
                        </div>
                        <div class="blog-content mx-4 d-flex rounded bg-light">
                            <div class="text-dark bg-primary rounded-start">
                                <div class="h-100 p-3 d-flex flex-column justify-content-center text-center">
                                    <p class="fw-bold mb-0">16</p>
                                    <p class="fw-bold mb-0">Sep</p>
                                </div>
                            </div>
                            <a href="#" class="h5 lh-base my-auto h-100 p-3">How to get more test in your food
                                from</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow bounceInUp" data-wow-delay="0.3s">
                    <div class="blog-item">
                        <div class="overflow-hidden rounded">
                            <img src="{{ asset('webasset/img/blog-2.jpg') }}" class="img-fluid w-100" alt="">
                        </div>
                        <div class="blog-content mx-4 d-flex rounded bg-light">
                            <div class="text-dark bg-primary rounded-start">
                                <div class="h-100 p-3 d-flex flex-column justify-content-center text-center">
                                    <p class="fw-bold mb-0">16</p>
                                    <p class="fw-bold mb-0">Sep</p>
                                </div>
                            </div>
                            <a href="#" class="h5 lh-base my-auto h-100 p-3">How to get more test in your food
                                from</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow bounceInUp" data-wow-delay="0.5s">
                    <div class="blog-item">
                        <div class="overflow-hidden rounded">
                            <img src="{{ asset('webasset/img/blog-3.jpg') }}" class="img-fluid w-100" alt="">
                        </div>
                        <div class="blog-content mx-4 d-flex rounded bg-light">
                            <div class="text-dark bg-primary rounded-start">
                                <div class="h-100 p-3 d-flex flex-column justify-content-center text-center">
                                    <p class="fw-bold mb-0">16</p>
                                    <p class="fw-bold mb-0">Sep</p>
                                </div>
                            </div>
                            <a href="#" class="h5 lh-base my-auto h-100 p-3">How to get more test in your food
                                from</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog End -->
@endsection
