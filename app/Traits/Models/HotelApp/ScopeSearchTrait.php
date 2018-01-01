<?php 

namespace App\Traits\Models\HotelApp;

trait ScopeSearchTrait 
{
    
	public function scopeBySearch($query, $word = '')
	{
		return $query->where($this->searchColumnName, 'like', '%'.$word.'%');
	}


	public function scopeBySearchSemiBroad($query, $word = '')
	{
		$semiBroad = '%'.implode('%', explode(' ', $word)).'%';
		return $query->where($this->searchColumnName, 'like', $semiBroad);
	}

	public function scopeBySearchBroad($query, $word = '')
	{
		$broad = '%'.wordwrap($word, 1, '%', true).'%';
		return $query->where($this->searchColumnName, 'like', $broad);
	}


	public function scopeBySearchCases($query, $word)
	{
		$semiBroad = '%'.implode('%', explode(' ', $word)).'%';
		$broad = '%'.wordwrap($word, 1, '%', true).'%';

		return $query->whereRaw(
						'(case
	           when '.$this->searchColumnName.' like \'%'.$word.'%\' then 1
	           when '.$this->searchColumnName.' like \''.$semiBroad.'\' then 1
	           when '.$this->searchColumnName.' like \''.$broad.'\' then 1   
	           else null
	           end)'
		      );
	}

}
