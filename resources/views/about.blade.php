@extends('layouts.customerBase')
@section('title', 'About')
@section('content')
        <header class="bg-dark py-5 image-container" >
            <div class="container px-4 px-lg-5 my-5 " >
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder" style="color: white !important;">Get to know more about us...</h1>
                    <p class="lead fw-normal text-grey-50 mb-0"><b>Daniel and Janine Tailoring Shop</b></p>
                </div>
            </div>
        </header>
        <section class="py-5">
            <div class="container">
                <div class="row justify-content-left">
                    <div class="col-md-4">
                        <img class="card-img-top" src="{{ asset('assets/images/carousel/cas2.jpg') }}" alt="..." />
                    </div>
                    <div class="col-md-8">
                        <h3>Our History</h3>
                        <hr>
                        <p>
                            &nbsp;&nbsp;&nbsp;Daneil and Janine Tailoring Shop starting with a small shop at South Sentro Sipocot Camarines Sur year 2016. It is a family business managed by the Pucol family. By then, the business grow and able to have another shop at Gaongan. Both shop was being managed by Pucol siblings. The shop was 5 years and still making good quality of garments to satisfy customer's styles.<br>

                            &nbsp;&nbsp;&nbsp;Daniel and Janine Tailoring Shop made garments the style you are comfortable with. We make sure you feel as good as you look wearing custom-tailored clothing true to your unique fit. Don’t let your clothing decide who you are; decide it for yourself.
                            You choose what you deserve.
                        </p>
                    </div>
                </div>
                <hr><br>
                <div class="row justify-content-left">
                   <div class="col-md-8">
                        <h3>Contact Us</h3>
                        <hr>
                        <b>Address: </b>
                        <p>
                            Gaongan Shop<br>
                            Sitio Sabang, Gaongan Sipocot Camarines Sur <br>
                            South Centro
                            San Juan Avenue, South Centro, Sipocot Camarines Sur
                        </p>
                        <b>Contact: </b>
                        <p>
                            <b>FB:</b> Theresa Pucol <br>
                            <b>Contact Number:</b> 09273733612 <br>
                            
                            <b>Business Hours</b> <br>
                            Monday to Sunday <br>
                            7:00 a.m to 8:00 pm
                        </p>
                    </div>
                    <div class="col-md-4">
                        <img class="card-img-top" src="{{ asset('assets/images/carousel/map.png') }}" alt="..." />
                    </div>
                </div>
            </div>
        </section>
        
@endsection