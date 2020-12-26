<?php

namespace App;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CombinationUser extends Model
{

    protected $attributes = [
        'percent' => 0,
    ];

    protected $fillable = [
        'name',
        'color',
        'cells',
        'link_id',
    ];

    protected $casts = [
        'cells' => 'array',
    ];

    public function link()
    {
        return $this->belongsTo(CombinationLink::class, 'link_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getFromLinkAndUser(CombinationLink $link, User $user, $isPro = false)
    {
        return self::query()
            ->where('link_id', $link->id)
            ->when($isPro, function (Builder $query) {
                return $query->whereHas('user', function (Builder $query) {
                    return $query->where('role', Role::ADMIN);
                });
            }, function (Builder $query) use ($user) {
                return $query->where('user_id', $user->id);
            })
            ->orderBy('created_at')
            ->get();
    }

}
