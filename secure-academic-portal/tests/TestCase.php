<?php

namespace Tests;

use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Setiap tes yang memakai RefreshDatabase mendapat peran & izin Spatie.
     */
    protected bool $seed = true;

    protected string $seeder = RoleAndPermissionSeeder::class;
}
