@extends('master')
@section("content")

<!-- modal box -->
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<!-- ------------- -->


<div class="panel-header panel-header-sm">
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">



                    <!-- onkeydown="return /[a-z, ]/i.test(event.key)" onblur="if (this.value == '') {this.value = '';}" onfocus="if (this.value == '') {this.value = '';}" -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">


                                    <h5 class="title">Role Detail</h5>
                                </div>
                                <div class="card-body">

                                    <form method="POST" action="update_role">
                                        @csrf
                                        <div id="check"></div>
                                        <input type="hidden" name="id" id="" value="{{$role['id']}}">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Fullname</label>
                                                    <input type="text" class="form-control" onkeyup="check_exist_role();" name="name" id="name" placeholder="name" value="{{$role['name']}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Permission</label>
                                                    <div id="checkboxes">

                                                        <input type="checkbox" id="Fresher_management" name="Fresher_management" value="Fresher management" required>
                                                        <label for="vehicle1">Fresher management</label><br>

                                                        <input type="checkbox" id="Timesheet_management" name="Timesheet_management" value="Timesheet management">
                                                        <label for="vehicle1">Timesheet management</label><br>

                                                        <input type="checkbox" id="Report_management" name="Report_management" value="Report management">
                                                        <label for="vehicle1">Report management</label><br>


                                                    </div>

                                                    <button type="submit" name="submit" id="submit" value="submit"> submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            const permision_list = [];
            <?php for ($i = 0; $i < count($permission); $i++) { ?>
                var tmp = '<?php echo $permission[$i]['name']; ?>';
                tmp = tmp.replace(/ /g, "_");
                document.getElementById(tmp).checked = true;
            <?php } ?>

        });

        function check_exist_role() {
            var isUpdate = '<?php echo $role['name']; ?>';
            var name = document.getElementById('name').value;
            $('#check').html('');

            $.ajax({
                url: "/check_exist_role",
                // method: "GET",
                type: "GET",
                data: {
                    name: name,
                    isUpdate: isUpdate,
                },
                dataType: "json",
                success: function(data) {
                    $('#check').html(data.msg);
                    console.log(data.msg);
                    if (data.msg != '') {
                        document.getElementById('submit').disabled = true;
                    } else {
                        document.getElementById('submit').disabled = false;
                    }
                    // $("#data").append(data.msg);
                    // document.getElementById('#result').innerHTML = data;
                    // $('#check').innerHTM = data;
                }
            });
        }
    </script>
    @endsection