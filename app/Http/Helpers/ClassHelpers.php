<?php

function fakeObject()
{
	return new \App\MyLibrary\MyData([]);
}


function indication()
{
	return new \App\Models\CommonApp\IndicationModel;
}


function carbonParse($date = "0000-00-00")
{
	return \Carbon\Carbon::parse($date);
}


/*
| Helper function for Url
*/
/*=====================Redirect Url=====================*/
function newRedirectUrl($url){

	$newUrlObj = new \App\Http\Controllers\CommonApp\RedirectController;
	return $newUrlObj->newUrl($url);

}

/*=======================follow-ups======================*/

function followUps(){
	$followUpsObj = new \App\Http\Controllers\B2bApp\FollowUpController;
	$followUps = $followUpsObj->all();
	return $followUps;
}

/*=======================follow-ups======================*/
function toDo(){
	$toDoObj = new \App\Http\Controllers\B2bApp\ToDoController;
	$toDo = $toDoObj->all();
	return $toDo;
}


/*=======================follow-ups======================*/
function pendingLeads(){
	$leadsObj = new \App\Http\Controllers\B2bApp\ClientController;
	$leads = $leadsObj->pendingClients();
	return $leads;
}
