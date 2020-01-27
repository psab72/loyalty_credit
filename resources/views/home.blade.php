@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Traffic &amp; Sales</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="callout callout-info">
                                            <small class="text-muted">Amount Lent</small>
                                            <br>
                                            <strong class="h4">9,123</strong>
                                            <div class="chart-wrapper">
                                                <canvas id="sparkline-chart-1" width="100" height="30"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="callout callout-danger">
                                            <small class="text-muted">Amount at Risk</small>
                                            <br>Test
                                            <strong class="h4">22,643</strong>
                                            <div class="chart-wrapper">
                                                <canvas id="sparkline-chart-2" width="100" height="30"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <hr class="mt-0">
                                <div class="progress-group mb-4">
                                    <div class="progress-group-prepend">
                                        <span class="progress-group-text">Monday</span>
                                    </div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 34%" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-group mb-4">
                                    <div class="progress-group-prepend">
                                        <span class="progress-group-text">Tuesday</span>
                                    </div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 56%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 94%" aria-valuenow="94" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-group mb-4">
                                    <div class="progress-group-prepend">
                                        <span class="progress-group-text">Wednesday</span>
                                    </div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 12%" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 67%" aria-valuenow="67" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-group mb-4">
                                    <div class="progress-group-prepend">
                                        <span class="progress-group-text">Thursday</span>
                                    </div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 43%" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 91%" aria-valuenow="91" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-group mb-4">
                                    <div class="progress-group-prepend">
                                        <span class="progress-group-text">Friday</span>
                                    </div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 73%" aria-valuenow="73" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-group mb-4">
                                    <div class="progress-group-prepend">
                                        <span class="progress-group-text">Saturday</span>
                                    </div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 53%" aria-valuenow="53" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 82%" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-group mb-4">
                                    <div class="progress-group-prepend">
                                        <span class="progress-group-text">Sunday</span>
                                    </div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 9%" aria-valuenow="9" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 69%" aria-valuenow="69" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="callout callout-warning">
                                            <small class="text-muted">Pageviews</small>
                                            <br>
                                            <strong class="h4">78,623</strong>
                                            <div class="chart-wrapper">
                                                <canvas id="sparkline-chart-3" width="100" height="30"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="callout callout-success">
                                            <small class="text-muted">Organic</small>
                                            <br>
                                            <strong class="h4">49,123</strong>
                                            <div class="chart-wrapper">
                                                <canvas id="sparkline-chart-4" width="100" height="30"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <hr class="mt-0">
                                <div class="progress-group">
                                    <div class="progress-group-header">
                                        <i class="icon-user progress-group-icon"></i>
                                        <div>Male</div>
                                        <div class="ml-auto font-weight-bold">43%</div>
                                    </div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 43%" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-group mb-5">
                                    <div class="progress-group-header">
                                        <i class="icon-user-female progress-group-icon"></i>
                                        <div>Female</div>
                                        <div class="ml-auto font-weight-bold">37%</div>
                                    </div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 43%" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-group">
                                    <div class="progress-group-header align-items-end">
                                        <i class="icon-globe progress-group-icon"></i>
                                        <div>Organic Search</div>
                                        <div class="ml-auto font-weight-bold mr-2">191.235</div>
                                        <div class="text-muted small">(56%)</div>
                                    </div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 56%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-group">
                                    <div class="progress-group-header align-items-end">
                                        <i class="icon-social-facebook progress-group-icon"></i>
                                        <div>Facebook</div>
                                        <div class="ml-auto font-weight-bold mr-2">51.223</div>
                                        <div class="text-muted small">(15%)</div>
                                    </div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-group">
                                    <div class="progress-group-header align-items-end">
                                        <i class="icon-social-twitter progress-group-icon"></i>
                                        <div>Twitter</div>
                                        <div class="ml-auto font-weight-bold mr-2">37.564</div>
                                        <div class="text-muted small">(11%)</div>
                                    </div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 11%" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-group">
                                    <div class="progress-group-header align-items-end">
                                        <i class="icon-social-linkedin progress-group-icon"></i>
                                        <div>LinkedIn</div>
                                        <div class="ml-auto font-weight-bold mr-2">27.319</div>
                                        <div class="text-muted small">(8%)</div>
                                    </div>
                                    <div class="progress-group-bars">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 8%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label> Latest Transactions</label>
                                <table class="table datatable">
                                    <thead>
                                    <th> Date</th>
                                    <th> User</th>
                                    <th> Currency</th>
                                    <th> Amount</th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td> Nov 12, 2018</td>
                                        <td> Philip Sabio</td>
                                        <td> Philippine Peso</td>
                                        <td> 1,500</td>
                                    </tr>
                                    <tr>
                                        <td> Nov 15, 2018</td>
                                        <td> Juan Miguel</td>
                                        <td> Philippine Peso</td>
                                        <td> 1,200</td>
                                    </tr>
                                    <tr>
                                        <td> Nov 16, 2018</td>
                                        <td> John Oliver</td>
                                        <td> Philippine Peso</td>
                                        <td> 1,500</td>
                                    </tr>
                                    <tr>
                                        <td> Nov 17, 2018</td>
                                        <td> Pablo Magdalo</td>
                                        <td> Philippine Peso</td>
                                        <td> 1,300</td>
                                    </tr>
                                    <tr>
                                        <td> Nov 17, 2018</td>
                                        <td> Oscar Torion</td>
                                        <td> Philippine Peso</td>
                                        <td> 1,300</td>
                                    </tr>
                                    <tr>
                                        <td> Nov 18, 2018</td>
                                        <td> Oscar Torion</td>
                                        <td> Philippine Peso</td>
                                        <td> 1,700</td>
                                    </tr>
                                    <tr>
                                        <td> Nov 18, 2018</td>
                                        <td> Elgin Jabar</td>
                                        <td> Philippine Peso</td>
                                        <td> 1,200</td>
                                    </tr>
                                    <tr>
                                        <td> Nov 19, 2018</td>
                                        <td> Al Makapit</td>
                                        <td> Philippine Peso</td>
                                        <td> 1,400</td>
                                    </tr>
                                    <tr>
                                        <td> Nov 20, 2018</td>
                                        <td> Manny Castillo</td>
                                        <td> Philippine Peso</td>
                                        <td> 1,300</td>
                                    </tr>
                                    <tr>
                                        <td> Nov 21, 2018</td>
                                        <td> Robert Miyata</td>
                                        <td> Philippine Peso</td>
                                        <td> 1,500</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <label> Upcoming Loan Repayments</label>
                                <table class="table datatable">
                                    <thead>
                                    <th> Date</th>
                                    <th> User</th>
                                    <th> Currency</th>
                                    <th> Amount</th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td> Nov 12, 2018</td>
                                        <td> Philip Sabio</td>
                                        <td> Philippine Peso</td>
                                        <td> 1,500</td>
                                    </tr>
                                    <tr>
                                        <td> Nov 15, 2018</td>
                                        <td> Juan Miguel</td>
                                        <td> Philippine Peso</td>
                                        <td> 1,200</td>
                                    </tr>
                                    <tr>
                                        <td> Nov 16, 2018</td>
                                        <td> John Oliver</td>
                                        <td> Philippine Peso</td>
                                        <td> 1,500</td>
                                    </tr>
                                    <tr>
                                        <td> Nov 17, 2018</td>
                                        <td> Pablo Magdalo</td>
                                        <td> Philippine Peso</td>
                                        <td> 1,300</td>
                                    </tr>
                                    <tr>
                                        <td> Nov 17, 2018</td>
                                        <td> Oscar Torion</td>
                                        <td> Philippine Peso</td>
                                        <td> 1,300</td>
                                    </tr>
                                    <tr>
                                        <td> Nov 18, 2018</td>
                                        <td> Oscar Torion</td>
                                        <td> Philippine Peso</td>
                                        <td> 1,700</td>
                                    </tr>
                                    <tr>
                                        <td> Nov 18, 2018</td>
                                        <td> Elgin Jabar</td>
                                        <td> Philippine Peso</td>
                                        <td> 1,200</td>
                                    </tr>
                                    <tr>
                                        <td> Nov 19, 2018</td>
                                        <td> Al Makapit</td>
                                        <td> Philippine Peso</td>
                                        <td> 1,400</td>
                                    </tr>
                                    <tr>
                                        <td> Nov 20, 2018</td>
                                        <td> Manny Castillo</td>
                                        <td> Philippine Peso</td>
                                        <td> 1,300</td>
                                    </tr>
                                    <tr>
                                        <td> Nov 21, 2018</td>
                                        <td> Robert Miyata</td>
                                        <td> Philippine Peso</td>
                                        <td> 1,500</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>
@endsection
