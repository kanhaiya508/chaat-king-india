<x-layouts.app title="  Branches Management ">
    <div class="container py-4">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <h4>Send Web Push</h4>
        <form method="POST" action="{{ route('push.send') }}" class="mt-3">
            @csrf
            <div class="mb-2">
                <label class="form-label">Title</label>
                <input name="title" class="form-control" required value="{{ old('title', 'Offer Alert 🎉') }}">
            </div>
            <div class="mb-2">
                <label class="form-label">Body</label>
                <input name="body" class="form-control" required value="{{ old('body', 'Aaj dinner par 20% OFF!') }}">
            </div>
            <div class="mb-2">
                <label class="form-label">Click URL (optional)</label>
                <input name="click" class="form-control" value="{{ old('click', url('/offers-today')) }}">
            </div>
            <div class="mb-2">
                <label class="form-label">Icon URL (optional)</label>
                <input name="icon" class="form-control" value="{{ old('icon', url('https://snow-loris-794529.hostingersite.com/panel/assets/img/favicon/favicon.ico')) }}">
            </div>
            <div class="mb-2">
                <label class="form-label">Image URL (optional)</label>
                <input name="image" class="form-control" value="https://b.zmtcdn.com/data/pictures/3/19545403/d7b2e3b46d19766dd150d740f06a5c52_featured_v2.jpg">
            </div>
            <div class="mb-3">
                <label class="form-label">Customer ID (optional: send to single)</label>
                <input name="customer_id" class="form-control" value="{{ old('customer_id') }}"
                    placeholder="leave blank to send to ALL">
            </div>
            <button class="btn btn-primary">Send Notification</button>
        </form>
    </div>
</x-layouts.app>
