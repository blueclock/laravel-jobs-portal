<?php
/**
 * Created by PhpStorm.
 * User: andrestntx
 * Date: 3/16/16
 * Time: 10:31 AM
 */

namespace App\Services;


use App\Entities\Company;
use App\Entities\Job;
use App\Repositories\CompanyRepository;
use App\Repositories\Files\CompanyFileRepository;
use Illuminate\Database\Eloquent\Model;

class CompanyService extends ResourceService {

    protected $geoLocationService;
    protected $fileRepository;
    protected $jobService;

    /**
     * CompanyService constructor.
     * @param CompanyRepository $repository
     * @param CompanyFileRepository $fileRepository
     */
    function __construct(CompanyRepository $repository, CompanyFileRepository $fileRepository)
    {
        $this->repository = $repository;
        $this->fileRepository = $fileRepository;
    }

    /**
     * @return mixed
     */
    public function getAuthCompany()
    {
        return $this->repository->findOrFailByUserId(auth()->user()->id);
    }

    /**
     * @param array $data
     * @param $company
     */
    public function validAndSaveLogo(array $data, $company)
    {
        if(array_key_exists('logo', $data)) {
            $this->fileRepository->saveLogo($data['logo'], $company);
        }
    }

    /**
     * @param Company $company
     * @return string
     */
    public function getLogo(Company $company)
    {
        return $this->fileRepository->getLogoUrl($company);
    }

    /**
     * @param Company $company
     * @return mixed
     */
    public function getCompanyJobs(Company $company)
    {
        return $this->repository->getCompanyJobs($company);
    }

    /**
     * @param Company $company
     * @param Job $job
     * @return Model
     */
    public function addNewJob(Company $company, Job $job)
    {
        return $this->repository->saveCompanyJob($company, $job);
    }

}