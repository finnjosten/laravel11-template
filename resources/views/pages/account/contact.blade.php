@extends('layouts.app')

@section('show-nav', 'false')

<!-- Page head -->
@section('head')

<title>Contact || {{ env('APP_NAME') }}</title>

<link rel="stylesheet" href="/css/datatables.css?v=1.13.7" />
<script src="/js/datatables.js?v=1.13.7"></script>

@endsection

<!-- Page content -->
@section('content')

    <main class="page page--account">
        @include('components.account.sidebar', ['page' => 'contact'])
        <div class="content">
            <table id="projectsTable" class="display" data-page-length='20'>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (App\Models\Contact::all() as $contact)
                        <tr>
                            <td>{{ $contact->id }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->subject }}</td>
                            <td>{{ $contact->content }}</td>
                            <td class="actions"><a href="{{ route('contact.view', $contact->id) }}" class="btn btn--link"><i class="da-icon da-icon--arrow-up-right-from-square da-icon--small"></i> View</a><a href="{{ route('contact.trash', $contact->id) }}" class="btn btn--link"><i class="da-icon da-icon--trashcan da-icon--small"></i> Delete</a></td>
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
