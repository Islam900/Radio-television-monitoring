<div class="col-lg-4 col-sm-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="card-title">İstiqamətlər üzrə</div>
            <div id="echartPie" style="height: 300px;"></div>
        </div>
    </div>
</div>

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

    </script>
@endsection
