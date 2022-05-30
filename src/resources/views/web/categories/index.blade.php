@extends('web.layout.layout')


@section('content-left')
    <h1 class="text-2xl">Categories</h1>

    <form method="POST" action="{{ route('categories.store') }}" class="mt-10 space-y-5">
        @csrf
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <div class="mt-1">
              <input type="text" name="name" id="name" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ old('name') }}">
            </div>
          </div>
        <button type="submit" class="w-full rounded-md px-4 py-3 font-semibold text-sm bg-sky-500 hover:bg-sky-600 text-white shadow-sm transition-colors">Create</button>

    </form>
@endsection


@section('content-right')
<h2 class="text-2xl">Category Lists</h2>

<div class="my-5 text-right">
    <a href="{{ route('categories.index') }}" class="m-2 text-sm text-green-500">Normal View</a>
    <a href="{{ route('categories.index', ['trashed' => true]) }}" class="m-2 text-sm text-red-500">With Trashed</a>
</div>

<table class=" min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
      <tr>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posts Count</th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Default?</th>
          <th scope="col" class="relative px-6 py-3">
          <span class="sr-only">Edit</span>
        </th>
        <th scope="col" class="relative px-6 py-3">
            <span class="sr-only">Remove</span>
        </th>
      </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @forelse  ($categoriesCollection as $categoryItem)
         <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$categoryItem->name}}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$categoryItem->posts_count}}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$categoryItem->default ? 'Yes' : 'No'}}</td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <a href="{{route('categories.edit', ['category' => $categoryItem])}}" class="text-slate-600 hover:text-slate-900">Edit</a>
            </td>
             @if($categoryItem->trashed())
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <form action="{{route('categories.restore', ['category' => $categoryItem])}}" method="POST">
                        @csrf
                        <button type="submit" class="text-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                     </form>
                </td>
             @else
                 <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                     <form action="{{route('categories.destroy', ['category' => $categoryItem])}}" method="POST">
                         @method('DELETE')
                         @csrf
                         <button type="submit">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-400"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                         </button>
                     </form>
                 </td>
             @endif
          </tr>
          @empty
          <tr>
            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">No categories</td>
          </tr>
        @endforelse
    </tbody>
  </table>


    {{ $categoriesCollection->links() }}
@endsection
