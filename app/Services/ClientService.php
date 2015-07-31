<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Repositories\ClientRepository;
use CodeProject\Validators\ClientValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClientService {
    /**
     * @var ProjectRepository
     */
    protected $project_repository;

	/**
     * @var ClientRepository
     */
    protected $repository;

    /**
     * @var ClientValidator
     */
    protected $validator;

    public function __construct(ProjectRepository $project_repository, ClientRepository $repository, ClientValidator $validator){
        $this->project_repository = $project_repository;
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function create(array $data){
    	try{
    		$this->validator->with($data)->passesOrFail();

    		return $this->repository->create($data);
    	} catch(ValidatorException $e){
    		return ['error' => true, 'message' => $e->getMessageBag()];
    	}
    }

    public function show($id){
        try{
            return $this->repository->find($id);
        } catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Client not found'];
        }
    }

    public function update(array $data, $id){
    	try{
            $this->repository->find($id);
    		$this->validator->with($data)->passesOrFail();

    		return $this->repository->update($data, $id);
    	} catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Client not found'];
        } catch(ValidatorException $e){
    		return ['error' => true, 'message' => $e->getMessageBag()];
    	}
    }

    public function delete($id){
        try{
            $client = $this->repository->find($id);
            $projects = $client->projects;

            if($projects){
                foreach ($projects as $project) {
                    $this->project_repository->delete($project->id);
                }
            }

            return response()->json($this->repository->delete($id));
        } catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Client not found'];
        }
    }
}
