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
{{--                        <li>Profile update</li>--}}
{{--                        <li>Document upload</li>--}}
{{--                        <li>Admin acceptance</li>--}}
{{--                        <li>Payment</li>--}}
                    </ul>
                </div>
                <div class="col-md-6 ml-5 isReject">
                    <h3 class="text-danger">Your request is rejected, Please</h3>
                    <ol>
                        <li>Check your profile and update correctly</li>
                        <li>Check your Document and upload correctly</li>
                        <li>Done your payment</li>
                    </ol>
                </div>

            </div>

            <h5 class="mt-5">Click here to complete your profile information <a href="{{route('user.profile')}}" class="btn btn-info">Go profile</a></h5>

        </div>
    </div>
</div>
<div class="authorized">
    <h4 class="hidePaymentBtn mb-5 p-2 text-danger" style="font-size: 24px; color: white; background-color: lightskyblue">Make payment to active your POS account. Click here to get the instruction <i class="fa fa-arrow-right"></i> <button class="btn btn-danger m-auto btn-sm" data-target="#makepaymentModal" data-toggle="modal" data-original-title="Make Payment"><span class="hidden-xs" style="font-size: 20px;"> Make payment</span></button></h4>

    <!-- Modal -->
    <div class="modal fade" id="makepaymentModal" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Payment Instruction</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="ResetForm();">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3>Please make payment manually to bKash <span class="text-cyan">01799409540(Personal)</span><br><br>
                        <span class="text-warning h5">Note: After complete your payment please give the confirmation.</span>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- ROW-1 OPEN -->
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card bg-primary img-card box-primary-shadow">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="text-white">
                            <h2 class="mb-0 number-font">23,536</h2>
                            <p class="text-white mb-0">Total Requests </p>
                        </div>
                        <div class="ml-auto"> <i class="fa fa-send-o text-white fs-30 mr-2 mt-2"></i> </div>
                    </div>
                </div>
            </div>
        </div><!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card bg-secondary img-card box-secondary-shadow">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="text-white">
                            <h2 class="mb-0 number-font">45,789</h2>
                            <p class="text-white mb-0">Total Revenue</p>
                        </div>
                        <div class="ml-auto"> <i class="fa fa-bar-chart text-white fs-30 mr-2 mt-2"></i> </div>
                    </div>
                </div>
            </div>
        </div><!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card  bg-success img-card box-success-shadow">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="text-white">
                            <h2 class="mb-0 number-font">89,786</h2>
                            <p class="text-white mb-0">Total Profit</p>
                        </div>
                        <div class="ml-auto"> <i class="fa fa-dollar text-white fs-30 mr-2 mt-2"></i> </div>
                    </div>
                </div>
            </div>
        </div><!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card bg-info img-card box-info-shadow">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="text-white">
                            <h2 class="mb-0 number-font">43,336</h2>
                            <p class="text-white mb-0">Monthly Sales</p>
                        </div>
                        <div class="ml-auto"> <i class="fa fa-cart-plus text-white fs-30 mr-2 mt-2"></i> </div>
                    </div>
                </div>
            </div>
        </div><!-- COL END -->
    </div>
    <!-- ROW-1 CLOSED -->

</div>
