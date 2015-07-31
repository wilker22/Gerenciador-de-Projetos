<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectService {
	/**
     * @var ProjectRepository
     */
    protected $repository;

    /**
     * @var ProjectValidator
     */
    protected $validator;

    public function __construct(ProjectRepository $repository, ProjectValidator $validator){
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
            return ['error' => true, 'message' => 'Project not found'];
        }
    }

    public function update(array $data, $id){
        $this->_projectExist($id);

    	try{
            $this->repository->find($id);
    		$this->validator->with($data)->passesOrFail();

    		return $this->repository->update($data, $id);
    	} catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Project not found'];
        } catch(ValidatorException $e){
    		return ['error' => true, 'message' => $e->getMessageBag()];
    	}
    }

    public function delete($id){
        try{
            $this->repository->find($id);

            return response()->json($this->repository->delete($id));
        } catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Project not found'];
        }
    }
}
