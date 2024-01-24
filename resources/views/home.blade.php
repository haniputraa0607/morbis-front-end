<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Antrian</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .queue-container {
            width: 400px;
            margin: auto;
            margin-top: 50px;
        }

        .queue-card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="mt-5">Sistem Antrian</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="queue-container mb-5">

                <div class="card queue-card">
                    <div class="card-body text-center">
                        <h2 class="card-title">Antrian Sekarang</h2>
                        <h3 class="card-text" id="currentQueue">{{ $current['code'] ?? '-' }}</h3>
                    </div>
                </div>

                <div class="text-center">
                    <a class="btn btn-secondary" id="prev">Sebelumnya</a>
                    <a class="btn btn-success mx-2" id="finish">Selesaikan</a>
                    <a class="btn btn-primary" id="next">Selanjutnya</a>
                </div>

            </div>
        </div>
        <div class="col-md-12">
            <div class="queue-container mt-5">

                 <div class="mt-4">
                    <h2 class="text-center mb-3">Semua Antrian Hari Ini</h2>
                    <div class="card">
                        <div class="card-body">
                            <table class="table text-center">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Kode Antrian</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="dataQueue">
                                    @if (count($list)>0)
                                        @php $no = 1; @endphp
                                        @foreach ( $list ?? [] as $key => $l )
                                        <tr id="data-{{ $l['id'] }}">
                                            <th scope="row">{{ $no }}</th>
                                            <td>{{ $l['code'] }}</td>
                                            <td id="status">{{ $l['status'] }}</td>
                                        </tr>
                                        @php $no++; @endphp
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" class="text-center">Antrian Kosong</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12 text-center">
            <a class="btn btn-danger" href="{{ url('logout') }}">Log out</a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function () {

        // Prev
        $('#prev').on('click', function () {
            $.ajax({
                type : "GET",
                url : "{{ url('queue/prev') }}",
                success: function (response) {
                    if (response.current.code !== null && response.current.code !== undefined) {
                        $(`#currentQueue`).text(response.current.code)
                        $('td:contains("Sekarang")').text('Menunggu')
                        $(`#data-${response.current.id} #status`).text('Sekarang')
                    }
                }
            });
        });

        // Finish
        $('#finish').on('click', function () {
            $.ajax({
                type : "GET",
                url : "{{ url('queue/finish') }}",
                success: function (response) {
                    if (response.current.code !== null && response.current.code !== undefined) {
                        $(`#currentQueue`).text(response.current.code)
                        $('td:contains("Sekarang")').text('Selesai')
                        $(`#data-${response.current.id} #status`).text('Sekarang')
                    }
                }
            });
        });

        // Next
        $('#next').on('click', function () {
            $.ajax({
                type : "GET",
                url : "{{ url('queue/next') }}",
                success: function (response) {
                    if (response.current.code !== null && response.current.code !== undefined) {
                        $(`#currentQueue`).text(response.current.code)
                        $('td:contains("Sekarang")').text('Menunggu')
                        $(`#data-${response.current.id} #status`).text('Sekarang')
                    }
                }
            });
        });

        function isObjectEmpty(obj) {
            return Object.keys(obj).length === 0 && obj.constructor === Object;
        }

    });
</script>

</body>
</html>
