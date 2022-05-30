<?php

namespace App\Models;

use App\Dto\BookDto;
use App\Events\BookCreated;
use App\Events\BookUpdatePrice;
use App\ValueObjects\Money;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Book
 *
 * @property int $id
 * @property string $isbn
 * @property string $title
 * @property int $price
 * @property int $page
 * @property string|null $image
 * @property string $excerpt
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereIsbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book wherePage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $year
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Author[] $authors
 * @property-read int|null $authors_count
 * @method static \Database\Factories\BookFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereYear($value)
 */
class Book extends Model
{
    use HasFactory, EntityWithEvents;

     protected $fillable = ['isbn', 'title', 'price', 'page', 'excerpt', 'image', 'year'];

    protected static function boot()
    {
        parent::boot();

        self::created(function (Book $book) {
            $book->record(new BookCreated($book->id));
        });
    }

    public static function createFromService(BookDto $bookDto): Book
    {
        $book = static::create([
            'isbn' => $bookDto->isbn,
            'title' => $bookDto->title,
            'price' => $bookDto->price,
            'page' => $bookDto->page,
            'year' => $bookDto->year,
            'excerpt' => $bookDto->excerpt,
        ]);

        $book->record(new BookCreated($book->id));

        return $book;
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    public function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value): Money => new Money(
                amount: $value,
            ),
            set: fn (Money $value): array => [
                'price' => $value->amount,
            ],
        );
    }

    public function changePrice($price)
    {

        if($price < $this->price->amount){
            $this->record(new BookUpdatePrice($this->id));
        }

        $this->update(['price' => new Money($price)]);
    }
}
