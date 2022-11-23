<table class="table table-hover">
    <thead class="text-warning">
        <th>Name</th>
        <th>Email</th>
        <th>Working_day</th>
        <th>Day_Off</th>
        <th>Salary</th>
        <th></th>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>

                <td>{{ $user->email }}</td>

                <td>{{ $user->more['working_day'] }}</td>

                <td>{{ $user->more['day_off'] }}</td>

                <td>{{ $user->more['salary'] }}</td>

                <td class="td-actions text-right">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <button type="button" rel="tooltip" title="Edit Task" value="{{ $user->id }}"
                                    class="edit_record btn btn-link btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editRecord">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('user.delete', $user) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" rel="tooltip" title="Delete Task"
                                        class="btn btn-link btn-sm">
                                        <i class="fa-solid fa-trash"></i>
                                </form>
                                </button>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $users->links('pagination.custom') }}
