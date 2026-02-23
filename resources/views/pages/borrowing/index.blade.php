@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid mb-5">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
      <h3>Borrowing List</h3>
  </div>

  @include('partials.alert')

  @include('partials.alertError')

  @can('admin')
  <a href="/borrowing/create" class="btn btn-primary mb-4">
    <i class="bi bi-plus-circle"></i> Add Borrowing
  </a>
  @endcan

  @if($borrowings->count())
  <table class="table table-bordered align-middle" id="borrowing-table" style="border-color:rgb(194, 194, 194);">
    <thead>
      <tr>
        <th scope="col" class="table-primary align-middle">#</th>
        <th scope="col" class="table-primary align-middle">Customer</th>
        <th scope="col" class="table-primary align-middle">Product</th>
        <th scope="col" class="table-primary align-middle">Borrowing Date</th>
        <th scope="col" class="table-primary align-middle">Due Date</th>
        <th scope="col" class="table-primary align-middle">Return Date</th>
        <th scope="col" class="table-primary align-middle">Fine</th>
        <th scope="col" class="table-primary align-middle">Status</th>
        @can('admin')
        <th scope="col" class="table-primary align-middle text-center">Actions</th>
        @endcan
      </tr>
    </thead>
    <tbody>
      @foreach($borrowings as $borrowing)
      <tr>
        <td class="text-center">{{ $loop->iteration }}</td>
        <td>{{ $borrowing->customer->name ?? '-' }}</td>
        <td>{{ $borrowing->product->name ?? '-' }}</td>
        <td>{{ $borrowing->borrow_date ?? '-' }}</td>
        <td>{{ $borrowing->due_date ?? '-' }}</td>
        <td>{{ $borrowing->return_date ?? '-' }}</td>
        <td>Rp {{ number_format($borrowing->fine ?? 0, 0, ',', '.') }}</td>
        <td class="text-capitalize">{{ $borrowing->status ?? '-' }}</td>
        @can('admin')
        <td>
          <div class="d-flex justify-content-center">
            <a href="/borrowing/{{ $borrowing->id }}/edit" class="btn btn-warning">
              <i class="bi bi-pencil-square"></i>
            </a>

            <form action="/borrowing/{{ $borrowing->id }}" method="POST" class="ms-2">
              @method('delete')
              @csrf
              <button class="btn btn-danger deleteButton"><i class="bi bi-trash3"></i></button>
            </form>
          </div>
        </td>
        @endcan
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
  <h3 class="text-center">No data.</h3>
  @endif
</div>

<script>
  $(document).ready(function () {
    @can('admin')
    $('#borrowing-table').DataTable({
      "columnDefs": [
        { "orderable": false, "targets": 8 }
      ]
    });
    @else
    $('#borrowing-table').DataTable();
    @endcan
  });
</script>

@endsection
