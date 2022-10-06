@extends('layout.app')

@section('title','Edit User')

@section('content')
<div class="row gy-3">
    <div class="col">
        <div class="card shadow-sm p-4">
            <form action="{{ route('processEditUser') }}" method="POST">
                @csrf

                <h1 class="mb-3 text-center">Edit User</h1>

                <input type="hidden" id="id" name="id" value="{{ $user->id }}">

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Email" id="email" name="email" value="{{ $user->email}}" required>
                    <label for="floatingInput">Email</label>
                </div>    

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Name" id="name" name="name" value="{{ $user->name }}"  required>
                    <label for="floatingInput">Name</label>
                </div>    

                <button class="w-100 btn btn-lg btn-primary" type="submit">Submit</button>
            </form>    
        </div>    
    </div>    
</div>    
@endsection