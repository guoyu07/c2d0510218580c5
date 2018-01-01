<?php

namespace App\Models\TravelerApp;

use Illuminate\Database\Eloquent\Model;

class GuestDetailModel extends Model
{
	protected $connection = 'mysql9';
	protected $table = 'guest_details';
	protected $appends = ['pax_type', 'fullname'];


	public function getPaxTypeAttribute()
	{
		return $this->age > 12 ? 1 : 2;
	}


	public function getFullnameAttribute()
	{
		return $this->firstname.' '.$this->lastname;
	}


	public function scopeByWhichRoom($query, $whichRoom)
	{
		return $query->where('which_room', '=', $whichRoom);
	}


	public function scopeByLeadPassenger($query, $lead = 1)
	{
		return $query->where('lead_passenger', '=', $lead);
	}


	public function forTbtq()
	{
		return [
				"Title" => $this->title,
				"FirstName" => $this->firstname,
				"Middlename" => null,
				"LastName" => $this->lastname,
				"Phoneno" => $this->phone,
				"Email" => $this->email,
				"PaxType" => $this->pax_type,
				"LeadPassenger" => (bool) $this->lead_passenger,
				"Age" => $this->age,
				"PassportNo" => $this->passport_no,
				"PassportIssueDate" => $this->passport_issue_date,
				"PassportExpDate" => $this->passport_expiry_date,
			];
	}


}
