@extends('layout')

@section('title', 'All Categories')

@section('content')

    <div id="menu"></div>
    <div id="main-content">
        <a href="{{ route('categories.create') }}" class="btn btn-success btn-sm mb-3">Add New Category</a>

        <style>
            .arrow {
                text-decoration: none;
                margin-left: 5px;
            }

            .arrow:hover {
                color: blue;
            }
        </style>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Sort Order</th>
                    <th>Level</th>
                    <th>Parent Category</th>
                    <th>Category Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categoryData as $key => $cat_row)
                    @php
                        $level = $cat_row->level ?? 1;
                        $cat_parent_name = $cat_row->parentCategory->category_name ?? '-';
                        $html = str_repeat('- ', $level);

                        // Determine previous and next category keys
                        $parts = explode('_', $key);
                        $integerPart = end($parts);
                        $prevKey = implode('_', array_slice($parts, 0, -1)) . '_' . ($integerPart - 1);
                        $nextKey = implode('_', array_slice($parts, 0, -1)) . '_' . ($integerPart + 1);
                        $prevCatExists = isset($categoryData[$prevKey]);
                        $nextCatExists = isset($categoryData[$nextKey]);
                    @endphp
                    <tr>
                        <td>{{ $cat_row->cid }}</td>
                        <td>{!! $html !!}{{ $cat_row->category_name }}</td>
                        <td>
                            {{ $cat_row->sort_order }}
                            @if ($prevCatExists)
                                @php
                                    $prevCatRow = $categoryData[$prevKey];
                                @endphp
                                <a href="{{ route('categories.swapOrder', ['direction' => 'up', 'nextCatRow' => $cat_row->cid, 'prevCatRow' => $prevCatRow->cid]) }}"
                                    class="arrow" title="Move Up">↑</a>
                            @endif
                            @if ($nextCatExists)
                                @php
                                    $nextCatRow = $categoryData[$nextKey];
                                @endphp
                                <a href="{{ route('categories.swapOrder', ['direction' => 'down', 'nextCatRow' => $nextCatRow->cid, 'prevCatRow' => $cat_row->cid]) }}"
                                    class="arrow" title="Move Down">↓</a>
                            @endif
                        </td>
                        <td>{{ $level }}</td>
                        <td>{{ $cat_parent_name }}</td>
                        <td>{{ $cat_row->category_desc }}</td>
                        <td>
                            <a href="{{ route('categories.edit', $cat_row->cid) }}" class="btn btn-primary btn-sm">Edit</a>
                            <a href="{{ route('categories.destroy', $cat_row->cid) }}" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure?')">Delete</a>
                            <form id="delete-form-{{ $cat_row->id }}"
                                action="{{ route('categories.destroy', ['cid' => $cat_row->cid]) }}" method="GET"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
