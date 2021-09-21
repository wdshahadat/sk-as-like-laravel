@extends('layouts.main')

@section('main-content')
<main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="<?php base_url('user/create', 1) ?>" method="POST" class="inline-form">
                    <div class="form-group">
                        <div class="inputField-cont">
                            <label for="name" class="col-md-4">Full Name :</label>
                            <input type="text" name="fullName" placeholder="Full name" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="inputField-cont">
                            <label for="name" class="col-md-4">Username :</label>
                            <input type="text" name="username" placeholder="User name" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="inputField-cont">
                            <label for="email" class="col-md-4">Email :</label>
                            <input type="email" name="email" placeholder="Enter email" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="inputField-cont">
                            <label for="mobile" class="col-md-4">Mobile :</label>
                            <input type="text" name="mobile" placeholder="Enter mobile no" class="form-control">
                        </div>
                    </div>
                    <div class="modal-bottom">
                        <button type="submit" id="addData" class="btn btn-primary">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
<script>
    // const addData = document.getElementById('addData');

    // function getData(response) {
    //     console.log(response);
    // }

    // addData.addEventListener('click', function(e) {
    //     e.preventDefault();

    //     const form = document.querySelectorAll('form input');

    //     const userInfo = {};
    //     for(let input of form) {
    //         userInfo[input.name] = input.value;
    //     }
    //     MyRq.post(`${baseurl}postc`, userInfo, function(res) {
    //         console.log(res);
    //     })
    // })
</script>
