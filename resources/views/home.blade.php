@extends('layouts.app')
@section('content')
    <div class="row mb-2">
        <div class="col-lg-12 col-xl-12">
            <div class="card o-hidden">
                <div class="weather-card-1">
                    <div class="ul-weather-card__weather-info">
                        <div class="row text-center">
                            <div class="col-6 col-md-2">
                                <div class="">SAT</div>
                                <div class="">
                                    <i class="i-Cloud-Weather"></i>
                                </div>
                                <div class="">12 <sup>o</sup>C</div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="">SUN</div>
                                <div class="">
                                    <i class="i-Cloud-Settings"></i>
                                </div>
                                <div class="">23 <sup>o</sup>C</div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="">MON</div>
                                <div class="">
                                    <i class="i-Cloud-Weather"></i>
                                </div>
                                <div class="">17 <sup>o</sup>C</div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="">TUE</div>
                                <div class="">
                                    <i class="i-Clouds"></i>
                                </div>
                                <div class="">23 <sup>o</sup>C</div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="">WED</div>
                                <div class="">
                                    <i class="i-Clouds-Weather"></i>
                                </div>
                                <div class="">27 <sup>o</sup>C</div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="">THU</div>
                                <div class="">
                                    <i class="i-Cloud-Sun"></i>
                                </div>
                                <div class="">38 <sup>o</sup>C</div>
                            </div>
                        </div>
                    </div>
    
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">TV və FM sayı</div>
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
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            var echartElemBar = document.getElementById('echartBar');
            if (echartElemBar) {
                var echartBar = echarts.init(echartElemBar);
                echartBar.setOption({
                    legend: {
                        borderRadius: 0,
                        orient: 'horizontal',
                        x: 'right',
                        data: ['TV', 'FM']
                    },
                    grid: {
                        left: '8px',
                        right: '8px',
                        bottom: '0',
                        containLabel: true
                    },
                    tooltip: {
                        show: true,
                        backgroundColor: 'rgba(0, 0, 0, .8)'
                    },
                    xAxis: [{
                        type: 'category',
                        data: ['Yanvar', 'Fevral','Mart','Aprel','May','İyun','İyul','Avqust','Sentyabr','Oktyabr','Noyabr','Dekabr'],
                        axisTick: {
                            alignWithLabel: true
                        },
                        splitLine: {
                            show: false
                        },
                        axisLine: {
                            show: true
                        }
                    }],
                    yAxis: [{
                        type: 'value',
                        axisLabel: {
                            formatter: '{value}'
                        },
                        min: 0,
                        max: {{ $station_max_frequency_count }},
                        interval: 2,
                        axisLine: {
                            show: false
                        },
                        splitLine: {
                            show: true,
                            interval: 'auto'
                        }
                    }],

                    series: [{
                        name: 'TV',
                        data: [{{$foreign_tv_count}}],
                        label: { show: false, color: '#0168c1' },
                        type: 'bar',
                        barGap: 0,
                        color: '#bcbbdd',
                        smooth: true,
                        itemStyle: {
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowOffsetY: -2,
                                shadowColor: 'rgba(0, 0, 0, 0.3)'
                            }
                        }
                    }, {
                        name: 'FM',
                        data: [{{$foreign_fm_count}}],
                        label: { show: false, color: '#639' },
                        type: 'bar',
                        color: '#7569b3',
                        smooth: true,
                        itemStyle: {
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowOffsetY: -2,
                                shadowColor: 'rgba(0, 0, 0, 0.3)'
                            }
                        }
                    }]
                });
                $(window).on('resize', function () {
                    setTimeout(function () {
                        echartBar.resize();
                    }, 500);
                });
            }

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
                    name: 'İstiqamət üzrə',
                    type: 'pie',
                    radius: '60%',
                    center: ['50%', '50%'],
                    data: {!! json_encode($directionsDataEncoded) !!},
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
        })

    </script>
@endsection
