<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    public function getTitleAttribute(){
        return "{$this->first_name} {$this->last_name} ({$this->login})";
    }

    public static function parseData($data)
    {
        $employer_id = 0;
        $fields = self::checkFields($data);
        $fields['fhunt_id'] = $data['id'];
        $is_save = self::where('fhunt_id', $data['id'])->first();
        if(empty($is_save)){
            $create = self::create($fields);
            $employer_id = $create->id;
        } else {
            $is_save->fill($fields);
            $is_save->save();
            $employer_id = $is_save->id;
        }

        return $employer_id;
    }

    protected static function checkFields($attributes)
    {
        $fields = [];
        $default = [
            'login' => '',
            'first_name' => '',
            'last_name' => '',
            'avatar' => [],
        ];

        foreach ($default as $key => $value) {
            switch ($key) {
                case 'cv':
                    $fields[$key] = $attributes['cv_html'];
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
        'avatar' => 'array',
        'employer' => 'array',
        'freelancer' => 'array',
        'location' => 'array',
        'updates' => 'array',
    ];

    protected $fillable = ['fhunt_id', 'login', 'first_name', 'last_name', 'avatar'];

}
