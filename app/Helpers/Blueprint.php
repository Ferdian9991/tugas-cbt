<?php

namespace App\Helpers;

use Illuminate\Database\Schema\Blueprint as BlueprintBase;

class Blueprint extends BlueprintBase
{
    /**
     * Add the proper columns for a loggable table.
     *
     * @param bool $isSoftdelete default false
     * @return void
     */
    public function log(bool $withSoftdelete = false, bool $withUserLog = false): void
    {
        if ($withUserLog) {
            $this->userLog($withUserLog);
        }

        if ($withSoftdelete) {
            $this->softDeletes();
        }

        $this->timestampsTz();
    }

    /**
     * Add the proper columns for a user loggable table.
     * 
     * @return void
     */
    protected function userLog($withSoftdelete): void
    {
        if ($withSoftdelete) {
            $this->bigInteger('deleted_by')->nullable();
            $this->foreign('deleted_by')->references('id')->on('users');
        }

        $this->bigInteger('created_by')->nullable();
        $this->foreign('created_by')->references('id')->on('users');
        $this->bigInteger('updated_by')->nullable();
        $this->foreign('updated_by')->references('id')->on('users');
    }
}
