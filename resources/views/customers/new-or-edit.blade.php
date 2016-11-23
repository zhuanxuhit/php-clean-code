@extends('layouts.layout')

@section('content')
    <div class="page-header clearfix">
        <h2>
            <?= !empty($customer->getId()) ? 'Edit' : 'New' ?>
            Customer
        </h2>
    </div>

    <form role="form" action="" method="post">
        <input type="hidden" name="_token" value="<?= csrf_token(); ?>">

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name"
                   value="<?= $customer->getName() ?>">
            @include('validation-errors', ['name' => 'name', 'errors' => isset($errors) ? $errors : []])
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" name="email" id="email" placeholder="Enter Email"
                   value="<?= $customer->getEmail() ?>">
            @include('validation-errors', ['name' => 'email', 'errors' => isset($errors) ? $errors : []])
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@stop