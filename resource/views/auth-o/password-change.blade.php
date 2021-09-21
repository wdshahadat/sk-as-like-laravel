@extends('layouts.main')
@section('main-content')
<main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 p-0 mt-5 shadow bg-white rounded">
                <h4 class="pl-4 mt-4">Update user password</h4>
                <hr>
                <?php errorAlertMessage() ?>
                <form action="<?php route('/user/password/update/', $_SESSION['userInfo']->id) ?>" method="POST" class="inline-form pl-5 pr-5 pb-5 pt-3">
                    <?php csrf() ?>
                    <div class="form-group text-left">
                        <div class="inputField-cont">
                            <label for="current" class="col-md-6">Current Password:</label>
                            <input type="password" name="current" placeholder="Current password" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="inputField-cont">
                            <label for="password" class="col-md-6">New Password :</label>
                            <input type="password" name="password" placeholder="New password" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="inputField-cont">
                            <label for="repeat" class="col-md-6">Re-type Password :</label>
                            <input type="password" name="repeat" placeholder="Retype password" class="form-control">
                        </div>
                    </div>
                    <div class="modal-bottom">
                        <button type="submit" id="addData" class="btn btn-warning">Change</button>
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
