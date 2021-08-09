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
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-body" id="detail">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">Add Fresher</h5>
                    </div>
                    <div class="card-body">
                        <form action="add_fresher">
                            @csrf
                           
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Fullname</label>
                                        <input type="text" class="form-control" onkeyup="setEmail();" name="name" id="name" placeholder="name">
                                    </div>
                                </div>
                            </div>


                            <!-- onkeydown="return /[a-z, ]/i.test(event.key)" onblur="if (this.value == '') {this.value = '';}" onfocus="if (this.value == '') {this.value = '';}" -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Date of birth</label>
                                        <input type="date" class="form-control" id="dob" name="dob" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 pr-1">
                                    <div class="form-group">
                                        <label>Part</label>
                                        <input type="text" class="form-control" placeholder="Part" name="part" required>
                                    </div>
                                </div>
                                <div class="col-md-4 px-1">
                                    <div class="form-group">
                                        <label>Class</label>
                                        <input type="text" class="form-control" placeholder="Class" name="class" required>
                                    </div>
                                </div>
                                <div class="col-md-4 pl-1">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="number" class="form-control" placeholder="Phone" name="phone" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="submit"> Submit</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<!-- ------------- -->
<div class="panel-header panel-header-sm">
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                {{$mess}}
                    {{$errors}}
                    @if(isset($add_success))
                    <p>Add fresher successfully</p>
                    @endif
                    <div class="row">


                        <button class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Add fresher</button>
                    </div>
                    <div>

                    </div>

                    <div class="input-group no-border">
                        <input type="text" id="search" onkeyup="searchFresher();" class="form-control" placeholder="Search...">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="now-ui-icons ui-1_zoom-bold"></i>
                            </div>
                        </div>
                        <div class="drop" onclick="myFunctiondrop()" style="float:right;">
                            <button class="dropbtn" style="border: none;">Filter</button>

                        </div>
                    </div>
                    <div class="row" id="demodrop" style="display: none;padding-bottom: 2%;">

                        <div class="col-6">

                            <legend>Choose class :</legend>
                            <?php $count = 1; ?>
                            <div id="checkboxes">
                                @foreach ($classes as $part)
                                <input type="checkbox" onclick="class_filter()" id="class" name="{{$part->class}}" value="{{$part->class}}">
                                <label for="vehicle1">{{$part->class}} </label><br>
                                <?php $count++; ?>

                                @endforeach
                            </div>
                        </div>

                        <!-- <input type="submit" value="Submit now" /> -->
                        <!-- </fieldset> -->
                    </div>
                    <!-- <input type="text" id="search" onkeyup="preClick(3);" placeholder="Search.."> -->

                </div>
                <div class="card-body">
                    <div style="overflow:auto;height: 400px;">
                        <table id="data" class="table">
                            <tbody id="databody">
                                <tr id="jstable1">

                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Part</th>
                                    <th>Class</th>
                                    <th>Function</th>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        var selected_ = [];

        function class_filter() {
            var selected = [];
            $('#checkboxes input:checked').each(function() {
                selected.push($(this).attr('name'));
            });
            selected_ = selected;
            searchFresher();
        }

        function deleteFresher(id_fresher) {
            var txt;
            if (confirm("Are you sure to delete ?")) {
                //yes

                searchFresher(id_fresher);
            } else {}
        }

        function detailFresher() {

        }

        function setEmail() {
            var name = document.getElementById("name").value;
            var lowcase = name.toLowerCase();
            var mail = '';
            const myArr1 = lowcase.split(" ");
            const myArr = [];
            for (var i = 0; i < myArr1.length; i++) {

                if (myArr1[i] === "") {
                    console.log("string herr :" + myArr1[i]);
                } else {
                    myArr.push(myArr1[i]);
                }
            }
            mail = myArr[myArr.length - 1];
            for (var i = 0; i < myArr.length - 1; i++) {
                mail = mail + myArr[i][0];
            }
            mail = mail + "@vmodev.com";
              mail = removeAccents(mail)
            document.getElementById("email").value = mail;
        }

        function removeAccents(str) {
            return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
        }
        $(document).ready(function() {
            searchFresher();
        });
        //ajax

        function searchFresher(delete_id) {
            //filter_class
            for (var i = 0; i < 3; i++) {
                if (typeof selected_[i] == 'undefined') {
                    // the variable is defined
                    selected_[i]='';

                }
            }
            //alert(selected_);
            //delete by id
            var deleteid = -1;
            if (typeof delete_id == 'undefined') {
                // the variable is defined

            } else {
                deleteid = delete_id;
            }
            $('#databody').children('#abc').remove();
            var txt = document.getElementById("search").value;
            $('#result').html('');
            $.ajax({
                url: "/fresher_ajax",
                // method: "GET",
                type: "GET",
                data: {
                    search: txt,
                    deleteid: deleteid,
                    class1: selected_[0],
                    class2: selected_[1],
                    class3: selected_[2],
                },
                dataType: "json",
                success: function(data) {
                    // $('#result').html(data.msg);
                    // console.log(data.msg);
                    $("#data").append(data.msg);
                    // document.getElementById('#result').innerHTML = data;
                    // $('#result').innerHTML = data
                }
            });
        }
        //filter dropdown list
        function myFunctiondrop() {
            if (document.getElementById("demodrop").style.display == "none") {
                document.getElementById("demodrop").style.display = "flex";
            } else {
                document.getElementById("demodrop").style.display = "none";
            }
        }
    </script>
    @endsection