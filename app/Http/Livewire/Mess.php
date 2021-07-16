<?php

namespace App\Http\Livewire;

use App\Models\Message;
use App\Events\Bisnu;
use App\Events\DeleteMessage;
use Livewire\Component;
class Mess extends Component
{
public $messageText;
    public function create(){

       $message = Message::create([
            'message' => $this->messageText
        ]);
        Bisnu::dispatch($message);
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
