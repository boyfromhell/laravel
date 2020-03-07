<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['fhunt_id', 'name'];

    public function projects(){
        return $this->belongsToMany(Project::class);
    }

    public function parseData($skills, $project_id)
    {
        foreach ($skills as $skill) {
            $check = $this->where('fhunt_id', $skill['id'])->first();
            if(!empty($check)){
                Project::find($project_id)->skills()->attach($check->id);
            } else {
                $model = new Skill;
                $model->fhunt_id = $skill['id'];
                $model->name = $skill['name'];
                $model->save();
                Project::find($project_id)->skills()->attach($model->id);
            }
        }
    }
}
