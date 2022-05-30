@extends('web.layout.layout')

@push('css')
<style>
    .ck-editor__editable_inline {
        min-height: 200px;
    }
    </style>
@endpush

@section('content-left')
    <h1 class="text-2xl">Post Edit</h1>

    <form method="POST" action="{{route('posts.update', ['post' => $post])}}" class="mt-10 space-y-5">
        @method('PUT')


        <div>
            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
            <select id="category" name="category" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-slate-500 focus:border-slate-500 sm:text-sm rounded-md">
                @foreach($categories as $index => $categoryName)
                    <option value="{{$index}}" @selected($post->category->id == $index)>
                    {{$categoryName}}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <div class="mt-1">
              <input type="text" name="title" id="title" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ $post->title }}">
            </div>
          </div>
        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
            <div class="mt-1">
              <input type="text" name="slug" id="slug" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ $post->slug }}">
            </div>
        </div>
        <div>
            <label for="excerpt" class="block text-sm font-medium text-gray-700">Excerpt</label>
            <div class="mt-1">
              <textarea rows="4" name="excerpt" id="excerpt" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $post->excerpt }}</textarea>
            </div>
        </div>
        <div>
            <label for="editor" class="block text-sm font-medium text-gray-700">Content</label>
            <div class="mt-1">
              <textarea rows="4" name="content" id="editor" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $post->content }}</textarea>
            </div>
        </div>
        <button type="submit" class="w-full rounded-md px-4 py-3 font-semibold text-sm bg-sky-500 hover:bg-sky-600 text-white shadow-sm transition-colors">Update</button>

    </form>
@endsection


@section('content-right')
<h2 class="text-2xl">Post Lists</h2>
<table class="mt-10 min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
      <tr>
        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>


          <th scope="col" class="relative px-6 py-3">
          <span class="sr-only">Edit</span>
        </th>
        <th scope="col" class="relative px-6 py-3">
            <span class="sr-only">Remove</span>
          </th>
      </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @forelse  ($postsCollection as $postItem)
        <tr class="{{ (request()->fullUrlIs(route('posts.edit', ['post' => $postItem]))) ? 'bg-green-100' : '' }}">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$postItem->title}}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$postItem->slug}}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$postItem->category->name}}</td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <a href="{{route('posts.edit', ['post' => $postItem])}}" class="text-slate-600 hover:text-slate-900">Edit</a>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <form action="{{route('posts.destroy', ['post' => $postItem])}}" method="POST">
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
            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">No posts</td>
          </tr>
        @endforelse
    </tbody>
  </table>


    {{ $postsCollection->links() }}



@endsection

@push('scripts')
<script src="/ckeditor.js"></script>
<script>
    ClassicEditor.create( document.querySelector( '#editor' ) )
</script>
@endpush
