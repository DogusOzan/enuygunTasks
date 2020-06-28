



<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Enuygun Tüm Taskler</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

</head>
<body>

<table class="table table-dark">
    <thead>
    <tr>
        <th scope="col">id</th>
        <th scope="col">Task Adı</th>
        <th scope="col">Zorluğu</th>
        <th scope="col">Süresi</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $key => $value)
    <tr>
        <th scope="row">{{$value['id']}}</th>
        <td>{{$value['task_id']}}</td>
        <td>{{$value['level']}}</td>
        <td>{{$value['time']}}</td>
    </tr>
    @endforeach
    </tbody>
</table>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>



