<div class="col-12">
    <button type="button" class="btn my-5 btn-primary">
        Message <span id="cnt" class="badge badge-light">{{count($message)}}</span>
      </button>

    <ul class="list-group" id="chat">
        @if (isset($message))

            @foreach ($message as $item)
            @if ($item->user->id === Auth::id())
            <li id="{{ $item->id }}" class="list-group-item border-danger  fw-bold my-2 d-flex justify-content-start w-100">
                <p class="w-100 ">{{ $item->message }}</p> <button
                wire:click="delete({{ $item->id }})" class="btn btn-danger btn-sm mr-auto">X</button>
            </li>
            @else
            <li id="{{ $item->id }}" class="list-group-item fw-bold justify-content-end my-2 d-flex w-100">
                <p class="w-100">{{ $item->message }}</p> <button
                wire:click="delete({{ $item->id }})" class="btn btn-danger btn-sm mr-auto">X</button>
            </li>
            @endif
            @endforeach
        @endif
    </ul>
    <form method="POST" wire:submit.prevent="create">
        @csrf
        <div class="d-flex mt-3">
            <div class="w-100">
                <input required type="text" wire:model.defer="messageText" class="form-control d-block w-100">
            </div>
            <button type="submit" class="btn btn-primary" id="sendbtn">SEND</button>
        </div>
    </form>


</div>
<script src="{{ asset('js/app.js') }}"></script>

<script>
    window.Echo.channel('bisnuc')
        .listen('Bisnu', (e) => {

            // Send Message
            var parent = document.getElementById('chat');

            var li = document.createElement('li');
            li.className = "list-group-item d-flex";
            li.id = e.message.id;

            var p = document.createElement("p");
            p.className = "w-100";
            p.innerText = e.message.message;

            var button = document.createElement('button');
            button.setAttribute('wire:click',`delete(${e.message.id})`);
            button.className="btn btn-danger btn-sm mr-auto";
            button.innerText="X";

            li.appendChild(p);
            li.appendChild(button);

            parent.appendChild(li);

            document.getElementById('cnt').innerText=e.lenght;
            console.log(e)
        });


    window.Echo.channel('messageDelete')
        .listen('DeleteMessage', (e) => {
            //Delete Message
            var te = document.getElementById(e.id);
            te.remove();
        });
</script>
