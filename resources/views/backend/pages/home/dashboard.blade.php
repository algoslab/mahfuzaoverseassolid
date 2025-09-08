
@extends('backend.layouts.app')

@section('title', config('app.name') . ' - Dashboard')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">														
                <div class="box no-shadow mb-0 bg-transparent">
                    <div class="box-header no-border px-0">
                        <h4 class="box-title">Current Running Courses</h4>	
                        <ul class="box-controls pull-right d-md-flex d-none">
                          <li>
                            <button class="btn btn-primary-light px-10">View All</button>
                          </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <div class="box pull-up">
                    <div class="box-body">	
                        <div class="bg-primary rounded">
                            <h5 class="text-white text-center p-10">Total Medicines</h5>
                        </div>
                        <p class="mb-0 font-size-18">50s</p>
							
                    </div>					
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <div class="box pull-up">
                    <div class="box-body">	
                        <div class="bg-warning rounded">
                            <h5 class="text-white text-center p-10">Instock Medicines</h5>
                        </div>
                        <p class="mb-0 font-size-18">100</p>
								
                    </div>					
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <div class="box pull-up">
                    <div class="box-body">	
                        <div class="bg-danger rounded">
                            <h5 class="text-white text-center p-10">Stockout Medicines</h5>
                        </div>
                        <p class="mb-0 font-size-18">80</p>
							
                    </div>					
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <div class="box pull-up">
                    <div class="box-body">	
                        <div class="bg-info rounded">
                            <h5 class="text-white text-center p-10">Network Security</h5>
                        </div>
                        <p class="mb-0 font-size-18">90</p>
							
                    </div>					
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <div class="box pull-up">
                    <div class="box-body">	
                        <div class="bg-primary rounded">
                            <h5 class="text-white text-center p-10">It & software</h5>
                        </div>
                        <p class="mb-0 font-size-18">30</p>
							
                    </div>					
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <div class="box pull-up">
                    <div class="box-body">	
                        <div class="bg-warning rounded">
                            <h5 class="text-white text-center p-10">Programming</h5>
                        </div>
                        <p class="mb-0 font-size-18">400</p>
							
                    </div>					
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <div class="box pull-up">
                    <div class="box-body">	
                        <div class="bg-danger rounded">
                            <h5 class="text-white text-center p-10">Networking</h5>
                        </div>
                        <p class="mb-0 font-size-18">60</p>
								
                    </div>					
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <div class="box pull-up">
                    <div class="box-body">	
                        <div class="bg-info rounded">
                            <h5 class="text-white text-center p-10">Network Security</h5>
                        </div>
                        <p class="mb-0 font-size-18">50</p>
							
                    </div>					
                </div>
            </div>
        </div>


    </section>
@endsection

