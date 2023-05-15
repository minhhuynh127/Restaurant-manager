@extends('admin.share.master')
@section('noi_dung')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                        <div class="row">
                            <div class="col-3 mt-4">
                                <h6>Thống Kê</h6>
                            </div>
                            <div class="col-3">

                            </div>
                            <div class="col">
                                <h6>Từ Ngày</h6>
                                <input id="begin" type="date" class="form-control">
                            </div>
                            <div class="col">
                                <h6>Đến Ngày</h6>
                                <input id="end" type="date" class="form-control">
                            </div>
                            <div class="col mt-4">
                                <button type="button" id="thong-ke" class="btn btn-success">
                                    Thống Kê
                                </button>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div>
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('myChart');
        var list_ten = [];
        var list_tien = [];
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: '# of Votes',
                    data: [],
                    borderWidth: 1,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(217, 136, 128)',
                        'rgb(192, 57, 43)',
                        'rgb(195, 155, 211 )',
                        'rgb(136, 78, 160)',
                        'rgb(84, 153, 199)',
                        'rgb(21, 67, 96)',
                        'rgb(46, 204, 113)',
                        'rgb(241, 196, 15)',
                        'rgb(160, 64, 0)',
                    ],

                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        $('#thong-ke').click(function() {
            var payload = {
                'begin' : $('#begin').val(),
                'end'   : $('#end').val(),
            }
            axios
                .post('/admin/thong-ke/khach-hang', payload)
                .then((res) => {
                    list_ten = res.data.list_ten;
                    list_tien = res.data.list_tien;
                })
                .catch((res) => {
                    $.each(res.response.data.errors, function(k, v) {
                        toastr.error(v[0]);
                    });
                })
                .finally(function() {
                    myChart.data.labels             = list_ten;
                    myChart.data.datasets[0].data   = list_tien;
                    myChart.update();
                });
        });
    </script>
@endsection
