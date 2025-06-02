@extends('layouts.app')

@section('title', 'Add New Device - Smart Rental Hub')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Add New Device</h5>
                        <a href="{{ route('admin.devices.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Back to Devices
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.devices.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Device Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="daily_rate" class="form-label">Daily Rate ($)</label>
                                    <input type="number" step="0.01" class="form-control @error('daily_rate') is-invalid @enderror" 
                                           id="daily_rate" name="daily_rate" value="{{ old('daily_rate') }}" required>
                                    @error('daily_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="condition" class="form-label">Condition</label>
                                    <select class="form-select @error('condition') is-invalid @enderror" 
                                            id="condition" name="condition" required>
                                        <option value="">Select condition</option>
                                        @foreach(['new', 'good', 'fair', 'poor'] as $condition)
                                            <option value="{{ $condition }}" 
                                                {{ old('condition') == $condition ? 'selected' : '' }}>
                                                {{ ucfirst($condition) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('condition')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="availability_status" class="form-label">Availability Status</label>
                            <select class="form-select @error('availability_status') is-invalid @enderror" 
                                    id="availability_status" name="availability_status" required>
                                <option value="">Select status</option>
                                @foreach(['available', 'maintenance'] as $status)
                                    <option value="{{ $status }}" 
                                        {{ old('availability_status') == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('availability_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="specifications" class="form-label">Specifications</label>
                            <textarea class="form-control @error('specifications') is-invalid @enderror" 
                                      id="specifications" name="specifications" rows="3">{{ old('specifications') }}</textarea>
                            @error('specifications')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">Device Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            <div class="form-text">Upload a clear image of the device (max 2MB)</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Add Device
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview image before upload
    document.getElementById('image').addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const img = document.createElement('img');
            img.src = event.target.result;
            img.classList.add('img-thumbnail', 'mt-2');
            img.style.maxHeight = '200px';
            
            const previewContainer = document.getElementById('image').parentElement;
            const oldPreview = previewContainer.querySelector('img');
            if (oldPreview) {
                oldPreview.remove();
            }
            previewContainer.appendChild(img);
        }
        reader.readAsDataURL(e.target.files[0]);
    });
</script>
@endpush 