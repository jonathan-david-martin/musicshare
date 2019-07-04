<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;

class InstagramController extends ApiController
{
    public function post()
    {
        $validator = \Validator::make(request()->all(), [
            'caption' => 'required',
            'fp' => 'required',
        ]);

        if (! $validator->fails())
        {
            \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
        
            $ig = new \InstagramAPI\Instagram();

            try 
            {
                $loginResponse = $ig->login(config('instagram.username'), config('instagram.password'));

                if ($loginResponse !== null && $loginResponse->isTwoFactorRequired()) 
                {    
                    return $this->error('2FA required.');
                }

                $photo = new \InstagramAPI\Media\Photo\InstagramPhoto(request()->get('fp'));
                $ig->timeline->uploadPhoto($photo->getFile(), ['caption' => request()->get('caption')]);

                return $this->success('Post sent.');
            } 
            catch (\Exception $e) 
            {
                return $this->error('Something went wrong.');
            }
        }
        else return $this->error($validator->errors()->first());        
    }

    public function postVideo()
    {
        $validator = \Validator::make(request()->all(), [
            'caption' => 'required',
            'fp' => 'required',
        ]);

        if (! $validator->fails())
        {
            \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
        
            $ig = new \InstagramAPI\Instagram();

            try 
            {
                $loginResponse = $ig->login(config('instagram.username'), config('instagram.password'));

                if ($loginResponse !== null && $loginResponse->isTwoFactorRequired()) 
                {    
                    return $this->error('2FA required.');
                }

                $video = new \InstagramAPI\Media\Video\InstagramVideo(request()->get('fp'));
                $ig->timeline->uploadVideo($photo->getFile(), ['caption' => request()->get('caption')]);

                return $this->success('Post sent.');
            } 
            catch (\Exception $e) 
            {
                return $this->error('Something went wrong.');
            }
        }
        else return $this->error($validator->errors()->first());        
    }
}