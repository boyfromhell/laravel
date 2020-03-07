<?php

namespace App;

use App\Status;
use App\Skill;
use App\Tag;
use App\Employer;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Project extends Model
{
    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function parseApi($data)
    {
        $attributes = $this->checkFields($data['attributes']);
        $attributes['fhunt_id'] = $data['id'];
        $is_save = $this->where('fhunt_id', $data['id'])->first();

        if(empty($is_save)){
            $create = $this->create($attributes);
            $project_id = $create->id;
        } else {
            $is_save->fill($attributes);
            $is_save->save();
            $project_id = $is_save->id;
        }

        if(isset($data['attributes']['skills']) && !empty($data['attributes']['skills'])){
            $skill = new Skill;
            $skill->parseData($data['attributes']['skills'], $project_id);
        }

        if(isset($data['attributes']['tags']) && !empty($data['attributes']['tags'])){
            $tag = new Tag;
            $tag->parseData($data['attributes']['tags'], $project_id);
        }
    }

    protected function checkFields($attributes)
    {
        $fields = [];
        $default = [
            'fhunt_id' => 0,
            'name' => '',
            'description' => '',
            'status_id' => 0,
            'budget' => [],
            'bid_count' => 0,
            'is_remote_job' => false,
            'is_premium' => false,
            'is_only_for_plus' => false,
            'location' => [],
            'safe_type' => null,
            'is_personal' => false,
            'employer_id' => 0,
            'freelancer_id' => 0,
            'updates' => [],
            'published_at' => Carbon::now(),
            'expired_at' => Carbon::now(),
        ];

        foreach ($default as $key => $value) {
            switch ($key) {
                case 'status_id':
                    $status_id = $value;
                    $is_save = Status::where('fhunt_id', $attributes['status']['id'])->first();
                    if(empty($is_save)){
                        $model = new Status;
                        $model->fhunt_id = $attributes['status']['id'];
                        $model->name = $attributes['status']['name'];
                        $model->save();

                        $status_id = $model->id;
                    } else{
                        $status_id = $is_save->id;
                    }
                    $fields[$key] = $status_id;
                    break;

                case 'description':
                    $fields[$key] = $attributes['description_html'];
                    break;

                case 'safe_type':
                    $fields[$key] = $attributes[$key];
                    break;

                case 'employer_id':
                    $fields[$key] = Employer::parseData($attributes['employer']);
                    break;

                case 'freelancer_id':
                    $fields[$key] = 0;
                    break;

                case 'published_at':
                    $fields[$key] = Carbon::parse($attributes[$key]);
                    break;

                case 'expired_at':
                    $fields[$key] = Carbon::parse($attributes[$key]);
                    break;

                default:
                    $fields[$key] = isset($attributes[$key]) ? $attributes[$key] : $value;
                    break;
            }
        }

        return $fields;
    }

    protected $casts = [
        'published_at' => 'datetime',
        'expired_at' => 'datetime',
        'budget' => 'array',
        'employer' => 'array',
        'freelancer' => 'array',
        'location' => 'array',
        'updates' => 'array',
    ];

    protected $fillable = ['fhunt_id', 'name', 'description', 'status_id', 'budget', 'bid_count', 'is_remote_job', 'is_premium', 'is_only_for_plus', 'location', 'safe_type', 'is_personal', 'employer_id', 'freelancer_id', 'updates', 'published_at', 'expired_at'];

}
