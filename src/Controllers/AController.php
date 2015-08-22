<?php
namespace Tarach\LSM\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class AController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;
}
