<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\PreparesJSONResponses;
use Illuminate\Foundation\Bus\DispatchesJobs;

class ApiController extends Controller
{
    use PreparesJSONResponses, DispatchesJobs;

    protected $data;

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function getIpAddress()
    {
        if ($ip = \Request::header('X-Forwarded-For')) 
            return $ip;
        else
            return \Input::getClientIp();
    }

    public function getPhone()
    {
        if (\Input::has('uuid'))
        {
            if ($phone = \App\Phone::uuid(\Input::get('uuid'))->domain(\Input::get('domain'))->first()) 
            {
                return $phone;
            }
            else return null;
        }
        else return null;
    }

    public function error($message = 'An unknown error has occured.', $statusCode = 404, $redirect = null)
    {
        return $this->respondWithError(collect(trans($message))->first(), $statusCode);
    }

    public function success($message = 'Success.', $statusCode = 200, $redirect = null)
    {
        return $this->respondWithData(['success' => ['result' => true, 'message' => trans($message)]], $statusCode);
    }

    public function present()
    {
        return $this->respondWithData($this->data);
    }
}