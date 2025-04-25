<?php

namespace App\Service;

use App\Repository\Audit\AuditRepository;


/**
 * class Audit Service
 */
class AuditService
{
    /**
     * @var auditRepository
     */
    protected $auditRepository;


    /**
     * AuditService constructor.
     *
     * @param AuditRepository $auditRepository
     */
    public function __construct(AuditRepository $auditRepository)
    {
        $this->auditRepository = $auditRepository;

    }


    /**
     * Retrieves audits of specified user
     *
     * @param $attr
     * @param $value
     * @return Object
     */
    public function findAllBy($attr, $value){
            return $this->auditRepository->findAllBy($attr, $value);
    }
}
