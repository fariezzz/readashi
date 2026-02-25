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
          <label for="member_id" class="form-label">Member</label>
          <select class="form-select searchable-select @error('member_id') is-invalid @enderror" name="member_id" id="member_id">
            <option value="">Select Member</option>
            @foreach($members as $member)
              @if(old('member_id', $borrowing->member_id) == $member->id)
                <option value="{{ $member->id }}" selected>{{ $member->name }}</option>
              @else
                <option value="{{ $member->id }}">{{ $member->name }}</option>
              @endif
            @endforeach
          </select>
          @error('member_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-6">
          <label for="manga_id" class="form-label">Manga</label>
          <select class="form-select searchable-select @error('manga_id') is-invalid @enderror" name="manga_id" id="manga_id">
            <option value="">Select Manga</option>
            @foreach($mangas as $manga)
              @if(old('manga_id', $borrowing->manga_id) == $manga->id)
                <option value="{{ $manga->id }}" selected>{{ $manga->name }}</option>
              @else
                <option value="{{ $manga->id }}">{{ $manga->name }}</option>
              @endif
            @endforeach
          </select>
          @error('manga_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
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


