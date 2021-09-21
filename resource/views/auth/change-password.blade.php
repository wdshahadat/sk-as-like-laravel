@extends('auth.container')

@section('card-body')
<?php setTitle('Login') ?>
<!-- /.card-body -->
<div class="card-body">
    <p class="login-box-msg">Change your password</p>
    <?php errorAlerts() ?>
    <form action="<?php _(route('/user/password/update/', user()->id)) ?>" method="post">
        <?php csrf() ?>
        <div class="input-group mb-3">
            <input type="password" name="current" class="form-control" placeholder="Current password" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="New Password" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-key"></span>
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <input type="password" name="retype" class="form-control" placeholder="Retype password" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-redo"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <p class="mb-1">
                    <a href="<?php _(route('forgot/password')) ?>">Forgot password</a>
                </p>
            </div>
            <!-- /.col -->
            <div class="col-4"><button type="submit" class="btn btn-warning btn-block">Change</button>
            </div>
            <!-- /.col -->
        </div>
    </form>

</div>
<!-- /.card-body -->
@endsection
