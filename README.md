# Community Platform - Discord Replacement

A modern, minimalist community platform built with Laravel 12, Livewire 3, and Laravel Reverb to replace Discord server functionality.

## Project Status

**Foundation Complete** - The project structure, database schema, models, and component scaffolding are complete. Implementation of features is in progress.

## Tech Stack

- **Backend**: Laravel 12.28.1 (PHP 8.3)
- **Frontend**: Livewire 3.6.4 with Volt
- **Real-time**: Laravel Reverb 1.6.0 (WebSockets)
- **Authentication**: Laravel Breeze with Livewire
- **Styling**: Tailwind CSS
- **Database**: SQLite (development)

## Features

### Completed ✅

- **Project Setup**
  - Laravel 12 with Livewire and Reverb installed
  - Git repository initialized
  - Environment configured with app key and Reverb settings

- **Database Schema**
  - Users table with role system (admin, paid_member, free_member)
  - Channels table for Discord-like chat channels
  - Messages table for real-time chat with replies and attachments
  - Forum categories, topics, and posts tables
  - Files table with polymorphic relationships
  - Subscriptions table for payment integration
  - Notifications table for real-time alerts

- **Models & Relationships**
  - All 8 models created with full relationships
  - Role helper methods (isAdmin(), isPaidMember(), isFreeMember())
  - Scopes for filtering (active, published, ordered)
  - Auto-slug generation for channels, categories, and topics

- **Authentication**
  - Laravel Breeze installed with Livewire
  - Registration, login, password reset flows
  - Profile management

- **Database Seeders**
  - 3 test users (admin, premium, free member)
  - 5 chat channels (including premium-only channel)
  - 6 forum categories

- **Livewire Components (Scaffolded)**
  - Chat: Index, ChannelList, MessageList, MessageForm
  - Forum: Index, CategoryList, TopicList, TopicShow, CreateTopic

### In Progress 🚧

- Implement Chat functionality
- Implement Forum functionality
- Integrate Reverb for real-time messaging
- Create file upload functionality
- Design minimalist UI with Tailwind

### Pending 📋

- Admin dashboard for content management
- Subscription tiers and payment integration (Stripe)
- Real-time notifications
- User profiles with avatars and bios
- Search functionality
- Mobile responsive design

## Database Structure

### Users
- Role-based access (admin, paid_member, free_member)
- Subscription tier tracking
- Avatar and bio support

### Channels (Chat)
- Public and private channels
- Role-based access control
- Display ordering
- Text and announcement types

### Messages
- Channel-based messaging
- Reply threading
- File attachments (JSON array)
- Pin and edit functionality

### Forums
- Categories with icons
- Topics with pinning and locking
- Threaded replies
- View and reply counts

### Files
- Polymorphic uploads (attach to messages, posts, etc.)
- File type tracking (image, video, document)
- Public/private visibility

### Subscriptions
- Multiple plans (free, basic, premium)
- Stripe integration ready
- Trial period support
- Billing intervals (monthly, yearly)

## Installation

1. **Clone the repository**
```bash
git clone <repository-url>
cd community-platform
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Configure environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Set up database**
```bash
php artisan migrate:fresh --seed
```

5. **Build assets**
```bash
npm run dev
```

6. **Start development servers**
```bash
# Terminal 1 - Laravel
php artisan serve

# Terminal 2 - Reverb (WebSockets)
php artisan reverb:start

# Terminal 3 - Vite (Asset building)
npm run dev
```

## Test Accounts

After running the seeders, you can log in with these accounts:

- **Admin**: admin@community.test / password
- **Premium Member**: premium@community.test / password
- **Free Member**: free@community.test / password

## Git Commits

The project has been developed incrementally with clear commits:
1. Initial commit with Laravel base and database schema
2. Laravel Breeze with Livewire authentication
3. Database seeders and Livewire component scaffolding

## Next Steps

1. Implement Chat/Index.php with channel switching
2. Build MessageList component with real-time updates
3. Create MessageForm for sending messages
4. Implement Forum topic creation and viewing
5. Add Reverb broadcasting for real-time chat
6. Design minimalist UI with Tailwind
7. Create admin dashboard for channel/category management

## File Structure

```
app/
├── Livewire/
│   ├── Chat/
│   │   ├── Index.php           # Main chat interface
│   │   ├── ChannelList.php     # Sidebar channel list
│   │   ├── MessageList.php     # Messages display
│   │   └── MessageForm.php     # Send message form
│   └── Forum/
│       ├── Index.php            # Forum home
│       ├── CategoryList.php     # Forum categories
│       ├── TopicList.php        # Topics in category
│       ├── TopicShow.php        # View topic & replies
│       └── CreateTopic.php      # Create new topic
├── Models/
│   ├── User.php                 # User with roles
│   ├── Channel.php              # Chat channels
│   ├── Message.php              # Chat messages
│   ├── ForumCategory.php        # Forum categories
│   ├── ForumTopic.php           # Forum topics
│   ├── ForumPost.php            # Forum replies
│   ├── File.php                 # File uploads
│   └── Subscription.php         # Payment subscriptions
```

## License

This is a custom-built community platform project.
