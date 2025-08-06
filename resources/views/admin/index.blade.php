@extends('admin.layout.master')

@section('content')

@if (Auth::guard('admin')->user()->role === 'Quản trị viên')
    <div class="container-fluid">
        <!--  Row 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row alig n-items-start">
                                    <div class="col-8">
                                        <h5 class="card-title mb-9 fw-semibold">Tổng sản phẩm </h5>
                                        <h2 class="fw-semibold mb-3">{{number_format($data['total_product'])}}</h2>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex justify-content-end">
                                            <div
                                                class="text-white bg-danger rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-apple fs-6"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- Monthly Earnings -->
                        <div class="card">
                            <div class="card-body">
                                <div class="row alig n-items-start">
                                    <div class="col-8">
                                        <h5 class="card-title mb-9 fw-semibold">Tổng đơn hàng</h5>
                                        <h2 class="fw-semibold mb-3">{{number_format($data['total_order'])}}</h2>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex justify-content-end">
                                            <div
                                                class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-users fs-6"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- Monthly Earnings -->
                        <div class="card">
                            <div class="card-body">
                                <div class="row alig n-items-start">
                                    <div class="col-8">
                                        <h5 class="card-title mb-9 fw-semibold">Tổng doanh thu</h5>
                                        <h2 class="fw-semibold mb-3">{{number_format($data['total_income'])}} đ</h2>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex justify-content-end">
                                            <div
                                                class="text-white bg-success rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-cash fs-6"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 d-flex align-items-strech">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                            <div class="mb-3 mb-sm-0">
                                <h5 class="card-title fw-semibold">Doanh số bán hàng</h5>
                            </div>
                            <form>
                                <select name="month" class="form-select" onchange="this.form.submit()">
                                    @for ($i = 1; $i < 13; $i++)
                                        @if (request('month') == $i)
                                            <option value="{{$i}}" selected>Tháng {{$i}}</option>
                                        @elseif (request('month') == '' AND date('m') == $i)
                                            <option value="{{$i}}" selected>Tháng {{$i}}</option>
                                        @else
                                        <option value="{{$i}}">Tháng {{$i}}</option> 
                                        @endif
                                    @endfor
                                </select>
                            </form>
                        </div>
                        <div id="sales"></div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="row">
            <div class="col-lg-6 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold mb-4">Top sản phẩm bán chạy</h5>
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">STT</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Sản phẩm</h6>
                                        </th>
                                        <th class="border-bottom-0 text-center">
                                            <h6 class="fw-semibold mb-0">Lượt bán</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bestSellingProducts as $key=>$product)
                                        <tr>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">#{{$key+1}}</h6>
                                            </td>
                                            <td class="border-bottom-0 text-start">
                                                <a href="{{route('product.show', $product)}}">
                                                    <h6 class="fw-semibold mb-1">{{Str::limit($product->name, 40)}}</h6>
                                                </a>
                                            </td>
                                            <td class="border-bottom-0 text-center">
                                                <p class="mb-0 fw-normal">{{$product->sold}}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold mb-4">Đơn hàng gần đây</h5>
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0 text-center">
                                            <h6 class="fw-semibold mb-0">Mã đơn</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Tên khách hàng</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Tổng tiền</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Thời gian</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestOrders as $key=>$order)
                                        <tr>
                                            <td class="border-bottom-0 text-center">
                                                <h6 class="fw-semibold mb-0">#{{$order->id}}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-1">{{$order->name}}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">{{number_format($order->total_price)}}đ</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">{{date_format($order->created_at,'H:i A - d/m')}}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold mb-4">Top sản phẩm được yêu thích</h5>
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">STT</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Sản phẩm</h6>
                                        </th>
                                        <th class="border-bottom-0 text-center">
                                            <h6 class="fw-semibold mb-0 ">Lượt thích</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topLikedProducts as $key=>$product)
                                        <tr>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">#{{$key+1}}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <a href="{{route('product.show', $product->id)}}">
                                                    <h6 class="fw-semibold mb-1">{{Str::limit($product->name, 40)}}</h6>
                                                </a>
                                            </td>
                                            <td class="border-bottom-0 text-center">
                                                <p class="mb-0 fw-normal">{{$product->like_count}}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold mb-4">Top sản phẩm được chấm điểm cao</h5>
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">STT</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Sản phẩm</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Điểm</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topPointProducts as $key=>$product)
                                        <tr>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">#{{$key+1}}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <a href="{{route('product.show', $product->id)}}">
                                                    <h6 class="fw-semibold mb-1">{{Str::limit($product->name, 40)}}</h6>
                                                </a>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">{{number_format($product->avg_point, 1)}}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="container-fluid text-center ">
        <h3>Trang này chỉ dành cho quản trị viên.</h3>
    </div>
@endif

@endsection

@push('js')
    <script>
        var dataChart = <?php echo json_encode($totalSalesByDay); ?>;


        var chart = {
        series: [
            { name: "Tổng tiền", data: Object.values(dataChart) },
        ],

        chart: {
            type: "bar",
            height: 345,
            offsetX: -15,
            toolbar: { show: true },
            foreColor: "#adb0bb",
            fontFamily: 'inherit',
            sparkline: { enabled: false },
        },


        colors: ["#49BEFF"],


        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "75%",
                borderRadius: [6],
                borderRadiusApplication: 'end',
                borderRadiusWhenStacked: 'all'
            },
        },
        markers: { size: 0 },

        dataLabels: {
            enabled: false,
        },

        legend: {
            show: false,
        },

        grid: {
            borderColor: "rgba(0,0,0,0.1)",
            strokeDashArray: 3,
            xaxis: {
                lines: {
                show: false,
                },
            },
        },

        xaxis: {
            type: "category",
            categories: Object.keys(dataChart),
            labels: {
                style: { cssClass: "grey--text lighten-2--text fill-color" },
            },
        },


        yaxis: {
            show: true,
            min: 0,
            tickAmount: 4,
            labels: {
                style: {
                cssClass: "grey--text lighten-2--text fill-color",
                },
            },
        },
        stroke: {
            show: true,
            width: 3,
            lineCap: "butt",
            colors: ["transparent"],
        },


        tooltip: { theme: "light" },

        responsive: [
            {
                breakpoint: 600,
                options: {
                plotOptions: {
                    bar: {
                    borderRadius: 3,
                    }
                },
                }
            }
        ]


    };

    var chart = new ApexCharts(document.querySelector("#sales"), chart);
    chart.render();
    </script>
@endpush