@extends('backend.app')

@section('main-content')
<?php setTitle('User List') ?>
<div class="col-12">
    <?php

echo '<pre>';
    print_r($users);
echo '</pre>';
    ?>
</div>
@endsection
