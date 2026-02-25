@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom">
      <h3>Edit Item</h3>
    </div>

    @if(session()->has('error'))
      <div class="alert alert-danger alert-dismissible fade show col" role="alert">
      {!! session('error') !!}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    
    <div class="col">
      <a href="/manga" class="btn btn-primary mb-3"><i class="bi bi-arrow-left"></i> Back</a>
      <form class="row g-3" method="POST" action="/manga/{{ $manga->code }}" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="col-lg-6">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $manga->name) }}" required autofocus>
          @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-6">
          <label for="author" class="form-label">Author</label>
          <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author" value="{{ old('author', $manga->author) }}" required>
          @error('author')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12">
          <label for="synopsis" class="form-label">Synopsis</label>
          <textarea class="form-control @error('synopsis') is-invalid @enderror" id="synopsis" name="synopsis">{{ old('synopsis', $manga->synopsis) }}</textarea>
          @error('synopsis')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-6">
          <label for="stock" class="form-label">Available Copies</label>
          <input type="number" min="0" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $manga->stock) }}" required>
          @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-6">
          <label for="genre_id" class="form-label">Genre</label>
            <select class="form-select" name="genre_id" id="genre_id">
              @foreach($genres as $genre)
                @if(old('genre_id', $manga->genre_id) == $genre->id)
                  <option value="{{ $genre->id }}" selected>{{ $genre->name }}</option>
                @else
                  <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                @endif
              @endforeach
            </select>
        </div>

        <div class="col-lg-6">
          <label for="publisher" class="form-label">Publisher</label>
          <input type="text" class="form-control @error('publisher') is-invalid @enderror" id="publisher" name="publisher" value="{{ old('publisher', $manga->publisher) }}">
          @error('publisher')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-6">
          <label for="published_year" class="form-label">Published Year</label>
          <input type="number" min="1900" max="{{ date('Y') }}" class="form-control @error('published_year') is-invalid @enderror" id="published_year" name="published_year" value="{{ old('published_year', $manga->published_year) }}">
          @error('published_year')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-lg-6">
          <label for="image" class="form-label">Image</label>
          <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" accept="image/*" onchange="previewImage(this)">
          <div class="form-text">Kosongkan jika tidak ingin mengganti gambar. Maksimal 1MB.</div>
          <small class="text-muted d-block mt-1 file-info">Belum ada file dipilih.</small>
          @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-lg-12">
          @php
            $currentImage = $manga->image ? asset('storage/' . $manga->image) : '';
          @endphp
          <img src="{{ $currentImage }}" class="img-preview img-fluid rounded border p-1 mt-1" style="max-height: 320px; {{ $currentImage ? '' : 'display:none;' }}" data-initial-src="{{ $currentImage }}">
        </div>

        <div class="col-12 mb-5">
          <button type="submit" class="btn btn-primary">Edit</button>
        </div>

      </form>

    </div>
</div>

@endsection


