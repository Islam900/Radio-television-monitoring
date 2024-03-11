@extends('layouts.app')
@section('content')
    <div class="row">
        <!-- ICON BG -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-Add-User"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">New Leads</p>
                        <p class="text-primary text-24 line-height-1 mb-2">205</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-Financial"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Sales</p>
                        <p class="text-primary text-24 line-height-1 mb-2">$4021</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-Checkout-Basket"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Orders</p>
                        <p class="text-primary text-24 line-height-1 mb-2">80</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-Money-2"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Expense</p>
                        <p class="text-primary text-24 line-height-1 mb-2">$1200</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">This Year Sales</div>
                    <div id="echartBar" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">İstiqamətlər üzrə</div>
                    <div id="echartPie" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body p-0">
                    <h5 class="card-title m-0 p-3">EMS keyfiyyəti</h5>
                    <div id="echart3" style="height: 400px;"></div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script>
        var echartElemPie = document.getElementById('echartPie');
        if (echartElemPie) {
            var echartPie = echarts.init(echartElemPie);
            echartPie.setOption({
                color: ['#62549c', '#7566b5', '#7d6cbb', '#8877bd', '#9181bd', '#6957af'],
                tooltip: {
                    show: true,
                    backgroundColor: 'rgba(0, 0, 0, .8)'
                },

                series: [{
                    name: 'Vurulub',
                    type: 'pie',
                    radius: '60%',
                    center: ['50%', '50%'],
                    data: [{ value: 535, name: 'Gəncə' }, { value: 500, name: 'Daşkəsən' }, { value: 234, name: 'Şəmkir' }, { value: 155, name: 'Qazax' }, { value: 130, name: 'Tovuz' }],
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }]
            });
            $(window).on('resize', function () {
                setTimeout(function () {
                    echartPie.resize();
                }, 500);
            });
        }

        var echartElem3 = document.getElementById('echart3');
        if (echartElem3) {
            var echart3 = echarts.init(echartElem3);
            echart3.setOption(_extends({}, echartOptions.lineNoAxis, {
                series: [{
                    data: {{ json_encode($emfs_level) }},
                    lineStyle: _extends({
                        color: 'rgba(102, 51, 153, 0.8)',
                        width: 3
                    }, echartOptions.lineShadow),
                    label: { show: true, color: '#212121' },
                    type: 'line',
                    smooth: true,
                    itemStyle: {
                        borderColor: 'rgba(102, 51, 153, 1)'
                    }
                }]
            }));
            $(window).on('resize', function () {
                setTimeout(function () {
                    echart3.resize();
                }, 500);
            });
        }
    </script>
@endsection
