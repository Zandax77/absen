@extends('blank')
@section('isi')

<div class="container py-3">
<div class="text-center mb-3">
    <h1 class="fs-3 fw-bold">Kehadiran Siswa</h1>
    <h3 class="fs-5"><b>{{ $school_name ?? 'SMKN 6 JEMBER' }}</b></h3><?php date_default_timezone_set('Asia/Jakarta');?>
    <h5 class="fs-6 text-muted">Tanggal : {{date('d/m/Y')}}</h5>
</div>

<div class="card">
    <div class="card-body">
      <h5 class="card-title"></h5>

      <!-- Default Tabs — scrollable on mobile -->
      <div style="overflow-x:auto; -webkit-overflow-scrolling:touch; scrollbar-width:none; margin-bottom:0;">
        <ul class="nav nav-tabs flex-nowrap" id="myTabjustified" role="tablist" style="min-width:max-content;">
            <li class="nav-item" role="presentation">
            <button class="nav-link" id="rpl-tab" data-bs-toggle="tab" data-bs-target="#rpl-justified" type="button" role="tab" aria-controls="home" aria-selected="true">RPL</button>
            </li>
            <li class="nav-item" role="presentation">
            <button class="nav-link" id="dkv-tab" data-bs-toggle="tab" data-bs-target="#dkv-justified" type="button" role="tab" aria-controls="profile" aria-selected="false">DKV/dkv</button>
            </li>
            <li class="nav-item" role="presentation">
            <button class="nav-link" id="kkbt-tab" data-bs-toggle="tab" data-bs-target="#kkbt-justified" type="button" role="tab" aria-controls="contact" aria-selected="false">KKBT</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="ak-tab" data-bs-toggle="tab" data-bs-target="#ak-justified" type="button" role="tab" aria-controls="home" aria-selected="false">AK/AKL</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="mp-tab" data-bs-toggle="tab" data-bs-target="#mp-justified" type="button" role="tab" aria-controls="profile" aria-selected="false">MP/OTKP</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="bd-tab" data-bs-toggle="tab" data-bs-target="#bd-justified" type="button" role="tab" aria-controls="contact" aria-selected="false">BD/BR</button>
            </li>
          </ul>
      </div>

      <div class="tab-content pt-2" id="myTabjustifiedContent">
        <div class="tab-pane fade" id="rpl-justified" role="tabpanel" aria-labelledby="rpl-tab">

            <div class="row" align="center">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelas X</h5>

                            <!-- Pie Chart -->
                            <canvas id="xrpl" style="max-height: 400px;"></canvas>
                            <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#xrpl'), {
                                type: 'pie',
                                data: {
                                    labels: [
                                    'Alpa',
                                    'Sakit',
                                    'Izin',
                                    'Hadir'
                                    ],
                                    datasets: [{
                                    label: '',
                                    data: [{{$xrplA}}, {{$xrplS}}, {{$xrplI}},{{$xrpl}}],
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)',
                                        'rgb(152, 251, 153)'
                                    ],
                                    hoverOffset: 4
                                    }]
                                }
                                });
                            });
                            </script>
                            <!-- End Pie CHart -->
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelas XI</h5>

                            <!-- Pie Chart -->
                            <canvas id="xirpl" style="max-height: 400px;"></canvas>
                            <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#xirpl'), {
                                type: 'pie',
                                data: {
                                    labels: [
                                    'Alpa',
                                    'Sakit',
                                    'Izin',
                                    'Hadir'
                                    ],
                                    datasets: [{
                                    label: '',
                                    data: [{{$xirplA}}, {{$xirplS}}, {{$xirplI}},{{$xirpl}}],
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)',
                                        'rgb(152, 251, 153)'
                                    ],
                                    hoverOffset: 4
                                    }]
                                }
                                });
                            });
                            </script>
                            <!-- End Pie CHart -->
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelas XII</h5>

                            <!-- Pie Chart -->
                            <canvas id="xiirpl" style="max-height: 400px;"></canvas>
                            <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#xiirpl'), {
                                type: 'pie',
                                data: {
                                    labels: [
                                    'Alpa',
                                    'Sakit',
                                    'Izin',
                                    'Hadir'
                                    ],
                                    datasets: [{
                                    label: '',
                                    data: [{{$xiirplA}}, {{$xiirplS}}, {{$xiirplI}},{{$xiirpl}}],
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)',
                                        'rgb(152, 251, 153)'
                                    ],
                                    hoverOffset: 4
                                    }]
                                }
                                });
                            });
                            </script>
                            <!-- End Pie CHart -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="tab-pane fade" id="dkv-justified" role="tabpanel" aria-labelledby="dkv-tab">

            <div class="row" align="center">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelas X</h5>

                            <!-- Pie Chart -->
                            <canvas id="xdkv" style="max-height: 400px;"></canvas>
                            <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#xdkv'), {
                                type: 'pie',
                                data: {
                                    labels: [
                                    'Alpa',
                                    'Sakit',
                                    'Izin',
                                    'Hadir'
                                    ],
                                    datasets: [{
                                    label: '',
                                    data: [{{$xdkvA}}, {{$xdkvS}}, {{$xdkvI}},{{$xdkv}}],
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)',
                                        'rgb(152, 251, 153)'
                                    ],
                                    hoverOffset: 4
                                    }]
                                }
                                });
                            });
                            </script>
                            <!-- End Pie CHart -->
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelas XI</h5>

                            <!-- Pie Chart -->
                            <canvas id="xidkv" style="max-height: 400px;"></canvas>
                            <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#xidkv'), {
                                type: 'pie',
                                data: {
                                    labels: [
                                    'Alpa',
                                    'Sakit',
                                    'Izin',
                                    'Hadir'
                                    ],
                                    datasets: [{
                                    label: '',
                                    data: [{{$xidkvA}}, {{$xidkvS}}, {{$xidkvI}},{{$xidkv}}],
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)',
                                        'rgb(152, 251, 153)'
                                    ],
                                    hoverOffset: 4
                                    }]
                                }
                                });
                            });
                            </script>
                            <!-- End Pie CHart -->
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelas XII</h5>

                            <!-- Pie Chart -->
                            <canvas id="xiidkv" style="max-height: 400px;"></canvas>
                            <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#xiidkv'), {
                                type: 'pie',
                                data: {
                                    labels: [
                                    'Alpa',
                                    'Sakit',
                                    'Izin',
                                    'Hadir'
                                    ],
                                    datasets: [{
                                    label: '',
                                    data: [{{$xiiDKVA}}, {{$xiiDKVS}}, {{$xiiDKVI}},{{$xiiDKV}}],
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)',
                                        'rgb(152, 251, 153)'
                                    ],
                                    hoverOffset: 4
                                    }]
                                }
                                });
                            });
                            </script>
                            <!-- End Pie CHart -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="tab-pane fade" id="kkbt-justified" role="tabpanel" aria-labelledby="kkbt-tab">

            <div class="row" align="center">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelas X</h5>

                            <!-- Pie Chart -->
                            <canvas id="xkkbt" style="max-height: 400px;"></canvas>
                            <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#xkkbt'), {
                                type: 'pie',
                                data: {
                                    labels: [
                                    'Alpa',
                                    'Sakit',
                                    'Izin',
                                    'Hadir'
                                    ],
                                    datasets: [{
                                    label: '',
                                    data: [{{$xkkbtA}}, {{$xkkbtS}}, {{$xkkbtI}},{{$xkkbt}}],
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)',
                                        'rgb(152, 251, 153)'
                                    ],
                                    hoverOffset: 4
                                    }]
                                }
                                });
                            });
                            </script>
                            <!-- End Pie CHart -->
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelas XI</h5>

                            <!-- Pie Chart -->
                            <canvas id="xikkbt" style="max-height: 400px;"></canvas>
                            <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#xikkbt'), {
                                type: 'pie',
                                data: {
                                    labels: [
                                    'Alpa',
                                    'Sakit',
                                    'Izin',
                                    'Hadir'
                                    ],
                                    datasets: [{
                                    label: '',
                                    data: [{{$xikkbtA}}, {{$xikkbtS}}, {{$xikkbtI}},{{$xikkbt}}],
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)',
                                        'rgb(152, 251, 153)'
                                    ],
                                    hoverOffset: 4
                                    }]
                                }
                                });
                            });
                            </script>
                            <!-- End Pie CHart -->
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelas XII</h5>

                            <!-- Pie Chart -->
                            <canvas id="xiikkbt" style="max-height: 400px;"></canvas>
                            <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#xiikkbt'), {
                                type: 'pie',
                                data: {
                                    labels: [
                                    'Alpa',
                                    'Sakit',
                                    'Izin',
                                    'Hadir'
                                    ],
                                    datasets: [{
                                    label: '',
                                    data: [{{$xiikkbtA}}, {{$xiikkbtS}}, {{$xiikkbtI}},{{$xiikkbt}}],
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)',
                                        'rgb(152, 251, 153)'
                                    ],
                                    hoverOffset: 4
                                    }]
                                }
                                });
                            });
                            </script>
                            <!-- End Pie CHart -->
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="tab-pane fade" id="ak-justified" role="tabpanel" aria-labelledby="ak-tab">

            <div class="row" align="center">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelas X</h5>

                            <!-- Pie Chart -->
                            <canvas id="xak" style="max-height: 400px;"></canvas>
                            <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#xak'), {
                                type: 'pie',
                                data: {
                                    labels: [
                                    'Alpa',
                                    'Sakit',
                                    'Izin',
                                    'Hadir'
                                    ],
                                    datasets: [{
                                    label: '',
                                    data: [{{$xakA}}, {{$xakS}}, {{$xakI}},{{$xak}}],
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)',
                                        'rgb(152, 251, 153)'
                                    ],
                                    hoverOffset: 4
                                    }]
                                }
                                });
                            });
                            </script>
                            <!-- End Pie CHart -->
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelas XI</h5>

                            <!-- Pie Chart -->
                            <canvas id="xiak" style="max-height: 400px;"></canvas>
                            <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#xiak'), {
                                type: 'pie',
                                data: {
                                    labels: [
                                    'Alpa',
                                    'Sakit',
                                    'Izin',
                                    'Hadir'
                                    ],
                                    datasets: [{
                                    label: '',
                                    data: [{{$xiakA}}, {{$xiakS}}, {{$xiakI}},{{$xiak}}],
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)',
                                        'rgb(152, 251, 153)'
                                    ],
                                    hoverOffset: 4
                                    }]
                                }
                                });
                            });
                            </script>
                            <!-- End Pie CHart -->
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelas XII</h5>

                            <!-- Pie Chart -->
                            <canvas id="xiiak" style="max-height: 400px;"></canvas>
                            <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#xiiak'), {
                                type: 'pie',
                                data: {
                                    labels: [
                                    'Alpa',
                                    'Sakit',
                                    'Izin',
                                    'Hadir'
                                    ],
                                    datasets: [{
                                    label: '',
                                    data: [{{$xiiakA}}, {{$xiiakS}}, {{$xiiakI}},{{$xiiak}}],
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)',
                                        'rgb(152, 251, 153)'
                                    ],
                                    hoverOffset: 4
                                    }]
                                }
                                });
                            });
                            </script>
                            <!-- End Pie CHart -->
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="tab-pane fade" id="mp-justified" role="tabpanel" aria-labelledby="mp-tab">

            <div class="row" align="center">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelas X</h5>

                            <!-- Pie Chart -->
                            <canvas id="xmp" style="max-height: 400px;"></canvas>
                            <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#xmp'), {
                                type: 'pie',
                                data: {
                                    labels: [
                                    'Alpa',
                                    'Sakit',
                                    'Izin',
                                    'Hadir'
                                    ],
                                    datasets: [{
                                    label: '',
                                    data: [{{$xmpA}}, {{$xmpS}}, {{$xmpI}},{{$xmp}}],
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)',
                                        'rgb(152, 251, 153)'
                                    ],
                                    hoverOffset: 4
                                    }]
                                }
                                });
                            });
                            </script>
                            <!-- End Pie CHart -->
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelas XI</h5>

                            <!-- Pie Chart -->
                            <canvas id="ximp" style="max-height: 400px;"></canvas>
                            <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#ximp'), {
                                type: 'pie',
                                data: {
                                    labels: [
                                    'Alpa',
                                    'Sakit',
                                    'Izin',
                                    'Hadir'
                                    ],
                                    datasets: [{
                                    label: '',
                                    data: [{{$ximpA}}, {{$ximpS}}, {{$ximpI}},{{$ximp}}],
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)',
                                        'rgb(0,255,0)'
                                    ],
                                    hoverOffset: 4
                                    }]
                                }
                                });
                            });
                            </script>
                            <!-- End Pie CHart -->
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelas XII</h5>

                            <!-- Pie Chart -->
                            <canvas id="xiimp" style="max-height: 400px;"></canvas>
                            <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#xiimp'), {
                                type: 'pie',
                                data: {
                                    labels: [
                                    'Alpa',
                                    'Sakit',
                                    'Izin',
                                    'Hadir'
                                    ],
                                    datasets: [{
                                    label: '',
                                    data: [{{$xiimpA}}, {{$xiimpS}}, {{$xiimpI}},{{$xiimp}}],
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)',
                                        'rgb(152, 251, 153)'
                                    ],
                                    hoverOffset: 4
                                    }]
                                }
                                });
                            });
                            </script>
                            <!-- End Pie CHart -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="bd-justified" role="tabpanel" aria-labelledby="bd-tab">

            <div class="row" align="center">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelas X</h5>

                            <!-- Pie Chart -->
                            <canvas id="xbd" style="max-height: 400px;"></canvas>
                            <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#xbd'), {
                                type: 'pie',
                                data: {
                                    labels: [
                                    'Alpa',
                                    'Sakit',
                                    'Izin',
                                    'Hadir'
                                    ],
                                    datasets: [{
                                    label: '',
                                    data: [{{$xbdA}}, {{$xbdS}}, {{$xbdI}},{{$xbd}}],
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)',
                                        'rgb(152, 251, 153)'
                                    ],
                                    hoverOffset: 4
                                    }]
                                }
                                });
                            });
                            </script>
                            <!-- End Pie CHart -->
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelas XI</h5>

                            <!-- Pie Chart -->
                            <canvas id="xibr" style="max-height: 400px;"></canvas>
                            <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#xibr'), {
                                type: 'pie',
                                data: {
                                    labels: [
                                    'Alpa',
                                    'Sakit',
                                    'Izin',
                                    'Hadir'
                                    ],
                                    datasets: [{
                                    label: '',
                                    data: [{{$xibdA}}, {{$xibdS}}, {{$xibdI}},{{$xibd}}],
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)',
                                        'rgb(152, 251, 153)'
                                    ],
                                    hoverOffset: 4
                                    }]
                                }
                                });
                            });
                            </script>
                            <!-- End Pie CHart -->
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelas XII</h5>

                            <!-- Pie Chart -->
                            <canvas id="xiibdp" style="max-height: 400px;"></canvas>
                            <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#xiibdp'), {
                                type: 'pie',
                                data: {
                                    labels: [
                                    'Alpa',
                                    'Sakit',
                                    'Izin',
                                    'Hadir'
                                    ],
                                    datasets: [{
                                    label: '',
                                    data: [{{$xiibdA}}, {{$xiibdS}}, {{$xiibdI}},{{$xiibd}}],
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)',
                                        'rgb(152, 251, 153)'
                                    ],
                                    hoverOffset: 4
                                    }]
                                }
                                });
                            });
                            </script>
                            <!-- End Pie CHart -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div><!-- End Default Tabs -->
    </div>
</div>

<div class="row justify-content-center mt-3">
    <div class="col-12 col-lg-10">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center">Total Absensi Siswa</h5>

                <!-- Pie Chart -->
                <canvas id="total" style="max-height: 400px;"></canvas>
                <script>
                document.addEventListener("DOMContentLoaded", () => {
                    new Chart(document.querySelector('#total'), {
                    type: 'pie',
                    data: {
                        labels: [
                        'Alpa',
                        'Sakit',
                        'Izin',
                        'Hadir'
                        ],
                        datasets: [{
                        label: '',
                        data: [{{$A}}, {{$S}}, {{$I}},{{$hadir}}],
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)',
                            'rgb(152, 251, 153)'
                        ],
                        hoverOffset: 4
                        }]
                    }
                    });
                });
                </script>
                <!-- End Pie Chart -->
            </div>
        </div>
    </div>
</div>
@endsection