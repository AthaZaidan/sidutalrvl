@extends('layouts.admin')
@section('title', 'Master Data ' . $cfg['title'])
@section('content')
<h1 class="h3 mb-3 text-gray-800">Master Data: {{ $cfg['title'] }}</h1>
<div class="card shadow p-3 mb-3">
    <form method="POST" action="{{ route('adm.data.store', $type) }}" class="form-inline">
        @csrf
        @if(isset($cfg['parent']))
            <select name="parent_id" class="form-control form-control-sm mr-2" required>
                @foreach($parentOptions as $pid => $pname)
                    <option value="{{ $pid }}">{{ $pname }}</option>
                @endforeach
            </select>
        @endif
        <input type="text" name="name" class="form-control form-control-sm mr-2" placeholder="Nama {{ $cfg['title'] }}" required>
        <button class="btn btn-primary btn-sm">Tambah</button>
    </form>
</div>

<div class="card shadow p-3">
    <form method="GET" class="form-inline mb-3">
        <input type="text" name="q" class="form-control form-control-sm mr-2" placeholder="Cari..." value="{{ request('q') }}">
        <button class="btn btn-secondary btn-sm">Cari</button>
    </form>
    <table class="table table-bordered table-sm">
        <thead><tr><th>ID</th><th>Nama</th><th>Ubah</th><th>Hapus</th></tr></thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->{$cfg['pk']} }}</td>
                    <td>{{ $item->{$cfg['name']} }}</td>
                    <td>
                        <form method="POST" action="{{ route('adm.data.update', [$type, $item->{$cfg['pk']}]) }}" class="form-inline">@csrf
                            <input type="text" name="name" class="form-control form-control-sm mr-1" value="{{ $item->{$cfg['name']} }}" required>
                            <button class="btn btn-xs btn-warning">Simpan</button>
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('adm.data.destroy', [$type, $item->{$cfg['pk']}]) }}">@csrf @method('DELETE')
                            <button class="btn btn-xs btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $items->links() }}
</div>
@endsection
