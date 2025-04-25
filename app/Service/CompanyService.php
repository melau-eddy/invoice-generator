<?php

namespace App\Service;

use App\Repository\Company\CompanyRepository;
use Illuminate\Support\Facades\Storage;

/**
 * class Company Service
 */
class CompanyService
{
    /**
     * @var CompanyRepository
     */
    protected $companyRepository;

    /**
     * @param CompanyRepository $companyRepository
     */
    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * Retrieves company details
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return $this->companyRepository->all();
    }

    /**
     * Stores the company details
     *
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store($data)
    {
        return $this->companyRepository->store($data);
    }

    /**
     * Get the details of specific company
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function find($id)
    {
        return $this->companyRepository->find($id);
    }

    /**
     * Updates company details
     *
     * @param $id
     * @param $data
     * @return bool
     */
    public function update($id, $data)
    {
        return $this->companyRepository->update($id, $data);
    }

    /**
     * Deletes company details
     *
     * @param $id
     * @return int
     */
    public function destroy($id)
    {
        $company = $this->companyRepository->find($id);
        Storage::disk('uploads')->delete($company->company_image);
        return $this->companyRepository->delete($id);
    }

    /**
     *  Retrieve all company details
     *
     * @param $params
     * @return array|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCompany($params)
    {
        $where = [];
        $orWhere = [];
        if (isset($params['search'])) {
            $search = $params['search'];
            $where = [['name', 'ilike', "%{$search}%"]];
            $orWhere = [['email', 'ilike', "%{$search}%"]];
        }
        $select = ['*'];
        $orderBy = '';
        $order = 1 ? isset($params['order']) and isset($params['sort']) : 0;
        if ($order) {
            $orderBy = [$params['order'], $params['sort']];
        }
        $skip = '';
        $take = '10';

        if (isset($params['page'])) {
            $skip = ($params['page'] - 1) * $take;
        }

        return $this->companyRepository->getCompany($select, $where, $orWhere, $orderBy, $skip, $take);
    }
}
