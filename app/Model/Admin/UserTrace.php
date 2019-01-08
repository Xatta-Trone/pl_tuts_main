<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class UserTrace extends Model
{

	protected $guarded = [];

    public function user(){
    	return $this->belongsTo('App\Model\User\User');
    }

    public function getLocationInfo()
    {
    	$location_raw = json_decode($this->location_info);
    	return $location_raw->city.','.$location_raw->countryCode.'('.$location_raw->isp.')';
    }


    public function getDeviceInfo()
    {
    	$browser_raw = json_decode($this->browser_info);
    	return '<strong>'.$browser_raw->browserName.'</strong> on <strong>'.$browser_raw->platformName.'</strong> From <strong>'.$this->getDeviceType($browser_raw).'</strong>';
    }


    public function getDeviceType($browser_raw)
    {
    	switch ($browser_raw) {
    		case $browser_raw->isMobile:
    			return'Mobile('.$browser_raw->deviceFamily.')';
    			break;
    		case $browser_raw->isDesktop:
    			return'Desktop/laptop';
    			break;
    		case $browser_raw->isTablet:
    			return'Tablet('.$browser_raw->deviceFamily.')';
    			break;
    		case $browser_raw->isBot:
    			return'Bot';
    			break;
    		
    		default:
    			return 'Unable to detect';
    			break;
    	}
    }


        
}
