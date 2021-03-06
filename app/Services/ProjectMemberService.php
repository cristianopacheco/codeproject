<?php
namespace CodeProject\Services;

use CodeProject\Validators\ProjectMemberValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use CodeProject\Repositories\ProjectMemberRepository;


class ProjectMemberService
{
    /**
     * 
     * @var ProjectMemberRepository
     */
    protected $repository;
    
    /**
     * 
     * @var ProjectMemberValidator
     */
    protected $validator;
    
    public function __construct(ProjectMemberRepository $repository, ProjectMemberValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
    
    public function create(array $data)
    {
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        }catch (ValidatorException $e)
        {
            return [
                'error'=>true, 
                'message'=>$e->getMessageBag()
            ];
        }
        
    }

    public function show($id)
    {
        try {
            return $this->repository->find($id);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => 'Registro não encontrado.'
            ];
        }
    }

    public function delete($id)
    {
        try {
            
            if($this->repository->delete($id)){
                return [
                    'error' => false,
                    'message' => 'Registro deletado com sucesso.'
                ];
            }
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => 'Não foi possivel deletar o registro.'
            ];
        }
    }
}
