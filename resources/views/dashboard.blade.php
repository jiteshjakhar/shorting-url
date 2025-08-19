<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-dark">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-4 container text-dark">
        @if(auth()->user()->role !== 'Member')
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fs-5 fw-bold mb-0 text-white">Clients</h3>
                <a href="{{ route('invite.admin.create') }}" class="btn btn-primary">
                    Invite
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Company</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                        <tr>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->email }}</td>
                            <td>{{ $client->company->name ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
        <div class="mb-4">
            @if(auth()->user()->role !== 'SuperAdmin')
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fs-5 fw-bold mb-0 text-white">Short URLs</h3>
                <a href="{{ route('short-urls.create') }}" class="btn btn-primary">
                    Generate
                </a>
            </div>
            @endif
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Original URL</th>
                        <th>Short Code</th>
                        <th>Created at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shortUrls as $url)
                        <tr>
                            <td>{{ $url->original_url }}</td>
                            <td><a href="{{ $url->original_url }}" target="_blank">{{ $url->short_code }}</a></td>
                            <td>{{ $url->created_at ? $url->created_at->format('d-m-Y') : 'Unknown' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
