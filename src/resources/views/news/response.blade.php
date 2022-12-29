<table class="table table-hover">
    <thead class="text-warning">
    <th>Release Date</th>
    <th>Title</th>
    <th>Information</th>
    <th>Url</th>
    <th></th>
    </thead>
    <tbody>
    @foreach ($news as $record)
        <tr>
            <td>{{ $record->release_date }}</td>
            <td>{{ $record->title }}</td>
            <td>{{ Str::limit($record->information, 80,'...') }}</td>
            <td>{{ $record->url }}</td>
            <td class="td-actions text-right">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <button type="button" rel="tooltip" title="Edit Task" value="{{ $record->id }}"
                                    class="edit_record btn btn-link btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editRecord">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('news.delete', $record) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" rel="tooltip" title="Delete Task"
                                        class="btn btn-link btn-sm">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $news->links('pagination.custom') }}
