@extends('web.layout.layout')



@section('content-left')
    <h1 class="text-2xl">Category Edit</h1>

    <form method="POST" action="{{route('categories.update', ['category' => $category])}}" class="mt-10 space-y-5">
        @method('PUT')
        @csrf
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <div class="mt-1">
              <input type="text" name="name" id="name" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ $category->name }}">
            </div>
          </div>
        <button type="submit" class="w-full rounded-md px-4 py-3 font-semibold text-sm bg-sky-500 hover:bg-sky-600 text-white shadow-sm transition-colors">Update</button>
    </form>
    @unless($category->default)
        <div class="mt-5">
            <form method="POST" action="{{route('categories.make.default', ['category' => $category])}}" class="mt-10 space-y-5">
                @csrf
                <button type="submit" class="w-full rounded-md px-4 py-3 font-semibold text-sm bg-green-500 hover:bg-green-600 text-white shadow-sm transition-colors">Make Default</button>
            </form>
        </div>
    @else
        <div class="mt-5 text-xl text-right text-green-500">This category is default</div>
    @endunless


@endsection


@section('content-right')
<h2 class="text-2xl">Category Lists</h2>
<table class="mt-10 min-w-full divide-y divide-gray-200">
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
        <tr class="{{ (request()->fullUrlIs(route('categories.edit', ['category' => $categoryItem]))) ? 'bg-green-100' : '' }}">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$categoryItem->name}}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$categoryItem->posts_count}}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$categoryItem->default ? 'Yes' : 'No'}}</td>

            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <a href="{{route('categories.edit', ['category' => $categoryItem])}}" class="text-slate-600 hover:text-slate-900">Edit</a>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <form action="{{route('categories.destroy', ['category' => $categoryItem])}}" method="POST">
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
            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">No categories</td>
          </tr>
        @endforelse
    </tbody>
  </table>

    {{ $categoriesCollection->links() }}
@endsection

