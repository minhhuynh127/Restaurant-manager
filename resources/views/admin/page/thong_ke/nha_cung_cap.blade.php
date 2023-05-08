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
    var list_ten_nha_cc = [];
    var list_so_lan_nhap = [];
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: '# of Votes',
                data: [],
                borderWidth: 1,
                backgroundColor: [
                    'rgb(255,224,230)',
                    'rgb(255,236,217)',
                    'rgb(255,245,221)',
                    'rgb(219,242,242)',
                    'rgb(215,236,251)',
                    'rgb(230,219,250)',
                    'rgb(244,245,245)',
                ],
                borderColor: [
                    'rgb(255,99,132)',
                    'rgb(255,183,112)',
                    'rgb(248,211,121)',
                    'rgb(164,223,223)',
                    'rgb(102,185,241)',
                    'rgb(153,102,255)',
                    'rgb(201,203,207)'
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
                .post('/admin/thong-ke/nha-cung-cap', payload)
                .then((res) => {
                    list_ten_nha_cc = res.data.list_ten_nha_cc;
                    list_so_lan_nhap = res.data.list_so_lan_nhap;
                })
                .catch((res) => {
                    $.each(res.response.data.errors, function(k, v) {
                        toastr.error(v[0]);
                    });
                })
                .finally(function() {
                    myChart.data.labels             = list_ten_nha_cc;
                    myChart.data.datasets[0].data   = list_so_lan_nhap;
                    myChart.update();
                });
        });

</script>
@endsection
