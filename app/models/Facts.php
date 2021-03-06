<?php
namespace App\Models;

use App\Libs;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Facts extends \Eloquent {
    use SoftDeletingTrait;

    protected $table = 'facts';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function activities()
    {
        return $this->belongsTo('App\Models\Activities', 'id_activities');
    }

    public function users()
    {
        return $this->belongsTo('App\Models\Users', 'id_users');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tags', 'facts_tags', 'id_facts', 'id_tags');
    }

    private function formatDate($date)
    {
        try {
            return new \DateTime($date);
        } catch (\Exception $e) {
            return new \DateTime('0000-00-00 00:00:00');
        }
    }

    public function getStartTimeAttribute($value)
    {
        return $this->formatDate($value);
    }

    public function getEndTimeAttribute($value)
    {
        return $this->formatDate($value);
    }


    public static function filter($facts, $filters)
    {
        extract($filters);

        $I = \Auth::user();

        if ($user) {
            $facts->where('id_users', '=', $user);
        }

        if ($activity) {
            $facts->where('id_activities', '=', $activity);
        }

        if ($tag) {
            $facts->whereHas('tags', function ($query) use ($tag) {
                $query->where('tags.id', '=', $tag);
            });
        }

        if ($first) {
            $facts->where('start_time', '>=', $first->format('Y-m-d 00:00:00'));
        }

        if ($last) {
            $facts->where('end_time', '<=', $last->format('Y-m-d 23:59:59'));
        }

        if ($description) {
            $facts->where('description', 'LIKE', '%'.$description.'%');
        }

        list($sort_field, $sort_mode) = explode('-', $sort);

        $facts->orderBy($sort_field.'_time', $sort_mode);

        return $facts;
    }
}