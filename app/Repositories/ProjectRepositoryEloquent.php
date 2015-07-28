<?php

namespace CodeProject\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Entities\Project;

class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(){
        return Project::class;
    }
}