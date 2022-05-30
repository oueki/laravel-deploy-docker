<div class="hidden w-28 bg-slate-500 overflow-y-auto md:block">
    <div class="w-full py-6 flex flex-col items-center">
      <div class="flex-1 mt-2 w-full px-2 space-y-1">
        <a href="{{route('books.index')}}" class="{{ request()->routeIs('books.*') ? 'bg-slate-800 text-white' : 'text-indigo-100 hover:bg-slate-800 hover:text-white'}} group w-full p-3 rounded-md flex flex-col items-center text-xs font-medium">
          <svg xmlns="http://www.w3.org/2000/svg"  class="{{request()->routeIs('books.*') ? 'bg-slate-800 text-white' : ' text-white'}} h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
          </svg>
          <span class="mt-2">Books</span>
        </a>
          <a href="{{route('authors.index')}}" class="{{ request()->routeIs('authors.*') ? 'bg-slate-800 text-white' : 'text-indigo-100 hover:bg-slate-800 hover:text-white'}} group w-full p-3 rounded-md flex flex-col items-center text-xs font-medium">
              <svg xmlns="http://www.w3.org/2000/svg" class="{{request()->routeIs('authors.*') ? 'bg-slate-800 text-white' : ' text-white'}} h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>

              <span class="mt-2">Authors</span>
          </a>
        <div class="w-full pb-1">
            <div class="h-px bg-slate-600 my-5"></div>
        </div>
        <a href="{{route('posts.index')}}" class="{{ request()->routeIs('posts.*') ? 'bg-slate-800 text-white' : 'text-indigo-100 hover:bg-slate-800 hover:text-white'}} group w-full p-3 rounded-md flex flex-col items-center text-xs font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="{{request()->routeIs('posts.*') ? 'bg-slate-800 text-white' : ' text-white'}} h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
              </svg>
            <span class="mt-2">Posts</span>
          </a>
          <a href="{{route('categories.index')}}" class="{{ request()->routeIs('categories.*') ? 'bg-slate-800 text-white' : 'text-indigo-100 hover:bg-slate-800 hover:text-white'}} group w-full p-3 rounded-md flex flex-col items-center text-xs font-medium">
              <svg xmlns="http://www.w3.org/2000/svg" class="{{request()->routeIs('categories.*') ? 'bg-slate-800 text-white' : 'text-white'}} h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
              </svg>
              <span class="mt-2">Categories</span>
          </a>
      </div>
    </div>
  </div>


