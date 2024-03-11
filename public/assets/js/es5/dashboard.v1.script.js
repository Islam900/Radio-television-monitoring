'use strict';

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

$(document).ready(function () {

    // Chart in Dashboard version 1
    var echartElemBar = document.getElementById('echartBar');
    if (echartElemBar) {
        var echartBar = echarts.init(echartElemBar);
        echartBar.setOption({
            legend: {
                borderRadius: 0,
                orient: 'horizontal',
                x: 'right',
                data: ['Online', 'Offline']
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
                data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
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
                    formatter: '${value}'
                },
                min: 0,
                max: 100000,
                interval: 25000,
                axisLine: {
                    show: false
                },
                splitLine: {
                    show: true,
                    interval: 'auto'
                }
            }],

            series: [{
                name: 'Online',
                data: [35000, 69000, 22500, 60000, 50000, 50000, 30000, 80000, 70000, 60000, 20000, 30005],
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
                name: 'Offline',
                data: [45000, 82000, 35000, 93000, 71000, 89000, 49000, 91000, 80200, 86000, 35000, 40050],
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

    // Chart in Dashboard version 1


    // Chart in Dashboard version 1
    var echartElem1 = document.getElementById('echart1');
    if (echartElem1) {
        var echart1 = echarts.init(echartElem1);
        echart1.setOption(_extends({}, echartOptions.lineFullWidth, {
            series: [_extends({
                data: [30, 40, 20, 50, 40, 80, 90]
            }, echartOptions.smoothLine, {
                markArea: {
                    label: {
                        show: true
                    }
                },
                areaStyle: {
                    color: 'rgba(102, 51, 153, .2)',
                    origin: 'start'
                },
                lineStyle: {
                    color: '#663399'
                },
                itemStyle: {
                    color: '#663399'
                }
            })]
        }));
        $(window).on('resize', function () {
            setTimeout(function () {
                echart1.resize();
            }, 500);
        });
    }
    // Chart in Dashboard version 1
    var echartElem2 = document.getElementById('echart2');
    if (echartElem2) {
        var echart2 = echarts.init(echartElem2);
        echart2.setOption(_extends({}, echartOptions.lineFullWidth, {
            series: [_extends({
                data: [30, 10, 40, 10, 40, 20, 90]
            }, echartOptions.smoothLine, {
                markArea: {
                    label: {
                        show: true
                    }
                },
                areaStyle: {
                    color: 'rgba(255, 193, 7, 0.2)',
                    origin: 'start'
                },
                lineStyle: {
                    color: '#FFC107'
                },
                itemStyle: {
                    color: '#FFC107'
                }
            })]
        }));
        $(window).on('resize', function () {
            setTimeout(function () {
                echart2.resize();
            }, 500);
        });
    }
    // Chart in Dashboard version 1

});
