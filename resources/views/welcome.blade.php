@extends('layouts.template')
@push('css')
     <link
      rel="stylesheet"
      href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css"
    />
@endpush
@section('content')
    <main class="content">
        <div class="container-fluid p-0">

            {{-- <h1 class="h3 mb-3">Data Hasil</h1> --}}
            <div class="row">
                <div class="col-xl-6 col-xxl-5 d-flex">
                    <div class="w-100">
                        <div class="row" id="analisa_data">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Nilai PH</h5>
                                            </div>
                                        </div>
                                        <h1 class="mt-1 mb-3 nilai_ph" id="nilai_ph"> - </h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Nilai SUHU</h5>
                                            </div>
                                        </div>
                                        <h1 class="mt-1 mb-3 nilai_suhu"> - </h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Rata Rata</h5>
                                            </div>
                                        </div>
                                        <h1 class="mt-1 mb-3 rata" id="rata"></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-xxl-7">
                    <div class="card flex-fill w-100">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Keterangan Kualitas Air</h5>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3 nilai_ket">-</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="d-flex justify-content-end">
                                </div>
                            </div>
                            <canvas id="dataPH" width="1600" height="900"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="d-flex justify-content-end">

                                </div>
                            </div>
                            <canvas id="dataSUHU" width="1600" height="900"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    {{-- <h5 class="card-title mb-0">Data Arduino</h5> --}}
                </div>
                <div class="card-body">
                    <div class="row">
                         <div class="col-lg-8">
                            <table id="data-hasil" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Asam</th>
                                        <th>Netral</th>
                                        <th>Basa</th>
                                        <th>Rendah</th>
                                        <th>Normal</th>
                                        <th>Tinggi</th>
                                        <th>Rata Rata</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-4">
                            <table id="example" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>suhu</th>
                                        <th>ph</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection
@push('js')

{{-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script> --}}
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js" integrity="sha512-TW5s0IT/IppJtu76UbysrBH9Hy/5X41OTAbQuffZFU6lQ1rdcLHzpU5BzVvr/YFykoiMYZVWlr/PX1mDcfM9Qg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        selesai();
        dataHasil();
        var table =  $('#example').DataTable({
            //  location.reload();
            "responsive": true,
            "processing":true,
            "serverSide":true,
            ajax: {
                url: "{{ route('api-arduino.store') }}"
            },
            columns: [
            {
                "data": null, "sortable": false,
                render : function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1
                }
            },
            {
                data: 'suhu',name: 'suhu',
            },
            {
                data: 'ph',name:'ph',
            }
            ],

        });
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $.ajax({
                url: "{{ route('api-arduino.index') }}",
                method: 'get',
                success: function(data) {
                    // console.log(data);

                }
        });

    });
    function dataHasil() {
        var result;
        $.ajax({
            url: '{{ route('data.analisa') }}',
            type: 'get',
            success: function(data) {
                // console.log(data);
                $('tbody').html('');
                    $(data).each(function(x,y){
                        result =
                        '<tr>'
                            + '<td>'+y.nilai_asam+'</td>'
                            + '<td>'+y.nilai_netral+'</td>'
                            + '<td>'+y.nilai_basa+'</td>'
                            + '<td>'+y.nilai_rendah+'</td>'
                            + '<td>'+y.nilai_normal+'</td>'
                            + '<td>'+y.nilai_tinggi+'</td>'
                            + '<td>'+y.rata_rata+'</td>'
                        + '</tr>';
                        $('#data-hasil').append(result);
                    });
            }
        });
    }

    function selesai() {
            setTimeout(() => {
                dataTampil();
                selesai();
            }, 150);
    }
    function dataTampil() {
            $.ajax({
                url:'{{ route('data.tampil') }}',
                type:'get',
                success:function(data) {
                    // console.log(data);
                    $('#rata').html(data.data.rata_rata);
                    $('#nilai_ph').html(data.data_arduino.ph);
                    $('.nilai_suhu').html(data.data_arduino.suhu);
                    $('.nilai_ket').html(data.data.keterangan);
                }
            })
    }

</script>
<script>
// data suhu
window.onload = function () {
    var ctx_live = document.getElementById("dataPH");
    var myChart = new Chart(ctx_live, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
            data: [],
            borderWidth: 1,
            borderColor:'#00c0ef',
            label: 'PH',
            }]
        },
    });
    $.getJSON("{{ route('data.chart') }}", function(data_banyak) {
		console.log(data_banyak.data_banyak);
		$.each((data_banyak.data_banyak), function(key, value){
            myChart.data.labels.push("data ke- " + value['id']);
            myChart.data.datasets[0].data.push(value.ph);

		});
		myChart.update();
		updateChart();
	});
// // logic to get new data
function updateChart() {
    $.ajax({
    // url: 'https://jsonplaceholder.typicode.com/data ke-s/' + data ke-Id + '/comments',
    url: '{{ route('data.chart') }}',
    type: 'GET',
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(data) {
        console.log(data);

        $(data.data_update).each(function(x,y){
            // if (x.length == x.length) {
                myChart.data.labels.push("data ke- " + y.id);
                myChart.data.datasets[0].data.push(y.ph);
                // }
        });
        myChart.update();
    }
  });
};
// setInterval(() => {
//     updateChart();
// }, 10000);

// data suhu
var ctx_live = document.getElementById("dataSUHU");
    var myChartSuhu = new Chart(ctx_live, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
            data: [],
            borderWidth: 1,
            borderColor:'#00c0ef',
            label: 'SUHU',
            }]
        },
    });
    $.getJSON("{{ route('data.chart') }}", function(data_banyak) {
		console.log(data_banyak.data_banyak);
		$.each((data_banyak.data_banyak), function(key, value){
            myChartSuhu.data.labels.push("data ke- " + value['id']);
            myChartSuhu.data.datasets[0].data.push(value.suhu);

		});
		myChartSuhu.update();
		updateChartSuhu();
	});
// // logic to get new data
function updateChartSuhu() {
    $.ajax({
    // url: 'https://jsonplaceholder.typicode.com/posts/' + postId + '/comments',
    url: '{{ route('data.chart') }}',
    type: 'GET',
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(data) {
        console.log(data);

        $(data.data_update).each(function(x,y){
            // if (x.length == x.length) {
                myChartSuhu.data.labels.push("Post " + y.id);
                myChartSuhu.data.datasets[0].data.push(y.suhu);
                // }
        });
        myChartSuhu.update();
    }
  });
};

// setInterval(() => {
//     updateChartSuhu();
// }, 10000);

}

</script>


@endpush
