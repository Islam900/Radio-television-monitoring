@extends('admin.layouts.app')
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
                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-2 text-muted">Vurulur</h4>
                                <p class="mb-1 text-22 font-weight-light">{{ $response_quality_counts['Vurulur'] }}</p>
                            </div>
                            @php 
                                $vurulur_percent = $response_quality_counts['Vurulur'] * 100 / $station_max_foreign_broadcasts_count;
                            @endphp
                            <div class="progress mb-1" style="height: 30px">
                                <div class="progress-bar bg-default" style="width: {{ round($vurulur_percent, 0,2) }}%; font-size:16px;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                {{ round($vurulur_percent, 0,2) }}%
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Məlumatlar son 1 hətfəyə nəzərən hesablanıb</small>
                            <small class="text-danger">{{$periodik_say}} periodik / {{$daimi_say}} daimi</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-2 text-muted">Yaxşı</h4>
                                <p class="mb-1 text-22 font-weight-light">{{ $response_quality_counts['Yaxşı'] }}</p>
                            </div>
                            @php 
                                $yaxsi_persent = $response_quality_counts['Yaxşı'] * 100 / $station_max_foreign_broadcasts_count;
                            @endphp
                            <div class="progress mb-1" style="height: 30px">
                                <div class="progress-bar bg-success" style="width: {{ round($yaxsi_persent, 0,2) }}%; font-size:16px;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    {{ round($yaxsi_persent, 0,2) }}%    
                                </div>
                            </div>
                            <small class="text-muted">Məlumatlar son 1 hətfəyə nəzərən hesablanıb</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-2 text-muted">Kafi</h4>
                                <p class="mb-1 text-22 font-weight-light">{{ $response_quality_counts['Kafi'] }}</p>
                            </div>
                            @php 
                                $kafi_persent = $response_quality_counts['Kafi'] * 100 / $station_max_foreign_broadcasts_count;
                            @endphp
                            <div class="progress mb-1" style="height: 30px">
                                <div class="progress-bar bg-warning" style="width: {{ round($kafi_persent, 0,2) }}%; font-size:16px;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    {{ round($kafi_persent, 0,2) }}%    
                                </div>
                            </div>
                            <small class="text-muted">Məlumatlar son 1 hətfəyə nəzərən hesablanıb</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-2 text-muted">Zəif</h4>
                                <p class="mb-1 text-22 font-weight-light">{{ $response_quality_counts['Zəif'] }}</p>
                            </div>
                            @php 
                                $zeif_persent = $response_quality_counts['Zəif'] * 100 / $station_max_foreign_broadcasts_count;
                            @endphp
                            <div class="progress mb-1" style="height: 30px">
                                <div class="progress-bar bg-danger" style="width: {{ round($zeif_persent, 0,2) }}%; font-size:16px;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    {{ round($zeif_persent, 0,2) }}%    
                                </div>
                            </div>
                            <small class="text-muted">Məlumatlar son 1 hətfəyə nəzərən hesablanıb</small>
                        </div>
                    </div>
                </div>

            </div>

    <div class="row">
        <div class="col-lg-8 col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-title">TV və FM sayı</div>
                            <div id="echartBar" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Tarix üzrə TV və FM sayı</div>
                    <div id="echartPie1" style="height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <div class="card mb-4">
                    <div class="card-body"> 
                        <div class="card-title">İstiqamətlər üzrə</div>
                        <div id="basicDoughnut" style="height: 400px;"></div>     
                    </div>
            </div>
        </div>

        <div class=" col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Proqramın yayımlandığı yerə görə</div>
                    <div id="echartPie2" style="height: 400px;"></div>
                </div>
            </div>
        </div>

        <div class=" col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Proqramın yayımlandığı dillərə görə</div>
                    <div id="basicBar-chart" style="height: 400px;"></div>
                </div>
            </div>
        </div> 
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card mb-4">
                <div class="card-body"> 
                    <div class="card-title">Tezliklərə görə (Elektromaqnit sahə gərginliyinin səviyyəsi)</div>
                    <div id="basicLine-chart"></div>    
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')
    <script>
        $(document).ready(function() {

            var dates = [];
            var tvData = [];
            var fmData = [];
            
            var langValue = [];
            var langName = [];

            var emfs_in = [];
            var emfs_out = [];
            var emfs_report_date = [];

            @foreach ($foreign_measurements as $measurement)
                dates.push("{{ $measurement['date'] }}");
                tvData.push({{ $measurement['TV'] }});
                fmData.push({{ $measurement['FM'] }});
            @endforeach

            @foreach ($emfs as $emfs_level)
                emfs_in.push({{ $emfs_level['in'] }});
                emfs_out.push({{ $emfs_level['out'] }});
                emfs_report_date.push("{{ $emfs_level['report_date'] }}");
            @endforeach


      
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
                    },
                    xAxis: [{
                        type: 'category',
                        data: dates,
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
                        max: {{ $station_max_foreign_broadcasts_count}},
                        interval: 1,
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
                        data: tvData,
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
                        data:  fmData,
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

            var echartElemPie1 = document.getElementById('echartPie1');
            if (echartElemPie1) {
                var echartPie = echarts.init(echartElemPie1);
                echartPie.setOption({
                    color: ['#62549c', '#7566b5', '#7d6cbb', '#8877bd', '#9181bd', '#6957af'],
                    tooltip: {
                        show: 1,
                        backgroundColor: 'rgba(0, 0, 0, .8)'
                    },

                    series: [{
                        type: 'pie',
                        radius: '60%',
                        center: ['50%', '50%'],
                        data: {!! json_encode($totalFrequencyDataForeign) !!},
                        itemStyle: {
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }]
                });
                $(window).on('resize', function() {
                    setTimeout(function() {
                        echartPie.resize();
                    }, 500);
                });
            }



            var p = document.getElementById("basicDoughnut");
            if (p) {
                var u = echarts.init(p);
                u.setOption({
                    grid: {
                        left: "3%",
                        right: "4%",
                        bottom: "3%",
                        containLabel: !0
                    },
                    color: ["#0d94bc","#f36e12", "#135bba", "#c13018",  "#ebcb37", "#a1b968"],
                    tooltip: {
                        show: true,
                        trigger: "item",
                        formatter: "{a} <br/>{b}: {c} ({d}%)"
                    },
                    xAxis: [{
                        axisLine: {
                            show: !1
                        },
                        splitLine: {
                            show: !1
                        }
                    }],
                    yAxis: [{
                        axisLine: {
                            show: !1
                        },
                        splitLine: {
                            show: !1
                        }
                    }],
                    series: [{
                        name: "İstiqamət",
                        type: "pie",
                        radius: ["50%", "85%"],
                        center: ["50%", "50%"],
                        avoidLabelOverlap: !1,
                        hoverOffset: 5,
                        label: {
                            normal: {
                                show: !1,
                                position: "right",
                                textStyle: {
                                    fontSize: "13",
                                    fontWeight: "normal"
                                },
                                formatter: "{a}"
                            },
                            emphasis: {
                                show: !0,
                                textStyle: {
                                    fontSize: "15",
                                    fontWeight: "bold"
                                },
                                formatter: "{b} \n{c} ({d}%)"
                            }
                        },
                        labelLine: {
                            normal: {
                                show: 1
                            }
                        },
                        data: {!! json_encode($directionsData) !!},
                        itemStyle: {
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: "rgba(0, 0, 0, 0.5)"
                            }
                        }
                    }]
                }), $(window).on("resize", function() {
                    setTimeout(function() {
                        u.resize()
                    }, 500)
                })
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
                    dataLabels: {
                        enabled: true
                    },
                    series: [{
                        name: 'İstiqamət üzrə',
                        type: 'pie',
                        radius: '60%',
                        center: ['50%', '50%'],
                        data: {!! json_encode($totalFrequencyDataForeign) !!},
                        itemStyle: {
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }]
                });
                $(window).on('resize', function() {
                    setTimeout(function() {
                        echartPie.resize();
                    }, 500);
                });
            }


            var echartElemPie2 = document.getElementById('echartPie2');
            if (echartElemPie2) {
                var echartPie = echarts.init(echartElemPie2);
                echartPie.setOption({
                    color: ['#62549c', '#7566b5', '#7d6cbb', '#8877bd', '#9181bd', '#6957af'],
                    tooltip: {
                        show: true,
                        backgroundColor: 'rgba(0, 0, 0, .8)'
                    },
                    
                    dataLabels: {
                        enabled: true
                    },
                    series: [{
                        type: 'pie',
                        radius: '60%',
                        center: ['50%', '50%'],
                        data: {!! json_encode($programLocationsData) !!},
                        itemStyle: {
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }]
                });
                $(window).on('resize', function() {
                    setTimeout(function() {
                        echartPie.resize();
                    }, 500);
                });
            }



            var bbar = {
                chart: {
                    height: 250,
                    type: "bar",
                    toolbar: {
                        show: 1
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: true
                },
                series: [{
                    data: {!! json_encode(array_column($programLanguagesData, 'value')) !!}
                }],
                xaxis: {
                    categories: {!! json_encode(array_column($programLanguagesData, 'name')) !!}
                }
            };

            new ApexCharts(document.querySelector("#basicBar-chart"), bbar).render();
            
            emfs = {
                chart: {
                    height: 350,
                    type: "line",
                    shadow: {enabled: !0, color: "#000", top: 18, left: 7, blur: 10, opacity: 1},
                    toolbar: {show: true},
                    animations: {
                        enabled: !0,
                        easing: "linear",
                        speed: 500,
                        animateGradually: {enabled: !0, delay: 150},
                        dynamicAnimation: {enabled: !0, speed: 550}
                    }
                },
                colors: ["#ff0000", "#77B6EA"],
                dataLabels: {enabled: false},
                stroke: {curve: "smooth"},
                series: [{name: "Vurulur - ", data: emfs_out}, {
                    name: "Qəbul edilir - ",
                    data: emfs_in
                }],
                grid: {borderColor: "#e7e7e7", row: {colors: ["#f3f3f3", "transparent"], opacity: .5}},
                markers: {size: 6},
                xaxis: {categories: emfs_report_date},
                yaxis: {title: {text: "EMSG səviyyəsi"}, min: 5, max: 100},
                legend: {position: "top", horizontalAlign: "right", floating: !0, offsetY: -25, offsetX: -5}
            };
            new ApexCharts(document.querySelector("#basicLine-chart"), emfs).render();
        })
    </script>
@endsection
