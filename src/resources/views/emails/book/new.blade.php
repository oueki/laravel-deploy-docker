<div>
    Title: {{ $book->title }}
</div>
<div>
    ISBN: {{ $book->isbn }}
</div>
<div>
    Price: {{ $book->price->format() }}
</div>
