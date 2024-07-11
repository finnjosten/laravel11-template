@extends('layouts.app')

@section('show-nav', 'false')

<!-- Page head -->
@section('head')

<title>Categories || {{ env('APP_NAME') }}</title>

<link rel="stylesheet" href="/css/datatables.css?v=1.13.7" />
<script src="/js/datatables.js?v=1.13.7"></script>

@endsection

<!-- Page content -->
@section('content')

    <main class="page page--account">
        @include('components.account.sidebar', ['page' => 'user'])
        <div class="content">
            <table id="projectsTable" class="display" data-page-length='20'>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (App\Models\User::all() as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->name }}</td>
                            <td class="actions"><a href="{{ route('dashboard.user.edit', $user->id) }}" class="btn btn--link"><i class="da-icon da-icon--pen-to-square da-icon--small"></i> Edit</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <script>
                let table = new DataTable('#projectsTable', {
                    "lengthMenu": [20],
                });
            </script>
        </div>
    </main>

@endsection
