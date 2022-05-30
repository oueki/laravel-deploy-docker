@extends('web.layout.one-layout')

@section('content')
    <h1 class="text-2xl">Book Edit</h1>

    <form method="POST" action="{{route('books.update', ['book' => $book])}}" class="mt-10 space-y-5">
        @method('PUT')
        @csrf

        <div>
            <label for="authors" class="block text-sm font-medium text-gray-700">Authors</label>
            <select multiple  id="authors" name="authors[]" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-slate-500 focus:border-slate-500 sm:text-sm rounded-md">
                @foreach($authorsList as $authorList)
                    <option value="{{$authorList->id}}" @selected(in_array($authorList->id, $bookAuthors->pluck('id')->toArray()  ))>
                        {{$authorList->name->getFull()}}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="isbn" class="block text-sm font-medium text-gray-700">ISBN</label>
            <div class="mt-1">
              <input type="text" name="isbn" id="isbn" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ $book->isbn }}">
            </div>
          </div>
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <div class="mt-1">
              <input type="text" name="title" id="title" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ $book->title }}">
            </div>
        </div>
        <div>
            <label for="excerpt" class="block text-sm font-medium text-gray-700">Excerpt</label>
            <div class="mt-1">
              <textarea rows="4" name="excerpt" id="excerpt" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $book->excerpt }}</textarea>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-3">
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <div class="mt-1">
                  <input type="number" name="price" id="price" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ $book->price->amount }}">
                </div>
            </div>
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                <div class="mt-1">
                    <input type="number" name="year" id="year" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ $book->year }}">
                </div>
            </div>
            <div>
                <label for="page" class="block text-sm font-medium text-gray-700">Page</label>
                <div class="mt-1">
                  <input type="number" name="page" id="page" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ $book->page }}">
                </div>
            </div>
        </div>

        <button type="submit" class="w-full rounded-md px-4 py-3 font-semibold text-sm bg-green-500 hover:bg-green-600 text-white shadow-sm transition-colors">Update</button>

    </form>

    @if($book->image)
        <div class="mt-5">
            <img src="{{asset('storage/' . $book->image)}}" alt="">
        </div>
    @endif

@endsection
