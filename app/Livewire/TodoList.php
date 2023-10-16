<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Todo;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

class TodoList extends Component
{
    use  WithPagination;

    #[Rule('required|min:3|max:50')]

    public $name;

    public $search;

    public function create()
    {
        // validated
        // create the todo
        // clear the input
        // send flash message
        // $this->validate()
        $todo = $this->validateOnly('name');

        Todo::create($todo);

        $this->reset('name');

        session()->flash('success', 'Todo Saved Successfully.');
    }

    public function delete(Todo $todo)
    {
        $todo->delete();
    }

    public function render()
    {
        return view('livewire.todo-list', [
            'todos' => Todo::latest()->where('name', 'like', "%{$this->search}%")->paginate(5)
        ]);
    }
}
