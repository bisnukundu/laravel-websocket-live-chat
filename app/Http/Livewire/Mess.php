<?php

namespace App\Http\Livewire;

use App\Models\Message;
use App\Events\Bisnu;
use App\Events\DeleteMessage;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
class Mess extends Component
{
public $messageText;
    public function create(){

       $message = Message::create([
            'message' => $this->messageText,
            'user_id' => Auth::id()
        ]);
        $ct = Message::count();
        Bisnu::dispatch($message,$ct);
        $this->messageText='';
     }

     public function delete($id){
        Message::destroy($id);
        DeleteMessage::dispatch($id);
     }

    public function render()
    {
        return view('livewire.mess',['message' => Message::all()]);
    }
}
