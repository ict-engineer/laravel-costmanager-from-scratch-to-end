@extends('user.user')
@section('csscontent')
<style>
.description {
        text-align: left;
        height: 20rem;
    }
</style>
@endsection
@section('content')
<!-- Home-Area -->
<header class="home-area overlay" id="home_page">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 hidden-sm col-md-5">
                    <figure class="mobile-image wow fadeInUp" data-wow-delay="0.2s">
                        <img src="{{ asset('landing/images/header-mobile.png') }}" alt="">
                    </figure>
                </div>
                <div class="col-xs-12 col-md-7">
                    <div class="space-80 hidden-xs"></div>
                    <h1 class="wow fadeInUp" data-wow-delay="0.4s">Start your amazing stuff through TheQuoteBox.</h1>
                    <div class="space-20"></div>
                    <div class="desc wow fadeInUp" data-wow-delay="0.6s">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiing elit, sed do eiusmod tempor incididunt ut labore et laborused sed do eiusmod tempor incididunt ut labore et laborused.</p>
                    </div>
                    <div class="space-20"></div>
                    @if (Route::has('register'))
                        @auth
                        @else
                            <a href="{{ route('register') }}" class="bttn-white wow fadeInUp ft20" data-wow-delay="0.8s">Get Started  <i class="lnr lnr-chevron-right"></i></a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </header>
    <!-- Home-Area-End -->
    <!-- About-Area -->
    <section class="section-padding" id="about_page">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-10 col-md-offset-1">
                    <div class="page-title text-center">
                        <img src="{{ asset('landing/images/about-logo.png') }}" alt="About Logo">
                        <div class="space-20"></div>
                        <h5 class="title">About TheQuoteBox</h5>
                        <div class="space-30"></div>
                        <h3 class="blue-color">A beautiful app for consectetur adipisicing elit, sed do eiusmod tempor incididunt ut mollit anim id est laborum. Sedut perspiciatis unde omnis. </h3>
                        <div class="space-20"></div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiing elit, sed do eiusmod tempor incididunt ut labore et laborused sed do eiusmod tempor incididunt ut labore et laborused.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About-Area-End -->
    <!-- Progress-Area -->
    <section class="progress-area gray-bg" id="progress_page">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="page-title section-padding">
                        <h5 class="title wow fadeInUp" data-wow-delay="0.2s">Our Progress</h5>
                        <div class="space-10"></div>
                        <h3 class="dark-color wow fadeInUp" data-wow-delay="0.4s">Grat Website Ever</h3>
                        <div class="space-20"></div>
                        <div class="desc wow fadeInUp" data-wow-delay="0.6s">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiing elit, sed do eiusmod tempor incididunt ut labore et laborused sed do eiusmod tempor incididunt ut labore et laborused.</p>
                        </div>
                        <div class="space-50"></div>
                        <a href="#" class="bttn-default wow fadeInUp" data-wow-delay="0.8s">Learn More</a>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <figure class="mobile-image">
                        <img src="{{ asset('landing/images/progress-phone.png') }}" alt="">
                    </figure>
                </div>
            </div>
        </div>
    </section>
    <!-- Progress-Area-End -->
    <!-- Video-Area -->
    <section class="video-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="video-photo">
                        <img src="{{ asset('landing/images/video-image.jpg') }}" alt="">
                        <a href="https://www.youtube.com/watch?v=ScrDhTsX0EQ" class="popup video-button">
                            <img src="{{ asset('landing/images/play-button.png') }}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 col-md-5 col-md-offset-1">
                    <div class="space-60 hidden visible-xs"></div>
                    <div class="page-title">
                        <h5 class="title wow fadeInUp" data-wow-delay="0.2s">VIDEO FEATURES</h5>
                        <div class="space-10"></div>
                        <h3 class="dark-color wow fadeInUp" data-wow-delay="0.4s">Grat Website Ever</h3>
                        <div class="space-20"></div>
                        <div class="desc wow fadeInUp" data-wow-delay="0.6s">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiing elit, sed do eiusmod tempor incididunt ut labore et laborused sed do eiusmod tempor incididunt ut labore et laborused.</p>
                        </div>
                        <div class="space-50"></div>
                        <a href="#" class="bttn-default wow fadeInUp" data-wow-delay="0.8s">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Video-Area-End -->
    <!-- Feature-Area -->
    <section class="feature-area section-padding-top" id="features_page">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                    <div class="page-title text-center">
                        <h5 class="title">Features</h5>
                        <div class="space-10"></div>
                        <h3>Powerful Features As Always</h3>
                        <div class="space-60"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="service-box wow fadeInUp" data-wow-delay="0.2s">
                        <div class="box-icon">
                            <i class="lnr lnr-rocket"></i>
                        </div>
                        <h4>Fast &amp; Powerful</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                    </div>
                    <div class="space-60"></div>
                    <div class="service-box wow fadeInUp" data-wow-delay="0.4s">
                        <div class="box-icon">
                            <i class="lnr lnr-paperclip"></i>
                        </div>
                        <h4>Easily Editable</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                    </div>
                    <div class="space-60"></div>
                    <div class="service-box wow fadeInUp" data-wow-delay="0.6s">
                        <div class="box-icon">
                            <i class="lnr lnr-cloud-download"></i>
                        </div>
                        <h4>Cloud Storage</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                    </div>
                    <div class="space-60"></div>
                </div>
                <div class="hidden-xs hidden-sm col-md-4">
                    <figure class="mobile-image">
                        <img src="{{ asset('landing/images/feature-image.png') }}" alt="Feature Photo">
                    </figure>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="service-box wow fadeInUp" data-wow-delay="0.2s">
                        <div class="box-icon">
                            <i class="lnr lnr-clock"></i>
                        </div>
                        <h4>Easy Notifications</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                    </div>
                    <div class="space-60"></div>
                    <div class="service-box wow fadeInUp" data-wow-delay="0.4s">
                        <div class="box-icon">
                            <i class="lnr lnr-laptop-phone"></i>
                        </div>
                        <h4>Fully Responsive</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                    </div>
                    <div class="space-60"></div>
                    <div class="service-box wow fadeInUp" data-wow-delay="0.6s">
                        <div class="box-icon">
                            <i class="lnr lnr-cog"></i>
                        </div>
                        <h4>Editable Layout</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                    </div>
                    <div class="space-60"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- Feature-Area-End -->
    <!-- Testimonial-Area -->
    <section class="testimonial-area" id="testimonial_page">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title text-center">
                        <h5 class="title">Testimonials</h5>
                        <h3 class="dark-color">Our Client Loves US</h3>
                        <div class="space-60"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="team-slide">
                        <div class="team-box">
                            <div class="team-image">
                                <img src="{{ asset('landing/images/team-1.jpg') }}" alt="">
                            </div>
                            <h4>Alex Bondarev</h4>
                            <h6 class="position">Client</h6>
                            <p>Lorem ipsum dolor sit amet, conseg sed do eiusmod temput laborelaborus ed sed do eiusmod tempo.</p>
                        </div>
                        <div class="team-box">
                            <div class="team-image">
                                <img src="{{ asset('landing/images/team-2.jpg') }}" alt="">
                            </div>
                            <h4>Alex Bondarev</h4>
                            <h6 class="position">Client</h6>
                            <p>Lorem ipsum dolor sit amet, conseg sed do eiusmod temput laborelaborus ed sed do eiusmod tempo.</p>
                        </div>
                        <div class="team-box">
                            <div class="team-image">
                                <img src="{{ asset('landing/images/team-3.jpg') }}" alt="">
                            </div>
                            <h4>Alex Bondarev</h4>
                            <h6 class="position">Client</h6>
                            <p>Lorem ipsum dolor sit amet, conseg sed do eiusmod temput laborelaborus ed sed do eiusmod tempo.</p>
                        </div>
                        <div class="team-box">
                            <div class="team-image">
                                <img src="{{ asset('landing/images/team-4.jpg') }}" alt="">
                            </div>
                            <h4>Alex Bondarev</h4>
                            <h6 class="position">Client</h6>
                            <p>Lorem ipsum dolor sit amet, conseg sed do eiusmod temput laborelaborus ed sed do eiusmod tempo.</p>
                        </div>
                        <div class="team-box">
                            <div class="team-image">
                                <img src="{{ asset('landing/images/team-2.jpg') }}" alt="">
                            </div>
                            <h4>Alex Bondarev</h4>
                            <h6 class="position">Client</h6>
                            <p>Lorem ipsum dolor sit amet, conseg sed do eiusmod temput laborelaborus ed sed do eiusmod tempo.</p>
                        </div>
                        <div class="team-box">
                            <div class="team-image">
                                <img src="{{ asset('landing/images/team-3.jpg') }}" alt="">
                            </div>
                            <h4>Alex Bondarev</h4>
                            <h6 class="position">Client</h6>
                            <p>Lorem ipsum dolor sit amet, conseg sed do eiusmod temput laborelaborus ed sed do eiusmod tempo.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonial-Area-End -->
    <!-- Gallery-Area -->
    <section class="gallery-area section-padding" id="gallery_page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-6 gallery-slider">
                    <div class="gallery-slide">
                        <div class="item"><img src="{{ asset('landing/images/gallery-1.jpg') }}" alt=""></div>
                        <div class="item"><img src="{{ asset('landing/images/gallery-2.jpg') }}" alt=""></div>
                        <div class="item"><img src="{{ asset('landing/images/gallery-3.jpg') }}" alt=""></div>
                        <div class="item"><img src="{{ asset('landing/images/gallery-4.jpg') }}" alt=""></div>
                        <div class="item"><img src="{{ asset('landing/images/gallery-1.jpg') }}" alt=""></div>
                        <div class="item"><img src="{{ asset('landing/images/gallery-2.jpg') }}" alt=""></div>
                        <div class="item"><img src="{{ asset('landing/images/gallery-3.jpg') }}" alt=""></div>
                        <div class="item"><img src="{{ asset('landing/images/gallery-1.jpg') }}" alt=""></div>
                        <div class="item"><img src="{{ asset('landing/images/gallery-2.jpg') }}" alt=""></div>
                        <div class="item"><img src="{{ asset('landing/images/gallery-3.jpg') }}" alt=""></div>
                        <div class="item"><img src="{{ asset('landing/images/gallery-4.jpg') }}" alt=""></div>
                        <div class="item"><img src="{{ asset('landing/images/gallery-1.jpg') }}" alt=""></div>
                        <div class="item"><img src="{{ asset('landing/images/gallery-2.jpg') }}" alt=""></div>
                        <div class="item"><img src="{{ asset('landing/images/gallery-3.jpg') }}" alt=""></div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-5 col-lg-3">
                    <div class="page-title">
                        <h5 class="white-color title wow fadeInUp" data-wow-delay="0.2s">Screenshots</h5>
                        <div class="space-10"></div>
                        <h3 class="white-color wow fadeInUp" data-wow-delay="0.4s">Screenshot 01</h3>
                    </div>
                    <div class="space-20"></div>
                    <div class="desc wow fadeInUp" data-wow-delay="0.6s">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiing elit, sed do eiusmod tempor incididunt ut labore et laborused sed do eiusmod tempor incididunt ut labore et laborused.</p>
                    </div>
                    <div class="space-50"></div>
                    <a href="#" class="bttn-default wow fadeInUp" data-wow-delay="0.8s">Learn More</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Gallery-Area-End -->
    <!-- How-To-Use -->
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="page-title">
                        <h5 class="title wow fadeInUp" data-wow-delay="0.2s">Our features</h5>
                        <div class="space-10"></div>
                        <h3 class="dark-color wow fadeInUp" data-wow-delay="0.4s">Aour Approach of Design is Prety Simple and Clear</h3>
                    </div>
                    <div class="space-20"></div>
                    <div class="desc wow fadeInUp" data-wow-delay="0.6s">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiing elit, sed do eiusmod tempor incididunt ut labore et laborused sed do eiusmod tempor incididunt ut labore et laborused.</p>
                    </div>
                    <div class="space-50"></div>
                    <a href="#" class="bttn-default wow fadeInUp" data-wow-delay="0.8s">Learn More</a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-5 col-md-offset-1">
                    <div class="space-60 hidden visible-xs"></div>
                    <div class="service-box wow fadeInUp" data-wow-delay="0.2s">
                        <div class="box-icon">
                            <i class="lnr lnr-clock"></i>
                        </div>
                        <h4>Easy Notifications</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
                    </div>
                    <div class="space-50"></div>
                    <div class="service-box wow fadeInUp" data-wow-delay="0.2s">
                        <div class="box-icon">
                            <i class="lnr lnr-laptop-phone"></i>
                        </div>
                        <h4>Fully Responsive</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
                    </div>
                    <div class="space-50"></div>
                    <div class="service-box wow fadeInUp" data-wow-delay="0.2s">
                        <div class="box-icon">
                            <i class="lnr lnr-cog"></i>
                        </div>
                        <h4>Editable Layout</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- How-To-Use-End -->
    <!-- Download-Area -->
    <div class="download-area overlay">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 hidden-sm">
                    <figure class="mobile-image">
                        <img src="{{ asset('landing/images/download-image.png') }}" alt="">
                    </figure>
                </div>
                <div class="col-xs-12 col-md-6 section-padding">
                    <h3 class="white-color">Download The App</h3>
                    <div class="space-20"></div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam possimus eaque magnam eum praesentium unde.</p>
                    <div class="space-60"></div>
                    <a href="#" class="bttn-white sq"><img src="{{ asset('landing/images/apple-icon.png') }}" alt="apple icon"> Apple Store</a>
                    <a href="#" class="bttn-white sq"><img src="{{ asset('landing/images/play-store-icon.png') }}" alt="Play Store Icon"> Play Store</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Download-Area-End -->
    <!--Price-Area -->
    <section class="section-padding price-area" id="price_page">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title text-center">
                        <h5 class="title">Pricing Plan</h5>
                        <h3 class="dark-color">Our Awesome Pricing Plan</h3>
                        <div class="space-60"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($payments as $payment)
                <div class="col-xs-12 col-sm-{{ 12/count($payments) }}">
                    <div class="price-box" style="height:75%;min-width:215px;">
                        <div class="price-header">
                            <div class="price-icon">
                            @if ($loop->index == 0)
                                <span class="lnr lnr-rocket"></span>
                            @elseif ($loop->index == 1)
                                <span class="lnr lnr-diamond"></span>
                            @else
                                <span class="lnr lnr-pie-chart"></span>
                            @endif
                            </div>
                            <h4 style="text-transform: uppercase;">{{ $payment->name }}</h4>
                        </div>
                        <div class="price-body">
                            <ul>
                                <li class="description" data-id="{{ $loop->index }}"></li>
                            </ul>
                        </div>
                        <div class="price-rate"  style="padding-left:1rem;padding-right:1rem;">
                            <span class="rate">{{ $payment->price }}</span> <small>{{ $payment->currency }}/{{ __('messages.Month') }}</small>
                        </div>
                        <div class="price-footer">
                            <a href="javascript:void(0)" class="bttn-white purchaseBtn" style="margin-right:0px;" data-id='{{ $loop->index }}'>{{ __('messages.Purchase') }}</br>{{ __('messages.1 Month Trial') }}</a>
                        </div>
                    </div>
                    <div class="space-30 hidden visible-xs"></div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--Price-Area-End -->
    <!--Questions-Area -->
    <section id="questions_page" class="questions-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title text-center">
                        <h5 class="title">FAQ</h5>
                        <h3 class="dark-color">Frequently Asked Questions</h3>
                        <div class="space-60"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="toggole-boxs">
                        <h3>Faq first question goes here? </h3>
                        <div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                        </div>
                        <h3>About freewuent question goes here? </h3>
                        <div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                        </div>
                        <h3>Why more question goes here? </h3>
                        <div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                        </div>
                        <h3>What question goes here? </h3>
                        <div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="space-20 hidden visible-xs"></div>
                    <div class="toggole-boxs">
                        <h3>Faq second question goes here? </h3>
                        <div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                        </div>
                        <h3>Third faq question goes here? </h3>
                        <div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                        </div>
                        <h3>Why more question goes here? </h3>
                        <div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                        </div>
                        <h3>Seventh frequent question here? </h3>
                        <div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Questions-Area-End -->
@endsection
@section('jscontent')
<script>
var payments = {!! $payments !!};
        for(var i = 0; i < payments.length; i ++)
        {
            $('li[data-id="'+i+'"]').html(payments[i].description);
        }
</script>
@endsection