<html>

<head>
    <title>Pseudo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>


<body class="container">
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="#">Pseudo</a>
    </nav>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Create New Word
    </button>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Word</th>
                <th scope="col">Created_at</th>
                <th scope="col">Updated_at</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="list">

        </tbody>
    </table>
</body>



<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Word Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="form-control" name="id" id="id">
                <input type="text" class="form-control" name="word" id="word">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save" onclick="save()">Save changes</button>
                <button type="button" class="btn btn-primary" id="update" onclick="update()">Save changes</button>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>

<script>
    getList();

    function getList() {

        $.ajax({
            url: "{{ route('word.list') }}",
            type: 'GET',
            data: {},
            dataType: "json",
            success: function(response) {
                if (response.status == 1) {
                    html = '';
                    $.each(response.data, function(key, val) {
                        html += '<tr>' +
                            '<td>' + (key + 1) + '</td>' +
                            '<td>' + val['word'] + '</td>' +
                            '<td>' + val['created_at'] + '</td>' +
                            '<td>' + val['updated_at'] + '</td>' +
                            '<td><button type="button" onclick="getDetail(' + val['id'] + ')" class="btn btn-primary">Edit</button> <button type="button" id="action" onclick="deletedeatil(' + val['id'] + ')" class="btn btn-danger">Delete</button></td>' +
                            '</tr>';
                    });
                    $("#list").html(html);
                } else {
                    alert('something went wrong');
                }
            }
        });
    }

    function getDetail(id) {
        $("#save").hide();
        $("#update").show();
        $.ajax({
            url: "{{ url('api/word-detail') }}/" + id,
            type: 'get',
            data: {},
            dataType: "json",
            success: function(response) {
                $("#word").val(response.data.word);
                $("#id").val(response.data.id);
                $("#exampleModal").modal('show');
            }
        });
    }

    function deletedeatil(id) {
       
        $.ajax({
            url: "{{ url('api/word-delete') }}/" + id,
            type: 'delete',
            data: {},
            dataType: "json",
            success: function(response) {
                getList();
            }
        });
    }

    function save() {
        word = $("#word").val();
        if (word == '') {
            alert("Enter Word");
            return false;
        } else {

            $.ajax({
                url: "{{ url('api/word-insert') }}/",
                type: 'post',
                data: {
                    'word': word
                },
                dataType: "json",
                success: function(response) {
                    if (response.status == 0) {
                        alert("something went wrong");
                    } else {
                        getList();
                    }
                    $("#exampleModal").modal('hide');
                }
            });
        }


    }

    function update() {
        word = $("#word").val();
        id = $("#id").val();
        if (word == '' || word == '') {
            alert("Enter Word");
            return false;
        } else {

            $.ajax({
                url: "{{ url('api/word-update') }}/"+id,
                type: 'patch',
                data: {
                    'word': word
                },
                dataType: "json",
                success: function(response) {
                    if (response.status == 0) {
                        alert("something went wrong");
                    } else {
                        getList();
                    }
                    $("#exampleModal").modal('hide');
                }
            });
        }
        $("#save").show();
        $("#update").hide();

    }
</script>

</html>