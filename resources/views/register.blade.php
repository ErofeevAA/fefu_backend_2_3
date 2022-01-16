@extends('main')

@section('content')
    <h2>Registration</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <label>Name</label>
            <label>
                <input class="bordered" name="name" type="text" value="{{ old('name') }}" size="20"/>
            </label>
        </div>
        <div>
            <label>Email</label>
            <label>
                <input class="bordered" name="email" type="text"
                       value="{{ old('email') }}" size="20"/>
            </label>
        </div>
        <div>
            <label>Login</label>
            <input class="border-t" name="login" type="text" value="{{ old('login') }}"/>
        </div>
        <div>
            <label>Password</label>
            <input class="border-t" name="password" type="password" />
        </div>
        <input type="submit"/>
    </form>
@endsection
