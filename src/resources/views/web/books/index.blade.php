@extends('web.layout.one-layout')


@section('content')
<div class="flex items-center justify-between gap-2">
    <h1 class="text-2xl">Book Lists</h1>
    <a href="{{ route('books.create') }}" class="rounded-md px-4 py-2 font-semibold text-sm bg-orange-500 hover:bg-orange-600 text-white shadow-sm transition-colors">Create</a>
</div>
<div class="mt-10">
    <form action="{{ route('books.index') }}" class="flex gap-5 items-center" method="GET">
        <div class="mr-1">
          <input type="number" placeholder="Search by price" name="search_price" id="search_price" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-md">
        </div>
        <button type="submit" class="rounded-md px-4 py-2 font-semibold text-sm bg-green-500 hover:bg-green-600 text-white shadow-sm transition-colors">Search</button>
    </form>
</div>
<table class="mt-5 min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
      <tr>
        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ISBN</th>
        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Page</th>
        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
        <th scope="col" class="relative px-6 py-3">
          <span class="sr-only">Edit</span>
        </th>
        <th scope="col" class="relative px-6 py-3">
            <span class="sr-only">Remove</span>
          </th>
      </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @forelse  ($booksCollection as $bookItem)
         <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$bookItem->isbn}}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$bookItem->title}}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$bookItem->price->format()}}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$bookItem->page}}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$bookItem->year}}</td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <a href="{{route('books.edit', ['book' => $bookItem])}}" class="text-slate-600 hover:text-slate-900">Edit</a>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <form action="{{route('books.destroy', ['book' => $bookItem])}}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-400"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                    </button>
                 </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">No books</td>
          </tr>
        @endforelse
    </tbody>
  </table>


    <div class="mt-5">
        {{ $booksCollection->links() }}
    </div>
@endsection
