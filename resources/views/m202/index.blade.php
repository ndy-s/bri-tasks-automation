@extends('layouts.main')

@section('title', $title)

@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('m202.create') }}" type="button" class="btn btn-sm btn-outline-secondary">
                    <span data-feather="plus-circle" class="align-text-bottom"></span>
                    Tambah
                </a>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col" class="text-center">Exam Code</th>
                <th scope="col" class="text-center">Exam Name</th>
                <th scope="col" class="text-center">Exam Type</th>
                <th scope="col" class="text-center">Duration</th>
                <th scope="col" class="text-center">Start Date</th>
                <th scope="col" class="text-center">End Date</th>
                <th scope="col" class="text-center">Facilitator</th>
                <th scope="col" class="text-center">Maker</th>
                <th scope="col" class="text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($M202 as $index => $m2)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td class="text-center">{{ $m2->code }}</td>
                    <td>{{ $m2->name }}</td>
                    <td class="text-center">{{ $m2->type }}</td>
                    <td class="text-center">{{ $m2->duration }}</td>
                    <td class="text-center">{{ $m2->start_date }}</td>
                    <td class="text-center">{{ $m2->end_date }}</td>
                    <td class="text-center">{{ $m2->facilitator }}</td>
                    <td class="text-center">{{ $m2->maker }}</td>
                    <td class="d-flex text-center justify-content-center">
                        <a href="{{ route('m202.edit', $m2->id) }}" type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit">
                            <span data-feather="edit" class="align-text-bottom"></span>
                        </a>
                        <form action="{{ route('m202.destroy', $m2->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-secondary" type="submit" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
                                <span data-feather="trash" class="align-text-bottom"></span>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</main>
@endsection
