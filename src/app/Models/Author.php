<?php

namespace App\Models;

use App\ValueObjects\Email;
use App\ValueObjects\Name;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Author
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $patronymic
 * @property string $email
 * @property string|null $biography
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read int|null $books_count
 * @method static \Database\Factories\AuthorFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Author newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Author newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Author query()
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereBiography($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author wherePatronymic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property Name $name
 */
class Author extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'patronymic', 'email', 'biography'];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'author_book');
    }


    public function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes): Name => new Name(
                first_name: $attributes['first_name'],
                last_name: $attributes['last_name'],
                patronymic: $attributes['patronymic'],
            ),
            set: fn (Name $value): array => [
                'first_name' => $value->first_name,
                'last_name' => $value->last_name,
                'patronymic' => $value->patronymic,
            ],
        );
    }

    public function email(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes): Email => new Email(
                value: $attributes['email'],
            ),
            set: fn (Email $value): array => [
                'email' => $value->value,
            ],
        );
    }
}
