@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom">
      <h3>Edit Borrowing</h3>
    </div>

    @include('partials.alertError')

    <div class="col-lg-12 container-fluid">
      <a href="/borrowing" class="btn btn-primary mb-3"><i class="bi bi-arrow-left"></i> Back</a>
      <form class="row g-3 myForm" method="POST" action="/borrowing/{{ $borrowing->id }}">
        @method('put')
        @csrf
        <div class="col-lg-6">
          <label for="customer_id" class="form-label">Customer</label>
          <select class="form-select searchable-select @error('customer_id') is-invalid @enderror" name="customer_id" id="customer_id">
            <option value="">Select customer</option>
            @foreach($customers as $customer)
              @if(old('customer_id', $borrowing->customer_id) == $customer->id)
                <option value="{{ $customer->id }}" selected>{{ $customer->name }}</option>
              @else
                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
              @endif
            @endforeach
          </select>
          @error('customer_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-6">
          <label for="product_id" class="form-label">Product</label>
          <select class="form-select searchable-select @error('product_id') is-invalid @enderror" name="product_id" id="product_id">
            <option value="">Select product</option>
            @foreach($products as $product)
              @if(old('product_id', $borrowing->product_id) == $product->id)
                <option value="{{ $product->id }}" selected>{{ $product->name }}</option>
              @else
                <option value="{{ $product->id }}">{{ $product->name }}</option>
              @endif
            @endforeach
          </select>
          @error('product_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-4">
          <label for="borrow_date" class="form-label">Borrow Date</label>
          <input type="date" class="form-control @error('borrow_date') is-invalid @enderror" name="borrow_date" id="borrow_date" value="{{ old('borrow_date', $borrowing->borrow_date) }}">
          @error('borrow_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-4">
          <label for="due_date" class="form-label">Due Date</label>
          <input type="date" class="form-control @error('due_date') is-invalid @enderror" name="due_date" id="due_date" value="{{ old('due_date', $borrowing->due_date) }}">
          @error('due_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-4">
          <label for="return_date" class="form-label">Return Date</label>
          <input type="date" class="form-control @error('return_date') is-invalid @enderror" name="return_date" id="return_date" value="{{ old('return_date', $borrowing->return_date) }}">
          @error('return_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-6">
          <label for="fine" class="form-label">Fine</label>
          <input type="number" min="0" class="form-control @error('fine') is-invalid @enderror" name="fine" id="fine" value="{{ old('fine', $borrowing->fine) }}">
          @error('fine')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-6">
          <label for="status" class="form-label">Status</label>
          <select class="form-select @error('status') is-invalid @enderror" name="status" id="status">
            <option value="borrowed" {{ old('status', $borrowing->status) === 'borrowed' ? 'selected' : '' }}>Borrowed</option>
            <option value="returned" {{ old('status', $borrowing->status) === 'returned' ? 'selected' : '' }}>Returned</option>
            <option value="late" {{ old('status', $borrowing->status) === 'late' ? 'selected' : '' }}>Late</option>
          </select>
          @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12 mb-3">
          <button type="submit" class="btn btn-primary submitButton">Edit</button>
        </div>
      </form>
    </div>
</div>

<script>
  $(document).ready(function () {
    $('.searchable-select').select2({
      width: '100%',
      placeholder: 'Select an option',
      allowClear: true
    });
  });
</script>

@endsection
