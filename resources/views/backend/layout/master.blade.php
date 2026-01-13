@yield('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible alert-alt solid fade show">
                    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                    </button>
                    Make sure you get paid out by <a href="#" class="text-white"><strong>confirming your payment options</strong></a>.
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="card" id="user-activity">
                    <div class="card-header">
                        <h4 class="card-title">Analytics</h4>
                        <div class="card-action">
                            <!-- <div class="dropdown d-inline-block">
                                <a class="btn" href="#" role="button" data-display="static" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-arrow-down-bold"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="mdi mdi-calendar-check"></i> This Week</a>
                                    <a class="dropdown-item" href="#"><i class="mdi mdi-calendar-check"></i> This Month</a>
                                    <a class="dropdown-item" href="#"><i class="mdi mdi-calendar-check"></i> This Year</a>
                                </div>
                            </div> -->
                            <div class="dropdown d-inline-block">
                                <a class="btn" href="#" role="button" data-display="static" data-toggle="dropdown" aria-expanded="false">
                                    Export
                                    <i class="mdi mdi-arrow-down-bold"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="mdi mdi-file-image"></i> Export to Image</a>
                                    <a class="dropdown-item" href="#"><i class="mdi mdi-file-pdf"></i> Export to PDF</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#user">
                                    Discount Codes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#session">
                                    Page Views
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#bounce">
                                    At the door sale
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active" id="user" role="tabpanel" aria-labelledby="home-tab">
                                <canvas id="activity" class="chartjs"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card" id="chart2">
                    <div class="card-header">
                        <h4 class="card-title">Net Sales</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-xl-3 col-xxl-4 col-md-4 col-sm-4 col-12">
                                <div class="nav flex-column nav-pills">
                                    <a href="#net-sales" data-toggle="pill" class="nav-link active show">
                                        <p class="mb-2">Net sales</p>
                                        <h3>$0.00</h3>
                                    </a>
                                    <a href="#ticket-sold" data-toggle="pill" class="nav-link">
                                        <p class="mb-2">Ticket Sold</p>
                                        <h3>125</h3>
                                    </a>
                                    <a href="#page-views" data-toggle="pill" class="nav-link">
                                        <p class="mb-2">Page Views</p>
                                        <h3>5635</h3>
                                    </a>
                                    <a href="#invites" data-toggle="pill" class="nav-link">
                                        <p class="mb-2">Invites</p>
                                        <h3>23</h3>
                                    </a>
                                </div>
                            </div>

                            <div class="col-xl-9 col-xxl-8 col-md-8 col-sm-8 col-12">
                                <div class="tab-content">
                                    <div id="net-sales" class="tab-pane fade active show">
                                        <div class="net-sales-content">
                                            <div class="row">
                                                <div class="col-sm-4 col-12">
                                                    <span class="pb-2 d-block">Gross Sale</span>
                                                    <h5>$750.00</h5>
                                                </div>
                                                <div class="col-sm-4 col-12">
                                                    <span class="pb-2 d-block">Online Sale</span>
                                                    <h5>$450.00</h5>
                                                </div>
                                                <div class="col-sm-4 col-12">
                                                    <span class="pb-2 d-block">Offline Sale</span>
                                                    <h5>$300.00</h5>
                                                </div>
                                            </div>
                                            <div>
                                                <canvas id="chart_netsales"></canvas>
                                            </div>
                                        </div>

                                    </div>
                                    <div id="ticket-sold" class="tab-pane fade">
                                        <div class="ticket-sold-content">
                                            <div id="ticket-sold-circle" class="mb-3"></div>
                                            <div class="row">
                                                <div class="col">
                                                    <i class="fa fa-circle text-success"></i>
                                                    <span>Paid</span>
                                                </div>
                                                <div class="col">
                                                    <i class="fa fa-circle text-muted"></i>
                                                    <span>Available</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="page-views" class="tab-pane fade">
                                        <div class="page-views-content">
                                            <canvas id="areaChart_3"></canvas>
                                        </div>
                                    </div>
                                    <div id="invites" class="tab-pane fade">
                                        <div class="invites-content">
                                            <div class="row">
                                                <div class="col">
                                                    <span>invitations opened</span>
                                                    <h5>5</h5>
                                                </div>
                                                <div class="col">
                                                    <span>Paid</span>
                                                    <h5>5.60%</h5>
                                                </div>
                                            </div>
                                            <div>
                                                <canvas id="chart_invites"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-xxl-6 col-lg-12">
                    <div class="card">
                        <div class="card-header d-block">
                            <h4 class="card-title">Event Goals</h4>
                        </div>
                        <div class="card-body event-goals">
                            <div class="row">
                                <div class="col-xl-12 col-xxl-12">
                                    <p class="mb-2">Wordpress Theme Development
                                        <span class="float-right font-weight-bold text-dark">85%</span>
                                    </p>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-primary progress-animated" style="width: 85%; height:6px;" role="progressbar">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-xl-12 col-xxl-12">
                                    <p class="mb-2">UI Design
                                        <span class="float-right font-weight-bold text-dark">65%</span>
                                    </p>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-success progress-animated" style="width: 65%; height:6px;" role="progressbar">
                                        </div>
                                    </div>

                                </div>
                                <!-- <div class="col-xl-12 col-xxl-12">
                                    <p class="mb-2">Front end Development
                                        <span class="float-right font-weight-bold">50%</span>
                                    </p>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-danger progress-animated" style="width: 50%; height:6px;" role="progressbar">
                                        </div>
                                    </div>

                                </div> -->
                                <div class="col-xl-12 col-xxl-12">
                                    <p class="mb-2">Digital Marketing
                                        <span class="float-right font-weight-bold">65%</span>
                                    </p>
                                    <div class="progress mb-3">
                                        <div class="progress-bar bg-info progress-animated" style="width: 65%; height:6px;" role="progressbar">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-xxl-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Bloomreach Connect</h4>
                        </div>
                        <div class="card-body">
                            <div class="event-attend">
                                <div class="attend-member">
                                    <div id="attend_event_1"></div>
                                    <h5><i class="mdi mdi-account"></i> 960</h5>
                                    <h6 class="text-dark mt-2 mb-0">Attend</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Tech Inclusion</h4>
                        </div>
                        <div class="card-body">
                            <div class="event-attend">
                                <div class="attend-member">
                                    <div id="attend_event_2"></div>
                                    <h5><i class="mdi mdi-account"></i> 1250</h5>
                                    <h6 class="text-dark mt-2 mb-0">Attended</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                    Presto Summit</h4>
                        </div>
                        <div class="card-body">
                            <div class="event-attend">
                                <div class="attend-member">
                                    <div id="attend_event_3"></div>
                                    <h5><i class="mdi mdi-account"></i> 100</h5>
                                    <h6 class="text-dark mt-2 mb-0">Ongoing</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Sales by Ticket Type</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered verticle-middle table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">Ticket Type</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Sold</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">End Sales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Laracon US 2019</td>
                                        <td>$25.00</td>
                                        <td>0/50</td>
                                        <td>On Sale</td>
                                        <td>8/8/19 7:00 PM</td>
                                    </tr>
                                    <tr>
                                        <td>VOICE 2019</td>
                                        <td>$25.00</td>
                                        <td>127/30</td>
                                        <td>On Sale</td>
                                        <td>8/9/19 7:00 PM</td>
                                    </tr>
                                    <tr>
                                        <td>Moving Forward Conference NYC 2019</td>
                                        <td>$25.00</td>
                                        <td>258/500</td>
                                        <td>On Sale</td>
                                        <td>8/10/19 7:00 PM</td>
                                    </tr>
                                    <tr>
                                        <td>Biodesign Challenge Summit 2019</td>
                                        <td>$25.00</td>
                                        <td>30/50</td>
                                        <td>On Sale</td>
                                        <td>8/12/19 7:00 PM</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Recent Orders</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered verticle-middle table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">Order #</th>
                                        <th scope="col">Ticket Buyer</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>236589</td>
                                        <td>Mr John</td>
                                        <td>2</td>
                                        <td>$25.21</td>
                                        <td>May 26, 2019</td>
                                        <td>Guest</td>
                                    </tr>
                                    <tr>
                                        <td>214786</td>
                                        <td>Mr Abraham</td>
                                        <td>5</td>
                                        <td>$25.21</td>
                                        <td>May 27, 2019</td>
                                        <td>Guest</td>
                                    </tr>
                                    <tr>
                                        <td>956235</td>
                                        <td>Lincoln Islam</td>
                                        <td>1</td>
                                        <td>$25.21</td>
                                        <td>May 28, 2019</td>
                                        <td>Guest</td>
                                    </tr>
                                    <tr>
                                        <td>145239</td>
                                        <td>John Doe</td>
                                        <td>3</td>
                                        <td>$25.21</td>
                                        <td>May 29, 2019</td>
                                        <td>Guest</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>      