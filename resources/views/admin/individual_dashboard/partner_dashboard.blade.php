<div class="unauthoraisation">
    <div class="card"  style="background-color: #CEECEE; border-radius: 15px;">
        <div class="card-body">
            <div class="row p-5"  style="border: 1px solid grey; height: 190px; width: 100%; border-radius: 25px;">
                <div class="col-md-2">
                    <img src="{{asset('assets/images/logos/images.png')}}" alt="">
                </div>
                <div class="col-md-6 ml-5 notReject">
                    <h3 class="text-danger">Your request is pending for</h3>
                    <ul class="posAcountDashboard" style="list-style-type:none;">

                    </ul>
                </div>
                <div class="col-md-6 ml-5 isReject">
                    <h3 class="text-danger">Your request is rejected, Please</h3>
                    <ol>
                        <li>Check your profile and update correctly</li>
                        <li>Check your Document and upload correctly</li>
                    </ol>
                </div>

            </div>

            <h5 class="mt-5">Click here to complete your profile information <a href="{{route('user.profile')}}" class="btn btn-info">Go profile</a></h5>
        </div>
    </div>
</div>
<div class="authorized">
    <!-- ROW-1 -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-6">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
                    <div class="card">
                        <div class="card-body text-center statistics-info">
                            <div class="counter-icon bg-success mb-0 box-primary-shadow">
                                <i class="fe fe-user text-white"></i>
                            </div>
                            <h6 class="mt-4 mb-1">Active Users</h6>
                            <h2 class="mb-2 number-font activeUsers"></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
                    <div class="card">
                        <div class="card-body text-center statistics-info">
                            <div class="counter-icon bg-secondary mb-0 box-secondary-shadow">
                                <i class="fe fe-user-x text-white"></i>
                            </div>
                            <h6 class="mt-4 mb-1">Suspened Users</h6>
                            <h2 class="mb-2 number-font suspendUsers"></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
                    <div class="card">
                        <div class="card-body text-center statistics-info">
                            <div class="counter-icon bg-success mb-0 box-success-shadow">
                                <i class="fe fe-dollar-sign text-white"></i>
                            </div>
                            <h6 class="mt-4 mb-1">This Month Revenue</h6>
                            <h2 class="mb-2  number-font monthRevenue">$0</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
                    <div class="card">
                        <div class="card-body text-center statistics-info">
                            <div class="counter-icon bg-info mb-0 box-info-shadow">
                                <i class="fe fe-database text-white"></i>
                            </div>
                            <h6 class="mt-4 mb-1">Total Revenue</h6>
                            <h2 class="mb-2  number-font totalRevenue">$0</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

{{--        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-6">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h3 class="card-title">Earnings</h3>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div id="echart1" class="chart-donut chart-dropshadow"></div>--}}
{{--                    <div class="mt-4">--}}
{{--                        <span class="ml-5"><span class="dot-label bg-info mr-2"></span>Sales</span>--}}
{{--                        <span class="ml-5"><span class="dot-label bg-secondary mr-2"></span>Profit</span>--}}
{{--                        <span class="ml-5"><span class="dot-label bg-success mr-2"></span>Growth</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div><!-- COL END -->--}}
    </div>
    <!-- ROW-1 END -->

</div>
