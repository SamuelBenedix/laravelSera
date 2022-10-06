@extends('layout.app')

@section('title','Add User')

@section('content')
<div class="row gy-3">
    <div class="col">
        <div class="card shadow-sm p-4">
            <form action="{{ route('processAddUser') }}" method="POST">
                @csrf

                <h1 class="mb-3 text-center">Add User</h1>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Email" id="email" name="email" required>
                    <label for="floatingInput">Email</label>
                </div>    

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Name" id="name" name="name" required>
                    <label for="floatingInput">Name</label>
                </div>    

                <button class="w-100 btn btn-lg btn-primary" type="submit">Submit</button>
            </form>    
        </div>    
    </div>    
</div>    
@endsection