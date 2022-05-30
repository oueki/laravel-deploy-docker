<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Application</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="/app.css">
        @stack('css')

    </head>
<body class="h-full overflow-hidden">


    <div class="h-full flex ">

        @include('web.layout.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('web.layout.partials.flash')
          <div class="flex-1 flex items-stretch overflow-hidden">
            <main class="flex-1 overflow-y-auto">
              <section class="min-w-0 flex-1 h-full flex flex-col lg:order-last">
                  <div class="px-8 py-5 overflow-x-hidden">
                    @yield('content-left')
                  </div>
              </section>
            </main>

            <aside class="hidden w-3/5 bg-white border-l border-gray-200 overflow-y-auto lg:block">
                <div class="px-8 py-5">
                    @yield('content-right')
                </div>
            </aside>
          </div>
        </div>
      </div>

    <script src="/app.js"></script>
    @stack('scripts')
</body>
</html>
