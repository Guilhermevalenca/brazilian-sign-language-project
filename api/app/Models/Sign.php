<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;


class Sign extends Model
{
    /** @use HasFactory<\Database\Factories\SignFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'display'
    ];

    static public function adjustOrderByName()
    {
        $sql = "
            SELECT s.id, s.name, s.display,
                   k.nat_key
            FROM signs s
            CROSS JOIN LATERAL (
                SELECT string_agg(
                    CASE
                        WHEN tok ~ '^\d+$'
                            THEN to_char(tok::bigint, 'FM00000000000000000000') -- 20 dígitos
                        ELSE lower(tok)
                    END,
                    '' ORDER BY ord
                ) AS nat_key
                FROM (
                    SELECT (regexp_matches(s.name, '\d+|\D+', 'g'))[1] AS tok, ordinality AS ord
                    FROM regexp_matches(s.name, '\d+|\D+', 'g') WITH ORDINALITY
                ) AS t
            ) AS k
        ";

        return DB::table(DB::raw("({$sql}) as sub"))
            ->select('sub.id', 'sub.name', 'sub.display')
            ->orderBy('sub.nat_key')
            ->orderBy('sub.name');
    }

    public function adjustOrderByNameOnly()
    {
        return self::adjustOrderByName();
    }


    public function description(): HasOne
    {
        return $this->HasOne(Description::class);
    }

    public function example(): HasOne
    {
        return $this->HasOne(Example::class);
    }

    public function keywords(): BelongsToMany
    {
        return $this->belongsToMany(Keyword::class, 'sign_keyword', 'sign_id', 'keyword_id');
    }

    public function suggestions(): BelongsToMany
    {
        return $this->belongsToMany(Suggestion::class, 'suggestion_sign', 'sign_id', 'suggestion_id');
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class);
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Favorite::class);
    }
}
