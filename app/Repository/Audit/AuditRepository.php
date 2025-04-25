<?php

namespace App\Repository\Audit;

use App\Repository\Repository;
use OwenIt\Auditing\Models\Audit;


/**
 * Class Audit Repository
 */
class AuditRepository extends Repository
{
    /**
     * Retrieves the model name
     *
     * abstract method
     *
     * @return string
     */
    public function getModel(): string
    {
        return Audit::class;
    }


}
