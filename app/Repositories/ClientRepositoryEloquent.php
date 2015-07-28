<?php

namespace CodeProject\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

use CodeProject\Repositories\ClientRepository;
use CodeProject\Entities\Client;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(){
        return Client::class;
    }
}