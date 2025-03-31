<div class="form-wrapper">
    <form action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="centered-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" required>
            @error('title')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description">{{ old('description', $project->description) }}</textarea>
            @error('description')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="image">Project Image</label>
            <input type="file" name="image" id="image">
            @if($project->image)
                <div class="current-image">
                    <p>Current Image:</p>
                    <img src="{{ asset('storage/' . $project->image) }}" alt="Current project image">
                </div>
            @endif
            @error('image')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="url">Project URL</label>
            <input type="url" name="url" id="url" value="{{ old('url', $project->url) }}">
            @error('url')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="priority">Priority</label>
            <select name="priority" id="priority">
                <option value="1" {{ $project->priority == 1 ? 'selected' : '' }}>High</option>
                <option value="2" {{ $project->priority == 2 ? 'selected' : '' }}>Medium</option>
                <option value="3" {{ $project->priority == 3 ? 'selected' : '' }}>Low</option>
            </select>
            @error('priority')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-update">Update Project</button>
            <a href="{{ url()->previous() }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>

<style>
    body {
        background-color: rgb(151, 235, 138);
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .form-wrapper {
        width: 100%;
        max-width: 800px;
        padding: 2rem;
    }
    
    .centered-form {
        background-color: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    /* Your existing styles */
    .form-group {
        margin-bottom: 1rem;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }
    
    input, textarea, select {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    .error {
        color: #e3342f;
        font-size: 0.875rem;
    }
    
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }
    
    .btn-update, .btn-cancel {
        padding: 0.5rem 1rem;
        border-radius: 4px;
        cursor: pointer;
        border: none;
    }
    
    .btn-update {
        background-color: rgb(52, 220, 63);
        color: white;
    }
    
    .btn-cancel {
        background-color: #6c757d;
        color: white;
        text-decoration: none;
        text-align: center;
    }
    
    .current-image img {
        max-width: 200px;
        margin-top: 0.5rem;
        display: block;
    }
</style>