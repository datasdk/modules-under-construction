@extends('layouts.app')


@section('content')

    <form method="POST" action="{{ route('settings.under_construction.store') }}">
        @csrf

        <div class="card mb-4">
            <div class="card-header">Under ombygning</div>
            <div class="card-body">
                <div class="form-check mb-2">
                    <input type="radio" name="under_construction" value="0" class="form-check-input" 
                           id="public" {{ old('under_construction', $uc->under_construction) == 0 ? 'checked' : '' }}>
                    <label for="public" class="form-check-label">Offentligt tilgængelig</label>
                </div>
                <small class="text-muted">Appen er offentlig tilgængelig for brugere og administratorer</small>

                <div class="form-check mt-3 mb-2">
                    <input type="radio" name="under_construction" value="1" class="form-check-input" 
                           id="maintenance" {{ old('under_construction', $uc->under_construction) == 1 ? 'checked' : '' }}>
                    <label for="maintenance" class="form-check-label">Under ombygning</label>
                </div>
                <small class="text-muted">Appen lukkes ned og adgang nægtes for brugere og administratorer. Der bliver vist en besked i appen.</small>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Adgang</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="access_key" class="form-label">Adgangskode</label>
                    <input type="text" name="access_key" id="access_key" class="form-control" 
                           value="{{ old('access_key', $uc->access_key) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Link</label>
                    <input type="text" readonly class="form-control" 
                           value="{{ url($uc->access_key) }}" onfocus="this.select()">
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Besked</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" 
                           value="{{ old('title', $uc->title) }}">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Besked</label>
                    <textarea name="description" id="description" rows="5" class="form-control">{{ old('description', $uc->description) }}</textarea>
                </div>
            </div>
        </div>


        <button type="submit" class="btn btn-primary">Opdater indstillinger</button>

    </form>

@endsection
