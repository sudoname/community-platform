<?php

namespace App\Livewire\Forum;

use App\Models\ForumTopic;
use App\Models\ForumPost;
use Livewire\Component;

class TopicShow extends Component
{
    public $topic;
    public $posts = [];
    public $newPostContent = '';

    // Edit properties for topic
    public $editingTopicId = null;
    public $editTopicTitle = '';
    public $editTopicContent = '';

    // Edit properties for posts
    public $editingPostId = null;
    public $editPostContent = '';

    public function mount($slug)
    {
        $this->topic = ForumTopic::where('slug', $slug)
            ->with('user', 'category')
            ->firstOrFail();

        $this->loadPosts();

        // Increment view count
        $this->topic->increment('views_count');
    }

    public function loadPosts()
    {
        $this->posts = ForumPost::with('user', 'replyTo.user')
            ->where('topic_id', $this->topic->id)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function addPost()
    {
        $this->validate([
            'newPostContent' => 'required|min:1',
        ]);

        ForumPost::create([
            'topic_id' => $this->topic->id,
            'user_id' => auth()->id(),
            'content' => $this->newPostContent,
        ]);

        $this->newPostContent = '';
        $this->loadPosts();
    }

    // Edit Topic Methods
    public function startEditTopic()
    {
        if (!auth()->user()->isAdmin()) {
            return;
        }

        $this->editingTopicId = $this->topic->id;
        $this->editTopicTitle = $this->topic->title;
        $this->editTopicContent = $this->topic->content;
    }

    public function saveEditTopic()
    {
        if (!auth()->user()->isAdmin()) {
            return;
        }

        $this->validate([
            'editTopicTitle' => 'required|min:3',
            'editTopicContent' => 'required|min:1',
        ]);

        $this->topic->update([
            'title' => $this->editTopicTitle,
            'content' => $this->editTopicContent,
        ]);

        $this->editingTopicId = null;
        $this->editTopicTitle = '';
        $this->editTopicContent = '';

        // Reload topic
        $this->topic = ForumTopic::find($this->topic->id);
    }

    public function cancelEditTopic()
    {
        $this->editingTopicId = null;
        $this->editTopicTitle = '';
        $this->editTopicContent = '';
    }

    public function deleteTopic()
    {
        if (!auth()->user()->isAdmin()) {
            return;
        }

        ForumTopic::destroy($this->topic->id);

        return redirect()->route('forums');
    }

    // Edit Post Methods
    public function startEditPost($postId, $content)
    {
        if (!auth()->user()->isAdmin()) {
            return;
        }

        $this->editingPostId = $postId;
        $this->editPostContent = $content;
    }

    public function saveEditPost($postId)
    {
        if (!auth()->user()->isAdmin()) {
            return;
        }

        $post = ForumPost::find($postId);
        if ($post) {
            $post->update([
                'content' => $this->editPostContent,
                'is_edited' => true,
                'edited_at' => now(),
            ]);
        }

        $this->editingPostId = null;
        $this->editPostContent = '';
        $this->loadPosts();
    }

    public function cancelEditPost()
    {
        $this->editingPostId = null;
        $this->editPostContent = '';
    }

    public function deletePost($postId)
    {
        if (!auth()->user()->isAdmin()) {
            return;
        }

        ForumPost::destroy($postId);
        $this->loadPosts();
    }

    public function render()
    {
        return view('livewire.forum.topic-show');
    }
}
