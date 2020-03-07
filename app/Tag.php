<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['fhunt_id', 'name'];

    public function projects(){
        return $this->belongsToMany(Project::class);
    }

    public function parseData($tags, $project_id)
    {
        foreach ($tags as $tag) {
            $check = $this->where('fhunt_id', $tag['id'])->first();
            if(!empty($check)){
                Project::find($project_id)->tags()->attach($check->id);
            } else {
                $model = new Tag;
                $model->fhunt_id = $tag['id'];
                $model->name = $tag['name'];
                $model->save();
                Project::find($project_id)->tags()->attach($this->id);
            }
        }
    }
}
