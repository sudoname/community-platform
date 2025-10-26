<?php

namespace App\Livewire\Forum;

use App\Models\ForumTopic;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $topics = ForumTopic::with('user', 'category')
            ->active()
            ->paginate(20);

        return view('livewire.forum.index', [
            'topics' => $topics,
        ]);
    }
}
