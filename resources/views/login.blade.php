@extends('main')

@section('content')
    <h2>Login</h2>

    @if ($errors !== null)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
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
