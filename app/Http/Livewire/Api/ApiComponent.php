<?php

namespace App\Http\Livewire\Api;

use Livewire\Component;
use Mail;
use App\Models\User;
use App\Mail\SendBearerTokenMailable;
use App\Models\ApplicationRegistration;
use App\Mail\RevokeBearerTokenMailable;

class ApiComponent extends Component
{
  public $bearer_token;
  public $token_status;
  public $search = '';
  public $view_option;
  public $perPage = 10;
  public $orderBy = 'created_at';
  public $orderAsc = 0;

  public function findEntry($id)
  {
    $entry_id = ApplicationRegistration::findOrFail($id);

    return $entry_id;
  }

  public function addEntry()
  {
    $this->dispatchBrowserEvent('swal:modal', [
    'type' => 'error',
    'message' => 'Not Allowed',
    'text' => 'This functionality is disabled for this module',
    ]);
  }

  public function export()
  {
    $this->dispatchBrowserEvent('swal:modal', [
    'type' => 'warning',
    'message' => 'Not Enabled',
    'text' => 'This functionality is not yet enabled for this module',
    ]);
  }

  public function approveRequest($id)
  {
    $application = $this->findEntry($id);
    $application->status = 1;
    $application->date_approved = date("Y-m-d H:i:s");
    $application->approved_by = \Auth::user()->id;
    dd($application);
    $application->update();
    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Request successfully approved & Email sent to requestor']);

    $user = User::findOrFail($application->client?->user_id);
    $mail_content = [
      'app_name' => $user->name,
      'client_id' => $application->oauth_client_id,
      'bearer_token' => $application->bearer_token
    ];

    try {
      $admin_email = $user->email;
      Mail::to(["$admin_email"])
      // Mail::to(["benbyron24@gmail.com"])
      ->queue(new SendBearerTokenMailable($mail_content));
    } catch (\Exception $e) {
      // dd($e);
      \Log::info($e);
    }
  }

  public function revokeBearerToken($id)
  {
    $application = $this->findEntry($id);

    $application->status = 2;
    $application->date_revoked = date("Y-m-d H:i:s");
    $application->revoked_by = \Auth::user()->id;
    $application->update();

    $user = User::findOrFail($application->client?->user_id);

    //revoking bearer token
    $client = $application->oauth_client_id;
    $oauth_client = \DB::table('oauth_clients')
    ->where('id',$client)
    ->get(['user_id']);

    \DB::table('oauth_access_tokens')
    ->where('user_id',$oauth_client[0]->user_id)
    ->update(['revoked' => 1]);

    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Successfully revoked bearer token']);

    try {
      $admin_email = $user->email;
      Mail::to(["$admin_email"])
      // Mail::to(["benbyron24@gmail.com"])
      ->queue(new RevokeBearerTokenMailable($mail_content));
    } catch (\Exception $e) {
      // dd($e);
      \Log::info($e);
    }

  }

  public function viewBearerToken($id)
  {
    $application = $this->findEntry($id);
    $this->bearer_token = $application->bearer_token;
    $this->token_status = $application->status;

    $this->dispatchBrowserEvent('view-bearer-token-modal');
  }

  public function mainQuery()
  {
    return ApplicationRegistration::search($this->search)
    ->when($this->view_option === '0', function ($query) {
      $query->where('status',0);
    })
    ->when($this->view_option === '1', function ($query) {
      $query->where('status','1');
    })
    ->when($this->view_option === '2', function ($query) {
      $query->where('status','2');
    })
    ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
  }

  public function render()
  {
    $data['applications'] =  $this->mainQuery()->paginate($this->perPage);
    return view('livewire.api.api-component',$data);
  }

}
