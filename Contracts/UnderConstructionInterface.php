<?php

namespace Modules\UnderConstruction\Contracts;

interface UnderConstructionInterface
{
    /**
     * Get the current "under construction" status.
     *
     * @return bool
     */
    public function getConstructionStatus(): bool;

    /**
     * Set the "under construction" status.
     *
     * @param bool $status
     * @return void
     */
    public function setConstructionStatus(bool $status): void;

    /**
     * Retrieve the access key.
     *
     * @return string
     */
    public function getAccessKey(): string;

    /**
     * Set the access key.
     *
     * @param string $key
     * @return void
     */
    public function setAccessKey(string $key): void;
}
